<?php
use frontend\models\Proposal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Проверка работы';

/* @var Proposal $model */

?>

<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <?php $form = ActiveForm::begin(['id' => 'review-form']); ?>

        <h3>Проверка работы</h3>

        <?php
        if ($model->photo1) {
            echo Html::img('/' . $model->photo1, ['class' => 'img-responsive img-bordered']);
            echo '<br><br>';
        }
        if ($model->photo2) {
            echo Html::img('/' . $model->photo2, ['class' => 'img-responsive img-bordered']);
            echo '<br><br>';
        }
        ?>

        <?= $form->field($model, 'name'); ?>

        <?= $form->field($model, 'email'); ?>

        <div class="row">
            <div class="col-xs-4"><?= $form->field($model, 'grade1'); ?></div>
            <div class="col-xs-4"><?= $form->field($model, 'grade2'); ?></div>
            <div class="col-xs-4"><?= $form->field($model, 'grade3'); ?></div>
        </div>


        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

        <?php ActiveForm::end(); ?>
        <br><br>
    </div>
</div>