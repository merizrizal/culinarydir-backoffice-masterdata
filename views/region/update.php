<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\models\Region */

$this->title = 'Update ' . Yii::t('app', 'Region') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Area'), 'url' => ['province/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Region'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="region-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
