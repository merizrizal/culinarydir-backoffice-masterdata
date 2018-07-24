<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\District */

$this->title = 'Update ' . Yii::t('app', 'District') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'District'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="district-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
