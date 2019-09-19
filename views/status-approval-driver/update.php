<?php

/* @var $this yii\web\View */
/* @var $model core\models\StatusApprovalDriver */

$this->title = 'Update ' . \Yii::t('app', 'Status Approval Driver') . ' : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Status Approval Driver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="status-approval-driver-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
