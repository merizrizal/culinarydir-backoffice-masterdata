<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\models\ProductService */

$this->title = 'Create ' . Yii::t('app', 'Product Service');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Membership'), 'url' => ['product-service/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Service'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-service-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>