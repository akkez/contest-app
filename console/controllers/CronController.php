<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use frontend\models\Proposal;
use Yii;
use yii\console\Controller;
use yii\helpers\Html;
use yii\helpers\Url;

class CronController extends Controller
{
    /**
     * @todo add to crontab
     * @return bool
     */
    public function actionNotify()
    {
        $newItemsCount = Proposal::find()->where(['status' => Proposal::STATUS_NEW])->count();

        Yii::$app->mailer->compose()
            ->setTo(\Yii::$app->params['notifyEmail'])
            ->setFrom([Yii::$app->params['adminEmail'] => 'Contest Admin'])
            ->setSubject('Есть непроверенные работы')
            ->setTextBody('Доступно ' . $newItemsCount . " новых работ.")
            ->send();

        $this->stdout("Done.\n");
    }
}
