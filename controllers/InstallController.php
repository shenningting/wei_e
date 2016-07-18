<?php

namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use CheckConfig;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class InstallController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex(){
       //安装界面如果安装好之后生成一个php文件 文件如果存在则跳到登录界面
        if(is_file("assets/existence.php")){
            $this->redirect(array('/login/index'));
        }else{
            return $this->renderPartial("one");
        }
    }
    public function actionOne(){
        $checkObj=new CheckConfig;
        return $this->renderPartial("index",['checkObj'=>$checkObj]);
    }
    public function actionTwo(){
        return $this->renderPartial("three");
    }
    public function actionCheck(){
        $post=\Yii::$app->request->post();
        $host=$post['dbhost'];
        $host_arr = explode(':',$host);
        //print_r($str);die;
        $name=$post['dbname'];
        $pwd=$post['dbpwd'];
        $db=$post['db'];
        $uname=$post['uname'];
        $email=$post['email'];
        $upwd=$post['upwd'];
        //echo $name,$pwd;die;
        if (@$link= mysql_connect("$host","$name","$pwd")){
            $db_selected = mysql_select_db("$db", $link);
                if($db_selected){
                    $sql="drop database ".$post['db'];
                    mysql_query($sql);
                }
                $sql="create database ".$post['db'];
                mysql_query($sql);
                $file=file_get_contents('./assets/yii.sql');
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


            //修改表前缀
          /* if($dbtem!='we_'){
                $user = $name;                       //数据库用户名
                $pwd = $pwd;                         //数据库密码
                $replace =$dbtem;                     //替换后的前缀
                $seach = 'we_';                     //要替换的前缀
                $link =  mysql_connect("$host","$user","$pwd");         //连接数据库

                $sql = 'SELECT TABLE_NAME,TABLE_ROWS FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='."$db".'';
                $result = mysql_query($sql);
               $tables = mysql_list_tables("$db");
               while($name = mysql_fetch_array($tables)) {

                   $table = 'we_'.$name['0'];

                   mysql_query("rename table $name[0] to $table");
               }
            }*/


                $str="<?php
					return [
						'class' => 'yii\db\Connection',
						'dsn' => 'mysql:host=".$host_arr[0].";port=$host_arr[1];dbname=".$post['db']."',
						'username' => '".$post['dbname']."',
						'password' => '".$post['dbpwd']."',
						'charset' => 'utf8',
						'tablePrefix' => 'we_',   //加入前缀名称we_
					];";
                file_put_contents('../config/db.php',$str);

            $str1="<?php
            \$pdo=new PDO('mysql:host=$host_arr[0];dbname=$db','root','$pwd');
            ?>";

            file_put_contents('./assets/abc.php',$str1);
            $newpwd = md5($upwd);
            $sql1="insert into we_user(uname,upwd,email) VALUES ('$uname','$newpwd','$email')";
            mysql_query($sql1);

            $ip1 = $_SERVER['SERVER_ADDR'];
            $sql="insert into we_ip_table(ip_name)VALUES ('$ip1')";
            mysql_query($sql);

            mysql_close($link);
            $counter_file       =   'assets/existence.php';//文件名及路径,在当前目录下新建aa.txt文件
            $fopen                     =   fopen($counter_file,'wb');//新建文件命令
            fputs($fopen,   'aaaaaa ');//向文件中写入内容;
            fclose($fopen);
            $strs=str_replace("//'db' => require(__DIR__ . '/db.php'),","'db' => require(__DIR__ . '/db.php'),",file_get_contents("../config/web.php"));
            file_put_contents("../config/web.php",$strs);
            $this->redirect(array('/login/index'));
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