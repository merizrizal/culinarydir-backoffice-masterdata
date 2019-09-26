<?php

/* @var $this yii\web\View */
/* @var $model core\models\StatusApproval */
/* @var $modelStatusApprovalRequire core\models\StatusApprovalRequire */
/* @var $modelStatusApprovalAction core\models\StatusApprovalAction */
/* @var $modelStatusApprovalRequireAction core\models\StatusApprovalRequireAction */

$this->title = 'Update ' . Yii::t('app', 'Status Approval Business') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Status Approval Business'), 'url' => ['index']];
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
