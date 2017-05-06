<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Отправка работы';
?>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

        <h3><?= Html::encode($this->title) ?></h3>

        <br>
        <?php $form = ActiveForm::begin(['id' => 'proposal-form', 'enableClientValidation' => false]); ?>
        <?php echo $form->errorSummary($model); ?>

        <?= $form->field($model, 'name') ?>
        <br>

        <?= $form->field($model, 'email') ?>
        <br>

        <?= $form->field($model, 'phone') ?>
        <br>

        <?= $form->field($model, 'photo1')->fileInput(['class' => 'form-control block']) ?>
        <br>

        <?= $form->field($model, 'photo2')->fileInput(['class' => 'form-control block']) ?>
        <br>

        <div class="form-group">
            <?= Html::submitButton('Отправить работу', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
