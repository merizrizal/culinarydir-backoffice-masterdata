<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use sycomponent\AjaxRequest;
use sycomponent\ModalDialog;
use sycomponent\NotificationDialog;
use backoffice\components\DynamicTable;

/* @var $this yii\web\View */
/* @var $model core\models\StatusApproval */

$ajaxRequest = new AjaxRequest([
    'modelClass' => 'StatusApproval',
]);

$ajaxRequest->view();

$dynamicTableStatusApprovalRequire = new DynamicTable([
    'model' => $modelStatusApprovalRequire,
    'tableFields' => [
        'requireStatusApproval.id',
        'requireStatusApproval.name',
    ],
    'dataProvider' => $dataProviderStatusApprovalRequire,
    'title' => 'Status Approval Require',
    'columnClass' => 'col-sm-12'
]);

$dynamicTableStatusApprovalAction = new DynamicTable([
    'model' => $modelStatusApprovalAction,
    'tableFields' => [
        'name',
        'url',
    ],
    'dataProvider' => $dataProviderStatusApprovalAction,
    'title' => 'Status Approval Action',
    'columnClass' => 'col-sm-12'
]);

$dynamicTableStatusApprovalRequireAction = new DynamicTable([
    'model' => $modelStatusApprovalRequireAction,
    'tableFields' => [
        'statusApprovalAction.name',
        'statusApprovalAction.url',
    ],
    'dataProvider' => $dataProviderStatusApprovalRequireAction,
    'title' => 'Status Approval Require Action',
    'columnClass' => 'col-sm-12'
]);

$status = Yii::$app->session->getFlash('status');
$message1 = Yii::$app->session->getFlash('message1');
$message2 = Yii::$app->session->getFlash('message2');

if ($status !== null) :
    $notif = new NotificationDialog([
        'status' => $status,
        'message1' => $message1,
        'message2' => $message2,
    ]);

    $notif->theScript();
    echo $notif->renderDialog();

endif;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Status Approval'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; ?>

<?= $ajaxRequest->component() ?>

<div class="status-approval-view">

    <div class="row">
        <div class="col-sm-12">
            <div class="x_panel">

                <div class="x_content">

                    <?= Html::a('<i class="fa fa-upload"></i> ' . 'Create',
                        ['create'],
                        [
                            'class' => 'btn btn-success',
                            'style' => 'color:white'
                        ]) ?>

                    <?= Html::a('<i class="fa fa-pencil-alt"></i> ' . 'Edit',
                        ['update', 'id' => $model->id],
                        [
                            'class' => 'btn btn-primary',
                            'style' => 'color:white'
                        ]) ?>

                    <?= Html::a('<i class="fa fa-trash-alt"></i> ' . 'Delete',
                        ['delete', 'id' => $model->id],
                        [
                            'id' => 'delete',
                            'class' => 'btn btn-danger',
                            'style' => 'color:white',
                            'data-not-ajax' => 1,
                            'model-id' => $model->id,
                            'model-name' => $model->name,
                        ]) ?>

                    <?= Html::a('<i class="fa fa-times"></i> ' . 'Cancel',
                        ['index'],
                        [
                            'class' => 'btn btn-default',
                        ]) ?>

                    <div class="clearfix" style="margin-top: 15px"></div>

                    <?= DetailView::widget([
                        'model' => $model,
                        'options' => [
                            'class' => 'table'
                        ],
                        'attributes' => [
                            'id',
                            'name',
                            'note:ntext',
                            'instruction:ntext',
                            'status',
                            'order',
                            [
                                'attribute' => 'condition',
                                'format' => 'raw',
                                'value' => $model->condition ? 'True' : 'False',
                            ],
                            'branch',
                            'group',
                            [
                                'attribute' => 'not_active',
                                'format' => 'raw',
                                'value' => Html::checkbox('not_active', $model->not_active, ['value' => $model->not_active, 'disabled' => 'disabled']),
                            ],
                            'execute_action:ntext',
                        ],
                    ]) ?>

                </div>

            </div>
        </div>
    </div>

    <?= $dynamicTableStatusApprovalRequire->tableData() ?>

    <?= $dynamicTableStatusApprovalAction->tableData() ?>

    <?= $dynamicTableStatusApprovalRequireAction->tableData() ?>

</div>

<?php

$modalDialog = new ModalDialog([
    'clickedComponent' => 'a#delete',
    'modelAttributeId' => 'model-id',
    'modelAttributeName' => 'model-name',
]);

$modalDialog->theScript(false);

echo $modalDialog->renderDialog();

$this->registerCssFile($this->params['assetCommon']->baseUrl . '/plugins/icheck/skins/all.css', ['depends' => 'yii\web\YiiAsset']);

$this->registerJsFile($this->params['assetCommon']->baseUrl . '/plugins/icheck/icheck.min.js', ['depends' => 'yii\web\YiiAsset']);

$jscript = Yii::$app->params['checkbox-radio-script']()
    . '$(".iCheck-helper").parent().removeClass("disabled");
';

$this->registerJs($jscript);

?>
