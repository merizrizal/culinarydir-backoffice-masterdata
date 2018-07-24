<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Facility */

$this->title = 'Create ' . Yii::t('app', 'Facility');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Facility'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="facility-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>