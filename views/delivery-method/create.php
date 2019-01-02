<?php

/* @var $this yii\web\View */
/* @var $model core\models\DeliveryMethod */

$this->title = 'Create ' . Yii::t('app', 'Delivery Methods');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Delivery Methods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-method-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
