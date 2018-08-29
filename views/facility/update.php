<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\models\Facility */

$this->title = 'Update ' . Yii::t('app', 'Facility') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Facility'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="facility-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
