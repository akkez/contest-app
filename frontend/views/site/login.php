<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3">

        <h3><?= Html::encode($this->title) ?></h3>

        <br> <br>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'email'); ?>
        <br>

        <?= $form->field($model, 'password')->passwordInput(); ?>
        <br>

        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>
