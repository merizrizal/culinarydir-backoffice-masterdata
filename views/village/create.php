<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Village */

$this->title = 'Create ' . Yii::t('app', 'Village');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Village'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="village-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>