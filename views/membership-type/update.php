<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MembershipType */

$this->title = 'Update ' . Yii::t('app', 'Membership Type') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Membership Type'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="membership-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
