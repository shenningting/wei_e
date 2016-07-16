<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Account;
use yii\data\Pagination;

class AccountController extends Controller
{
    /*
     *  加载添加页面
     */
    public function actionAdd()
    {
        if(\Yii::$app->request->isPost){

            $model =new Account();
            $model->attributes=\Yii::$app->request->post();

            $atok=$this->actionRands(5);
            $aurl=substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,strpos('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'we'))."wei_e/shen.php?gui=".$atok;
            $session = \Yii::$app->session;
            $session->open();
            $model -> uid = $session->get('uid');
            $model -> aurl = $aurl;
            $model -> atok = $atok;
            $model -> atoken = $this->actionToken();
            if($model->insert()){
               $this -> redirect(array('show'));
            }else{
               $error_data = $model -> getErrors();
                return $this -> renderPartial('add',['error_data'=>$error_data]);
            }

        }else{
            return $this -> renderPartial('add');
        }
    }

    /*
     *  生成Token
     */
    public function actionToken()
    {
        $str = md5(rand(100,999));
        $s = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return $s[rand(0,51)].substr($str,1);
    }

    /*
     *  识别符
     */
    public function actionRands($length){
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randString = '';
        $len = strlen($str)-1;
        for($i = 0;$i < $length;$i ++)
        {
            $num = mt_rand(0, $len); $randString .= $str[$num];
        }
        return $randString ;
    }

    /*
     * 公众号展示
     */
    public function actionShow()
    {
        $query = Account::find();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $account_data = $query->orderBy('aid')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->renderPartial('show', [
            'account_data' => $account_data,
            'pagination' => $pagination,
        ]);
    }

    /*
     *  公众号的删除
     */
    public function actionDel()
    {
        $aid = \Yii::$app->request->get('aid');
       // echo $aid;die;
        Account::deleteAll('aid='.$aid);
        $this -> redirect(array('show'));
    }

    /*
     * 公众号编辑
     */
    public function actionEdit()
    {
        if(\Yii::$app->request->isGet){
            $aid = \Yii::$app->request->get('aid');
            $one_data = Account::find() -> where(['aid'=>$aid]) ->one();
           // print_r($one_data);die;
            return $this -> renderPartial('edit',['one_data'=>$one_data]);
        }else{
            $aid = \Yii::$app->request->post('aid');
            $model = Account::findOne($aid);
            $model -> attributes = \Yii::$app->request->post();
            $bool = $model ->save();
            if($bool>0){
                return $this -> redirect(array('show'));
            }else{
                $aid = \Yii::$app->request->post('aid');
                $one_data = Account::find() -> where(['aid'=>$aid]) ->one();
                return $this -> renderPartial('edit',['one_data'=>$one_data]);
            }
        }
    }
}