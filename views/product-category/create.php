<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductCategory */

$this->title = 'Create ' . Yii::t('app', 'Product Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Category'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>