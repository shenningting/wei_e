<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{
    public function actionIndex()
    {
        return $this -> renderPartial('index');
    }

    public function actionMain()
    {
        return $this -> renderPartial('main');
    }

    public function actionMenu()
    {
        return $this -> renderPartial('menu');
    }

}