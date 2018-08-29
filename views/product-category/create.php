<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\models\ProductCategory */

$this->title = 'Create ' . Yii::t('app', 'Product Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category & Product'), 'url' => ['product-category/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Category'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>