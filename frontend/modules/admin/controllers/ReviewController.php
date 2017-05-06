<?php

namespace frontend\modules\admin\controllers;

use frontend\models\Proposal;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `admin` module
 */
class ReviewController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $newItems = Proposal::find()->where(['status' => Proposal::STATUS_NEW])->orderBy('id DESC')->all();
        $reviewedItems = Proposal::find()->where(['status' => Proposal::STATUS_REVIEWED])->orderBy('id DESC')->all();

        return $this->render('index', [
            'newItems' => $newItems,
            'reviewedItems' => $reviewedItems,
        ]);
    }

    public function actionView($id)
    {
        /* @var Proposal $proposal */
        $proposal = Proposal::findOne(['id' => $id]);
        if (!$proposal) {
            throw new NotFoundHttpException();
        }

        if (\Yii::$app->request->isPost) {
            $proposal->load(\Yii::$app->request->post());
            $oldStatus = $proposal->status;
            $proposal->status = Proposal::STATUS_REVIEWED;

            if ($proposal->validate() && $proposal->save()) {
                \Yii::$app->session->setFlash('success', 'Изменения сохранены. '. Html::a('Вернуться к списку работ', ['/admin/review/index']));

                if ($oldStatus != $proposal->status) {
                    $proposal->sendEmail();
                }
            }
        }

        return $this->render('view', [
            'model' => $proposal
        ]);
    }
}
