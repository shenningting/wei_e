<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/colResizable-1.3.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script>

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
<center>
    <div class="box_center">
        <form action="index.php?r=ip/add_ip" class="jqtransform" method="post">
            <table class="form_table pt15 pb15" width="100%" border="0" cellpadding="0" cellspacing="0">
                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                <tr>
                    <td class="td_right">ip地址：</td>
                    <td class="">
                        <input type="text" name="ip_name" class="input-text lh30" size="40">
                        <span style="color: red"><?php if(!empty($error)){echo $error['ip_name'][0]; } ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="td_right">&nbsp;</td>
                    <td class="">
                        <input type="submit" name="button" class="btn btn82 btn_save2" value="保存">
                        <input type="reset" name="button" class="btn btn82 btn_res" value="重置">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</center>
</body>
</html>