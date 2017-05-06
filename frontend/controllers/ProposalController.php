<?php

namespace frontend\controllers;

use frontend\models\Proposal;
use frontend\models\ProposalForm;
use Yii;
use yii\web\UploadedFile;

class ProposalController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new ProposalForm();

        if (Yii::$app->request->getIsPost() && $model->load(Yii::$app->request->post())) {
            $model->photo1 = UploadedFile::getInstance($model, 'photo1');
            $model->photo2 = UploadedFile::getInstance($model, 'photo2');

            if ($model->validate() && $model->saveUploadedFiles()) {

                $proposal = new Proposal();
                $proposal->setAttributes($model->getAttributes());
                $proposal->setAttributes($model->photoPaths);
                $proposal->status = Proposal::STATUS_NEW;
                if ($proposal->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Работа отправлена, спасибо');
                    return $this->goHome();
                } else {
                    $model->addErrors($proposal->getErrors());
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
