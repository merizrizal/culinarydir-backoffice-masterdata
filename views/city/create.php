<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\City */

$this->title = 'Create ' . Yii::t('app', 'City');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'City'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>