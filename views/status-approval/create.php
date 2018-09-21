<?php

/* @var $this yii\web\View */
/* @var $model core\models\StatusApproval */

$this->title = 'Create ' . Yii::t('app', 'Status Approval');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Status Approval'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-approval-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelStatusApprovalRequire' => $modelStatusApprovalRequire,
        'modelStatusApprovalAction' => $modelStatusApprovalAction,
        'modelStatusApprovalRequireAction' => $modelStatusApprovalRequireAction,
    ]) ?>

</div>