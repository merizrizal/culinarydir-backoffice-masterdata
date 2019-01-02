<?php

/* @var $this yii\web\View */
/* @var $model core\models\DeliveryMethod */

$this->title = 'Update ' . Yii::t('app', 'Delivery Methods') . ' : ' . $model->delivery_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Delivery Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->delivery_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="delivery-method-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
