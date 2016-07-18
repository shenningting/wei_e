<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "we_user".
 *
 * @property integer $uid
 * @property string $uname
 * @property string $upwd
 * @property string $email
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
            [['uname', 'upwd', 'email'], 'required'],
            [['uname', 'email'], 'string', 'max' => 30],
            [['upwd'], 'string', 'max' => 50]
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
            'email' => 'Email',
        ];
    }
}
