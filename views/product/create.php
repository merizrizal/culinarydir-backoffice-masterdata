<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = 'Create ' . Yii::t('app', 'Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>