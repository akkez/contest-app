<?php

namespace frontend\controllers;

use frontend\models\Proposal;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

class ApiController extends ActiveController
{
    public $modelClass = 'frontend\models\Proposal';

    public function actions()
    {
        return [];
    }

    public function actionOnreview()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return Proposal::find()->where(['status' => Proposal::STATUS_NEW])->all();
    }
}
