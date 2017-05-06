<?php

namespace frontend\models;

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
            [['email'], 'email'],
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
            'grade1' => 'Первая оценка',
            'grade2' => 'Вторая оценка',
            'grade3' => 'Третья оценка',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    public function sendEmail()
    {
        return Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['adminEmail'] => 'Contest Admin'])
            ->setSubject('Ваша работа проверена')
            ->setTextBody("Привет. Ваша работа была проверена и получила следующие оценки: \n" .
                '1) ' . $this->grade1 . "\n" .
                '2) ' . $this->grade2 . "\n" .
                '3) ' . $this->grade3 . "\n")
            ->send();
    }
}
