<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class LoginController extends Controller
{
    /*
     *  加载登录页面
     */
    public function actionIndex()
    {
        return $this -> renderPartial('login');
    }

    /*
     *  执行登录
     */
    public function actionLogin()
    {

        $user_data = \Yii::$app->request->post();
        $bool_uname = User::find() -> where(['uname'=>$user_data['uname']]) -> asArray() -> one();
        if($bool_uname){
            if($user_data['upwd']==$bool_uname['upwd']){
                //判断时间是否已到
                $session = \YII::$app->session;
                $session->open();
                $now_time = $session->get('now_time'.$bool_uname['uid']);
                if(time() - $now_time < 20){
                    echo "<script>alert('着么子急，再等会儿');location.href='index.php?r=login/index'</script>";
                    die;
                }
                $session = \YII::$app->session;
                $session->open();
                $session->set('uid',$bool_uname['uid']);
                $session->set('uname',$bool_uname['uname']);
                $session->remove('now_time'.$bool_uname['uid']);
                $session->remove('num_'.$bool_uname['uid']);
                return $this -> redirect(array('index/index'));
            }else{
                $session = \YII::$app->session;
                $session->open();
                $num = $session->get('num_'.$bool_uname['uid']);
                if($num+1>=3){
                    $now_time = time();
                    $session->set('now_time'.$bool_uname['uid'],$now_time);
                    echo "<script>alert('密码已输入超限，20秒后再来登录');location.href='index.php?r=login/index'</script>";
                }else{
                    $session->set('num_'.$bool_uname['uid'],$num+1);
                    echo '<script>alert("密码输入错误，还剩'.(2-$num).'次");location.href="index.php?r=login/index"</script>';
                }
            }

        }else{
            echo "<script>alert('用户名错误');location.href='index.php?r=login/index'</script>";
        }
    }

    public function actions()
    {
        return  [
//                 'captcha' =>
//                    [
//                        'class' => 'yii\captcha\CaptchaAction',
//                        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//                    ],  //默认的写法
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0x000000,//背景颜色
                'maxLength' => 6, //最大显示个数
                'minLength' => 5,//最少显示个数
                'padding' => 5,//间距
                'height'=>40,//高度
                'width' => 130,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4,        //设置字符偏移量 有效果
                //'controller'=>'login',        //拥有这个动作的controller
            ],
        ];
    }

    public function  actionSend()
    {

        Yii::$app->mailer->compose()
            ->setFrom('m18612193548@163.com')
            ->setTo('1244426046@qq.com')
            ->setSubject('Message subject')
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>傻蛋</b>')
            ->send();
    }
}