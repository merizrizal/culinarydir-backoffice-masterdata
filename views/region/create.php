<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Region */

$this->title = 'Create ' . Yii::t('app', 'Region');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Region'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>