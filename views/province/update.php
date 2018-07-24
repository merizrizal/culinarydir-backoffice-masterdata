<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Province */

$this->title = 'Update ' . Yii::t('app', 'Province') . ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Province'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="province-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
