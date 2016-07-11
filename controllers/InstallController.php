<?php

namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class InstallController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex(){
       //安装界面如果安装好之后生成一个php文件 文件如果存在则跳到登录界面
        if(is_file("assets/existence.php")){
            $this->redirect(array('/login/login'));
        }else{
            return $this->renderPartial("one");
        }
    }
    public function actionOne(){
        return $this->renderPartial("index");
    }
    public function actionTwo(){
        return $this->renderPartial("three");
    }
    public function actionCheck(){
        $post=\Yii::$app->request->post();
        $host=$post['dbhost'];
        $name=$post['dbname'];
        $pwd=$post['dbpwd'];
        $db=$post['db'];
       $uname=$post['uname'];
       $upwd=$post['upwd'];

        if (@$link= mysql_connect("$host","$name","$pwd")){
            $db_selected = mysql_select_db("$db", $link);
                if($db_selected){
                    $sql="drop database ".$post['db'];
                    mysql_query($sql);
                }
                $sql="create database ".$post['db'];
                mysql_query($sql);
                $file=file_get_contents('./assets/we3.sql');
                $arr=explode('-- ----------------------------',$file);
                $db_selected = mysql_select_db($post['db'], $link);
                for($i=0;$i<count($arr);$i++){
                    if($i%2==0){
                        $a=explode(";",trim($arr[$i]));
                        array_pop($a);
                        foreach($a as $v){
                            mysql_query($v);
                        }
                    }
                }
                $str="<?php
					return [
						'class' => 'yii\db\Connection',
						'dsn' => 'mysql:host=".$post['dbhost'].";port=3306;dbname=".$post['db']."',
						'username' => '".$post['dbname']."',
						'password' => '".$post['dbpwd']."',
						'charset' => 'utf8',
						'tablePrefix' => 'we_',   //加入前缀名称we_
					];";
                file_put_contents('../config/db.php',$str);
            $str1="<?php
                \$pdo=new PDO('mysql:host= $host;port=3306;dbname=$db','$name','$pwd',array(PDO::MYSQL_ATTR_INIT_COMMAND=>'set names utf8'));
                   ?>";
            file_put_contents('./assets/abc.php',$str1);
               $sql="insert into we_user (uname,upwd) VALUES ('$uname','$upwd')";
                mysql_query($sql);
            mysql_close($link);
            $counter_file       =   'assets/existence.php';//文件名及路径,在当前目录下新建aa.txt文件
            $fopen                     =   fopen($counter_file,'wb');//新建文件命令
            fputs($fopen,   'aaaaaa ');//向文件中写入内容;
            fclose($fopen);
            $strs=str_replace("//'db' => require(__DIR__ . '/db.php'),","'db' => require(__DIR__ . '/db.php'),",file_get_contents("../config/web.php"));
            file_put_contents("../config/web.php",$strs);
            $this->redirect(array('/login/login'));
        }else{
            echo "<script>
                        if(alert('数据库账号或密码错误')){
                             location.href='index.php?r=install/two';
                        }else{
                            location.href='index.php?r=install/two';
                        }
            </script>";
        }
    }
}