<?php

namespace app\controllers;

use Illuminate\Validation\Validator;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\IpTable;
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

        //判断ip
       /* $ip1 = $_SERVER['SERVER_ADDR'];
        $ip_data = Iptable::find()->select('ip_name')->asArray()->all();
        foreach($ip_data as $v){
            $ip[] = $v['ip_name'];
        }
        if(!in_array($ip1,$ip)){
            echo "<script>alert('此ip不允许访问');location.href='index.php?r=login/index'</script>";
        }*/

        $user_data = \Yii::$app -> request -> post();
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
            if(md5($user_data['upwd'])==$bool_uname['upwd']){
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

    /*
     * 发送邮件
     */
    public function  actionSend()
    {

        $user_data = \Yii::$app -> request -> post();

        //验证码的验证
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

        $bool = User::find() -> where(['uname'=>$user_data['uname']]) -> orWhere(['email'=>$user_data['uname']]) ->asArray() -> one();
        if($bool){
            $key = md5($bool['uname']."+".$bool['upwd']);
            $string=base64_encode($bool['uname']."+shen");
            $now_time=base64_encode(time()."+shen");
            $url = substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,strpos('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'we'))."wei_e/web/index.php?r=login/update&key=$key&string=$string&time=$now_time";
           $bool = Yii::$app->mailer->compose()
                ->setFrom('m18612193548@163.com')
                ->setTo($bool['email'])
                ->setSubject('Message subject')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<b>'.$url.'</b>')
                ->send();
            if($bool){
                echo "<script>alert('发送成功');location.href='https://mail.qq.com/'</script>";
            }
        }
    }

    /*
     * 修改密码
     */
    public function actionUpdate()
    {
        if(\Yii::$app->request->isGet) {
            $update_data = \Yii::$app->request->get();
            // print_r($update_data);die;
            $str = base64_decode($update_data['string']);
            $time = base64_decode($update_data['key']);
            $uname = explode('+', $str);
            $time = explode('+', $time);
            $user_data = User::find()->where(['uname' => $uname])->asArray()->one();
            $key = md5($user_data['uname'] . "+" . $user_data['upwd']);
            if ($key == $update_data['key'] && time() - $time[0] > 3600) {
                return $this->renderPartial('update', ['uname' => $user_data['uname']]);
            } else {
                echo "<script>alert('链接失效');location.href='index.php?r=login/index'</script>";
            }
        }else {
            $user_data1 = \Yii::$app->request->post();
//            print_r($user_data1);die;

            $model = User::find()->where(['uname' => $user_data1['uname']]) ->one();
            $model -> upwd = md5($user_data1['upwd1']);
//            $model -> attributes = \Yii::$app->request->post();
           // $model -> upwd = $user_data1['pwd'];
            if($user_data1['upwd']==$user_data1['upwd1']){
                $bool = $model->save();
                if($bool){
                    echo "<script>alert('修改成功');location.href='index.php?r=login/index'</script>";
                }
            }else{
                $error_data = $model -> getErrors();
                return $this -> renderPartial('update',['error_data'=>$error_data]);
            }
        }
    }

    /*
     *  检测是否存在
     */
    public function actionCheck_uname()
    {
        $uname = \Yii::$app -> request -> get('uname');
        $bool = User::find() -> where(['uname'=>$uname]) -> orWhere(['email'=>$uname]) ->asArray() -> one();
        if($bool){
            echo 1;
        }else{
            echo 0;
        }
    }

    /*
     * 退出
     */
    public function actionLogout()
    {
        $session = \YII::$app->session;
        $session->open();
        $session->remove("uname");
        $session->remove("uid");
        $this->redirect(array('login/index'));
    }
}