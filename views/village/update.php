<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Village */

$this->title = 'Update ' . Yii::t('app', 'Village') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Village'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="village-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
