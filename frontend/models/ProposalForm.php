<?php
/**
 * Created by PhpStorm.
 * Date: 06/05/17
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ProposalForm extends Model
{
    public $email;
    public $name;
    public $phone;

    public $photo1;
    public $photo2;
    public $photoPaths;

    public function rules()
    {
        return [
            [['email', 'phone'], 'required'],
            ['email', 'email'],
            ['name', 'safe'],

            [['photo1', 'photo2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png'],
            [['photo1'], function ($attribute, $params, $validator) {
                if (!$this->photo1 && !$this->photo2) {
                    $this->addError($attribute, 'Должна быть прикреплена хотя бы одна работа');
                }
            }, 'skipOnEmpty' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя участника',
            'phone' => 'Телефон',
            'email' => 'Электропочта',
            'photo1' => 'Работа в png',
            'photo2' => 'Ещё работа в png',
        ];
    }

    public function saveUploadedFiles()
    {
        $saved = true;
        $this->photoPaths = [];
        foreach (['photo1', 'photo2'] as $photoAttribute) {
            $this->photoPaths[$photoAttribute] = null;
            if ($this->$photoAttribute) {
                $filename = 'uploads/' . \Yii::$app->getSecurity()->generateRandomString() . '.png';
                $result = $this->$photoAttribute->saveAs($filename);
                if (!$result) {
                    $this->addError($photoAttribute, 'Не удалось сохранить фото');
                }

                $saved = $saved && $result;
                $this->photoPaths[$photoAttribute] = $filename;
            }
        }

        return $saved;
    }
}