<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ip_table".
 *
 * @property integer $ip_id
 * @property string $ip_name
 */
class IpTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'we_ip_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip_name'], 'string', 'max' => 20],
            [['ip_name'], 'required'],
            [['ip_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ip_id' => 'Ip ID',
            'ip_name' => 'Ip 地址',
        ];
    }
}
