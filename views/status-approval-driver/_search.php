<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\models\StatusApprovalDriver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="status-approval-driver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

	<?= $form->field($model, 'condition')->checkbox() ?>

    <?= $form->field($model, 'branch') ?>

    <?= $form->field($model, 'group') ?>

    <?= $form->field($model, 'order') ?>




    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
