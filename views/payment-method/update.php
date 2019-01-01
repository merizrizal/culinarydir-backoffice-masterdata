<?php

/* @var $this yii\web\View */
/* @var $model core\models\PaymentMethod */

$this->title = 'Update ' . Yii::t('app', 'Payment Methods') . ' : ' . $model->payment_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->payment_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-method-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
