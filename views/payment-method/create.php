<?php

/* @var $this yii\web\View */
/* @var $model core\models\PaymentMethod */

$this->title = 'Create ' . Yii::t('app', 'Payment Methods');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-method-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
