<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use Vcode;
use yii\captcha\CaptchaValidator;

class LoginController extends Controller
{
   public function init()
    {
        parent::init();
        $session = \YII::$app->session;
        $session->open();
        $user_name = $session->get('uname');
        if (!empty($user_name)) {
            echo "<script>location.href='index.php?r=index/index'</script>";
            //$this-> redirect(array('index/index'));
        }
    }
    /*
     *  加载登录页面
     */
    public function actionIndex()
    {
        return $this -> renderPartial('login');
    }

    /*
     *  生成验证码
     */
    public function actionVcode()
    {
        session_start();
        $vcode = new Vcode(80, 30, 4);
        //将验证码放到服务器自己的空间保一份
        $session = \YII::$app->session;
        $session->open();
        $session->set('code',$vcode->getcode());
        //将验证码图片输出
        $vcode->outimg();
    }

    /*
     *  执行登录
     */
    public function actionLogin()
    {


        /*$caprcha = new CaptchaValidator();
        var_dump($caprcha);
        echo \Yii::$app->request->post('verifyCode');
        var_dump($caprcha->validate(\Yii::$app->request->post('verifyCode')));die;*/
        $user_data = \Yii::$app->request->post();

        $validate="";
        if(isset($user_data['verifyCode'])){
            $session = \YII::$app->session;
            $session->open();
            $validate = $session->get('code');
            if(strtolower($validate)!=strtolower($user_data['verifyCode'])){
                //判断session值与用户输入的验证码是否一致;
                echo "<script>alert('验证码输入有误');location.href='index.php?r=login/index'</script>";
                die;
            }
        }


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
                    echo '<script>alert("密码输入错误啊，还剩'.(2-$num).'次");location.href="index.php?r=login/index"</script>';
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
                'fixedVerifyCode' => YII_ENV_TEST ? 'verifyCode' : null,
                'backColor'=>2552550,//背景颜色
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
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
    public function actionLogout()
    {
        $session = \YII::$app->session;
        $session->open();
        $session->remove("uname");
        $session->remove("uid");
        $this->redirect(array('login/index'));
    }
}