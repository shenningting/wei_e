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
                        <input type="button" id="lost_pwd" class="ext_btn ext_btn_error" value="找回密码">
					</div>
				</form>
			</div>
		</div>
	</div>

    <!-- 找回密码 -->
    <div id="lost_center" style="display: none;">
        <div id="login_area">
            <div id="login_form">
                <form action="index.php?r=login/send" method="post" onsubmit="return check()">
                    <div id="login_tip">
                        找回密码&nbsp;&nbsp;LostPwd
                    </div>
                    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken?>"/>
                    <div>
                        <input type="text" class="username" name="uname" id="uname" placeholder="请输入用户名或邮箱" onblur="check_uname()">
                        <span id="show_info"></span>
                    </div>
                    <div id="btn_area">
                        <input type="submit" id="sub_btn" value="找&nbsp;&nbsp;回">&nbsp;&nbsp;
                        <input type="text" class="verify" name="verifyCode">
                        <!--<img src="index.php?r=login/captcha" alt="点我换一张" title="点我换一张" width="80" height="40" onclick=this.src="index.php?r=login/captcha&rand="+Math.random(1000,9999)>
                        --><?php /*echo Captcha::widget(['name'=>'','captchaAction'=>'login/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;'],'template'=>'{image}']); */?>
                        <img src="index.php?r=login/vcode" alt="点我换一张" title="点我换一张" width="80" height="40" onclick=this.src="index.php?r=login/vcode&rand="+Math.random(1000,9999)>
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
    $.ajaxSetup({
        async:false
    });
    $("#lost_pwd").click(function(){
        $("#lost_center").css('display','block');
        $("#login_center").css('display','none');
    });

   var flag = false;
    function check_uname()
    {
        $.ajaxSetup({
            async:false
        });
        var uname = $("#uname").val();
        $.get('index.php?r=login/check_uname',{uname:uname},function(e){
            if(e==1){
                $("#show_info").html("<font color='blue'>ok</font>");
                flag = true;
            }else{
                $("#show_info").html("<font color='red'>不存在</font>");
                flag =false;
            }
        });
        return flag;
    }

    /*
       回收
     */
    function check()
    {
        if(check_uname()){
            return true;
        }
        else{
            return false;
        }
    }
</script>