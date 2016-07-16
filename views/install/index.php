<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>UCenter 安装向导</title>
<link rel="stylesheet" href="assets/js/style.css" type="text/css" media="all">
<script type="text/javascript" src="assets/js/jq.js"></script>

<meta content="Comsenz Inc." name="Copyright">
</head>
<body><div class="container">
	<div class="header">
		<h1>UCenter 安装向导</h1>
		<span>V1.6.0 简体中文 UTF8 版 20110501</span>	<div class="setup step1">
		<h2>开始安装</h2>
		<p>环境以及文件目录权限检查</p>
	</div>
	<div class="stepstat">
		<ul>
			<li class="current">1</li>
			<li class="unactivated">2</li>
			<li class="unactivated">3</li>
			<li class="unactivated last">4</li>
		</ul>
		<div class="stepstatbg stepstat1"></div>
	</div>
</div>
<div class="main"><h2 class="title">环境检查</h2>

<div class="log_box">
	<h2><img src="images/guide_2.gif" width="112" height="15" /></h2>

	<div class="green_box" style='display:none' id='right_div'>
		<img src="images/right.gif" width="19" height="18" />
		您的系统配置是有效的，单击下一步继续！
	</div>

	<div class="red_box" style='display:none' id='error_div'>
		<img src="images/error.gif" width="16" height="15" />
		您的系统配置不具备安装IWebShop软件，有疑问可以访问：<a href='http://bbs.aircheng.com' target='_blank'>http://bbs.aircheng.com</a>
	</div>

	<div class="gray_box">
		<div class="box">
			<strong>PHP版本及环境设置</strong>
			<?php //phpversion检查
			$phpVersion_pass = $checkObj->c_phpVersion();?>
			<p><img src="images/<?php echo $phpVersion_pass ? 'success' : 'failed';?>.gif" width="16" height="16" />PHP <?php echo $checkObj->getPHPVersion();?></p>

			<?php //phpini检查
			$phpiniArray = $checkObj->c_phpIni();
			foreach($phpiniArray as $key => $val)
			{
			?>
			<p><img src="images/<?php echo $val ? 'success' : 'failed';?>.gif" width="16" height="16" /><?php echo $key;?><?php if(!$val){?><label><?php echo configInfo($key);?></label><?php }?></p>
			<?php
			}
			?>

			<strong>必须扩展配置</strong>
			<?php //must_extension检查
			$mustExtensionArray = $checkObj->c_must_extension();
			foreach($mustExtensionArray as $key => $val)
			{
			?>
			<p><img src="images/<?php echo $val ? 'success' : 'failed';?>.gif" width="16" height="16" /><?php echo $key;?><?php if(!$val){?><label><?php echo configInfo($key);?></label><?php }?></p>
			<?php
			}
			?>

			<strong>必须启用函数</strong>
			<?php //php_function检查
			$mustFunctionArray = $checkObj->c_functionExists();
			foreach($mustFunctionArray as $key => $val)
			{
			?>
			<p><img src="images/<?php echo $val ? 'success' : 'failed';?>.gif" width="16" height="16" /><?php echo $key;?><?php if(!$val){?><label><?php echo configInfo($key);?></label><?php }?></p>
			<?php
			}
			?>

			<strong>建议扩展配置</strong>
			<?php //recom_extension检查
			$recomExtensionArray = $checkObj->c_recom_extension();
			foreach($recomExtensionArray as $key => $val)
			{
			?>
			<p><img src="images/<?php echo $val ? 'success' : 'failed';?>.gif" width="16" height="16" /><?php echo $key;?><?php if(!$val){?><label><?php echo configInfo($key);?></label><?php }?></p>
			<?php
			}
			?>

			<strong>文件可写权限</strong>
			<?php //writeable
			$writeableArray = $checkObj->c_writeableDir();
			foreach($writeableArray as $key => $val)
			{
			?>
			<p><img src="images/<?php echo $val ? 'success' : 'failed';?>.gif" width="16" height="16" /><?php echo $key;?><?php if(!$val){?><label><?php echo configInfo($key);?></label><?php }?></p>
			<?php
			}
			?>



		</div>
	</div>
</div>

<form action="index.php" method="get">
<input name="step" value="2" type="hidden"><div class="btnbox marginbot"><input onclick="history.back();" value="上一步" type="button"><input value="下一步" type="button" onclick="check_config();"  class="bu">
</div>
</form>
		<div class="footer">©2001 - 2011 <a href="http://www.comsenz.com/">Comsenz</a> Inc.</div>
	</div>
</div>

</body></html>
<script type="text/javascript">
    // $(".bu").click(function(){
    //    location.href="index.php?r=install/two";
    // })
    ErrorNum = <?php echo $checkObj->getNpassMustNum();?>

	//检查配置信息
	function check_config()
	{
		var error_num = ErrorNum;
		if(error_num > 0)
		{
			alert('您的系统环境配置没有通过检查');
		}
		else
		{
			window.location.href = 'index.php?r=install/two';
		}
	}
</script>
