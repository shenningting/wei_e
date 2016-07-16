<?php

namespace app\models;

use Yii;
use app\models\CCaptcha;

/**
 * This is the model class for table "we_user".
 *
 * @property integer $uid
 * @property string $uname
 * @property string $upwd
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'we_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uname', 'upwd'], 'required'],
            [['uname'], 'string', 'max' => 30],
            [['upwd'], 'string', 'max' => 50],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'uname' => 'Uname',
            'upwd' => 'Upwd',
            'verifyCode' => '验证码',
        ];
    }
}
