<?php
/**
 * Created by PhpStorm.
 * Date: 06/05/17
 */
use frontend\models\Proposal;
use yii\helpers\Html;

/* @var Proposal $model */

?>
<h3>Name: <?= Html::encode($model->name); ?></h3>
<h3>Email: <?= Html::encode($model->email); ?></h3>

<p>
    <?= Html::img($image); ?>
</p>
