<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\models\ProductService */

$this->title = 'Update ' . Yii::t('app', 'Product Service') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Membership'), 'url' => ['product-service/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Service'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-service-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
