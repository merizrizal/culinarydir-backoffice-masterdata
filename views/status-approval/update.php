<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\models\StatusApproval */

$this->title = 'Update ' . Yii::t('app', 'Status Approval') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Status Approval'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="status-approval-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelStatusApprovalRequire' => $modelStatusApprovalRequire,
        'modelStatusApprovalAction' => $modelStatusApprovalAction,
        'modelStatusApprovalRequireAction' => $modelStatusApprovalRequireAction,
    ]) ?>

</div>
