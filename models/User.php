<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public function validateVerifyCode($verifyCode){
        if(strtolower($this->verifyCode) === strtolower($verifyCode)){
            return true;
        }else{
            $this->addError('verifyCode','验证码错误.');
        }
    }
}