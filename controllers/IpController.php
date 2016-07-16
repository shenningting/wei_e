<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\IpTable;
use yii\data\Pagination;

class IpController extends Controller
{
    public function init()
    {
        parent::init();
        $session = \YII::$app->session;
        $session->open();
        $user_name = $session->get('uname');
        if ($user_name == "") {
            echo "<script>alert('还没登录呢！');location.href='index.php?r=login/index'</script>";
        }
    }

    /*
     * ip展示
     */
    public function actionIp_show()
    {
        /* $ip_data =IpTable::find()->asArray()->all();
         return $this->renderPartial('ip_show',['ip_data'=>$ip_data]);*/
        if (\Yii::$app->request->isPost) {
            $ip_name = \Yii::$app->request->post('ip_name');
        } else {
            $ip_name = "";
        }


        $query = IpTable::find();
        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $query->count(),
        ]);

        $ip_data = $query
            ->where(['like', 'ip_name', $ip_name])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->renderPartial('ip_show', [
            'ip_data' => $ip_data,
            'pagination' => $pagination,
        ]);
    }

    /*
     *  添加ip
     */
    public function actionAdd_ip()
    {
        if (Yii::$app->request->isPost) {

            $model = new IpTable();
            $model->attributes = Yii::$app->request->post();
            if ($model->insert()) {
                return $this->redirect(array('ip_show'));
            } else {
//                var_dump($model->getErrors());
                return $this->renderPartial('add', ['error' => $model->getErrors()]);
            }
        } else {
            return $this->renderPartial('add');
        }
    }

    /*
     * 删除ip
     */
    public function actionDel()
    {
        $ip_id = \Yii::$app->request->get('ip_id');
        IpTable::deleteAll('ip_id=' . $ip_id);
        $this->redirect(array('ip_show'));
    }
}