<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "proposal".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $photo1
 * @property string $photo2
 * @property integer $grade1
 * @property integer $grade2
 * @property integer $grade3
 * @property integer $status
 * @property integer $created_at
 */
class Proposal extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_REVIEWED = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'proposal';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'email', 'status'], 'required'],
            [['name'], 'default', 'value' => ''],
            [['grade1', 'grade2', 'grade3', 'status'], 'integer'],
            [['name', 'phone', 'email', 'photo1', 'photo2'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'email' => 'Email',
            'photo1' => 'Первая работа',
            'photo2' => 'Вторая работа',
            'grade1' => 'Оценка 1',
            'grade2' => 'Оценка 2',
            'grade3' => 'Оценка 3',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}
