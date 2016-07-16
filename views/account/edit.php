<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/colResizable-1.3.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <style>
        tr{
            margin-top:100px;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            $(".list_table").colResizable({
                liveDrag: true,
                gripInnerHtml: "<div class='grip'></div>",
                draggingClass: "dragging",
                minWidth: 30
            });
        });
    </script>
</head>
<body>
<form action="index.php?r=account/edit" method="post"  enctype="multipart/form-data"  class="jqtransform">
    <table class="insert-tab" width="70%" height="470">
        <input type="hidden" name="_csrf" value="<?=\Yii::$app->request->csrfToken?>"/>
        <tr>
            <th><i class="require-red">*</i>公众号名称：</th>
            <td>
                <input type="hidden" name="aid" value="<?php echo $one_data['aid']?>"/>
                <input class="input-text lh30" id="title" name="aname" size="50"  type="text" value="<?php echo $one_data['aname']?>">
                <span style="color: red"><?=$error_data['aname'][0]?></span>
            </td>
        </tr>
        <tr>
            <th>Appid：</th>
            <td>
                <input class="input-text lh30" name="appid" size="50" value="<?php echo $one_data['appid']?>" type="text">
                <span style="color: red"><?=$error_data['appid'][0]?></span>
            </td>

        </tr>
        <tr>
            <th>Appsecret：</th>
            <td>
                <input class="input-text lh30" name="appsecret" size="50"  value="<?php echo $one_data['appsecret']?>" type="text">
                <span style="color: red"><?=$error_data['appsecret'][0]?></span>
            </td>
        </tr>

        <tr>
            <th><font color="red">接口地址</font>：</th>
            <td>
                <input class="input-text lh30" name="aurl" size="50" value="<?php echo $one_data['aurl']?>" type="text">
                <span style="color: red"><?=$error_data['aurl'][0]?></span>
            </td>

        </tr>
        <tr>
            <th><font color="red">Token</font>：</th>
            <td>
                <input class="input-text lh30" id="token" name="atoken" size="50" value="<?php echo $one_data['atoken']?>" type="text"><span style="color: blue" onclick="newToken()">生成新的</span>
                <span style="color: red"><?=$error_data['atoken'][0]?></span>
            </td>
        </tr>

        <tr>
            <th></th>
            <td>
                <input type="submit"  class="btn btn82 btn_save2" value="修改">
                <input type="button" value="返回" onclick="location.href='javascript:history.go(-1)'"
                       class="ext_btn">
            </td>
        </tr>
    </table>
</form>
</body>
</html>

<script src="js/jq.js"></script>
<script>
    function newToken()
    {
        $.get('index.php?r=account/token',function(e){
            //alert(e);
            $("#token").val(e);
        });
    }
</script>