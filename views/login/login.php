<?php
use yii\captcha\Captcha;
?>
<!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">

    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
	<title>后台登陆</title>
</head>
<body>
	<div id="login_top">
		<div id="welcome">
			欢迎使用微信管理系统
		</div>
		<div id="back">
			<a href="#">返回首页</a>&nbsp;&nbsp; | &nbsp;&nbsp;
			<a href="#">帮助</a>
		</div>
	</div>
	<div id="login_center">
		<div id="login_area">
			<div id="login_form">
				<form action="index.php?r=login/login" method="post">
					<div id="login_tip">
						用户登录&nbsp;&nbsp;UserLogin
					</div>
                    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken?>"/>
					<div><input type="text" class="username" name="uname"></div>
					<div><input type="password" class="pwd" name="upwd"></div>
					<div id="btn_area">
						<input type="submit" id="sub_btn" value="登&nbsp;&nbsp;录">&nbsp;&nbsp;
						<input type="text" class="verify" name="verifyCode">
						<!--<img src="index.php?r=login/captcha" alt="点我换一张" title="点我换一张" width="80" height="40" onclick=this.src="index.php?r=login/captcha&rand="+Math.random(1000,9999)>
                        --><?php /*echo Captcha::widget(['name'=>'','captchaAction'=>'login/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;'],'template'=>'{image}']); */?>
                        <img src="index.php?r=login/vcode" alt="点我换一张" title="点我换一张" width="80" height="40" onclick=this.src="index.php?r=login/vcode&rand="+Math.random(1000,9999)>
                        <button class="忘记密码">忘记密码</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="login_bottom">
		版权所有
	</div>
</body>
</html>
<script src="js/jq.js"></script>
<script>
    function verf(obj){
        $(obj).attr("src",'index.php?r=login/captcha');
    }
</script>