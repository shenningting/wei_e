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
				<form action="index.php?r=login/update" method="post">
					<div id="login_tip">
						修改密码&nbsp;&nbsp;UpdatePass
					</div>
                    <input type="hidden" name="_csrf" value="<?= \Yii::$app->request->csrfToken?>"/>
                    <input type="hidden" name="uname" value="<?php echo $uname ?>"/>
					<div><input type="password" class="username" name="upwd"></div>
					<div><input type="password" class="pwd" name="upwd1"></div>
					<div id="btn_area">
						<input type="submit" id="sub_btn" value="修&nbsp;&nbsp;改">&nbsp;&nbsp;
						<!--<img src="index.php?r=login/captcha" alt="点我换一张" title="点我换一张" width="80" height="40" onclick=this.src="index.php?r=login/captcha&rand="+Math.random(1000,9999)>
                        --><?php /*echo Captcha::widget(['name'=>'','captchaAction'=>'login/captcha','imageOptions'=>['id'=>'captchaimg', 'title'=>'换一个', 'alt'=>'换一个', 'style'=>'cursor:pointer;'],'template'=>'{image}']); */?>
					</div>
				</form>
			</div>
		</div>
	</div>

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