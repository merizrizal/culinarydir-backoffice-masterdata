<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\City */

$this->title = 'Update ' . Yii::t('app', 'City') . ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'City'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="city-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
