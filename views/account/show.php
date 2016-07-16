<?php
use yii\widgets\LinkPager;
?>
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
        /*$(function () {
            $(".list_table").colResizable({
                liveDrag: true,
                gripInnerHtml: "<div class='grip'></div>",
                draggingClass: "dragging",
                minWidth: 30
            });
        });*/
    </script>
</head>
<body>

<div id="table" class="mt10" style="margin-top: 30px">
    <div class="box span10 oh">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
            <tr>
                <th width="200">昵称</th>
                <th width="500">Api地址</th>
                <th width="300">Token</th>
                <th width="200">操作</th>
            </tr>
            <?php foreach($account_data as $v){?>
            <tr class="tr">
                <td align="center"><?php echo $v['aname']?></td>
                <td>
                    <input type="text" id="content2"  value="<?php echo $v['aurl']?>"/>
                    <button class="btn btn82 btn_nochecked" onclick="copy2()">复制</button>
                </td>
                <td>

                    <input type="text" id="content1"  value="<?php echo $v['atoken']?>"/>
                    <span style="margin-left: 0" ><input type="button" name="button" onclick="copy1()" class="btn btn82 btn_nochecked" value="复制"></span>
                </td>
                <td>
                    <a href="index.php?r=account/del&aid=<?php echo $v['aid']?>"><input type="button" name="button" class="btn btn82 btn_del" value="删除"></a>
                    <a href="index.php?r=account/edit&aid=<?php echo $v['aid']?>"><input type="button" name="button" class="btn btn82 btn_add" value="修改"></a>
                </td>
            </tr>
            <?php }?>
        </table>
        <div class="page mt10">
            <div class="pagination">
                <ul>
                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script src="js/jq.js"></script>
<script>
    //alert($);
    function copy1()
    {
        var Url=document.getElementById("content1");
        //alert(Url);
        Url.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        alert("已复制好，可贴粘。");
    }
    function copy2()
    {
        var Url=document.getElementById("content2");
        Url.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        alert("已复制好，可贴粘。");
    }
</script>