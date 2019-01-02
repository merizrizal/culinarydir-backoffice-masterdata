<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\models\search\DeliveryMethodSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-method-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'delivery_name') ?>

    <?= $form->field($model, 'not_active')->checkbox() ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'user_created') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'user_updated') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
