<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<link rel="stylesheet" href="css/common.css">
<link rel="stylesheet" href="css/main.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/colResizable-1.3.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>

<script type="text/javascript">
    $(function(){
        $(".list_table").colResizable({
            liveDrag:true,
            gripInnerHtml:"<div class='grip'></div>",
            draggingClass:"dragging",
            minWidth:30
        });
    });
</script>

<div style="margin-top: 50px">
    <center>
        <form action="index.php?r=ip/ip_show" method="post">
            <input type="text" name="ip_name" class="input-text lh30" size="40" placeholder="请输入关键字"/>
            <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
            <input type="submit" value="搜索" class="ext_btn ext_btn_success"/>
        </form>
    </center>
</div>

<center>
    <div id="table" class="mt10">
        <div class="box span10 oh">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="list_table">
                <tr>
                    <th width="30">#</th>
                    <th width="100">IP</th>
                    <th width="100">操作</th>
                </tr>
                <?php foreach($ip_data as $v){?>
                <tr class="tr">
                    <td class="td_center"><input type="checkbox"></td>
                    <td><?php echo $v['ip_name']?></td>
                    <td>
                        <a href="index.php?r=ip/del&ip_id=<?php echo $v['ip_id']?>">
                            <input type="button" name="button" class="btn btn82 btn_del" value="删除">
                        </a>
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
</center>
