<?php

/* @var $this yii\web\View */
/* @var $model core\models\StatusApprovalDriver */
/* @var $modelStatusApprovalDriverRequire core\models\StatusApprovalDriverRequire */
/* @var $modelStatusApprovalDriverAction core\models\StatusApprovalDriverAction */
/* @var $modelStatusApprovalDriverRequireAction core\models\StatusApprovalDriverRequireAction */

$this->title = \Yii::t('app', 'Add') . ' ' . \Yii::t('app', 'Status Approval Driver');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Status Approval Driver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-approval-driver-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelStatusApprovalDriverRequire' => $modelStatusApprovalDriverRequire,
        'modelStatusApprovalDriverAction' => $modelStatusApprovalDriverAction,
        'modelStatusApprovalDriverRequireAction' => $modelStatusApprovalDriverRequireAction
    ]) ?>

</div>