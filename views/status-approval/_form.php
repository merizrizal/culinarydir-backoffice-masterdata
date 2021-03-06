<?php

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use sycomponent\AjaxRequest;
use sycomponent\NotificationDialog;
use backoffice\components\DynamicFormField;
use core\models\StatusApproval;
use core\models\StatusApprovalAction;

/* @var $this yii\web\View */
/* @var $model core\models\StatusApproval */
/* @var $form yii\widgets\ActiveForm */

kartik\select2\Select2Asset::register($this);
kartik\select2\ThemeKrajeeAsset::register($this);

$ajaxRequest = new AjaxRequest([
    'modelClass' => 'StatusApproval',
]);

$ajaxRequest->form();

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

endif; ?>

<?= $ajaxRequest->component() ?>

<?php
 $form = ActiveForm::begin([
    'id' => 'status-approval-form',
    'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'options' => [

    ],
    'fieldConfig' => [
        'parts' => [
            '{inputClass}' => 'col-lg-12'
        ],
        'template' => '
            <div class="row">
                <div class="col-lg-3">
                    {label}
                </div>
                <div class="col-lg-6">
                    <div class="{inputClass}">
                        {input}
                    </div>
                </div>
                <div class="col-lg-3">
                    {error}
                </div>
            </div>',
    ]
]);

    $dynamicFormStatusApprovalRequire = new DynamicFormField([
        'dataModel' => $modelStatusApprovalRequire,
        'form' => $form,
        'formFields' => [
            'require_status_approval_id' => [
                'type' => 'dropdown',
                'data' => ArrayHelper::map(
                    StatusApproval::find()->orderBy('order')->asArray()->all(),
                    'id',
                    function($data) {
                        return $data['name'] . ' - ' . $data['id'];
                    }
                ),
                'colOption' => 'style="width: 50%"',
            ],
        ],
        'title' => Yii::t('app', 'Status Approval Require'),
        'columnClass' => 'col-sm-12'
    ]);

    $dynamicFormStatusApprovalAction = new DynamicFormField([
        'dataModel' => $modelStatusApprovalAction,
        'form' => $form,
        'formFields' => [
            'name' => [
                'type' => 'textinput',
                'colOption' => 'style="width: 40%"',
            ],
            'url' => [
                'type' => 'textinput',
                'colOption' => 'style="width: 40%"',
            ],
        ],
        'title' => Yii::t('app', 'Status Approval Action'),
        'columnClass' => 'col-sm-12'
    ]);

    $dynamicFormStatusApprovalRequireAction = new DynamicFormField([
        'dataModel' => $modelStatusApprovalRequireAction,
        'form' => $form,
        'formFields' => [
            'status_approval_action_id' => [
                'type' => 'dropdown',
                'data' => ArrayHelper::map(
                    StatusApprovalAction::find()->orderBy('name')->asArray()->all(),
                    'id',
                    function($data) {
                        return $data['name'];
                    }
                ),
                'colOption' => 'style="width: 50%"',
            ],
        ],
        'title' => Yii::t('app', 'Status Approval Require Action'),
        'columnClass' => 'col-sm-12'
    ]); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="x_panel">
                <div class="status-approval-form">

                    <div class="x_title">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php
                                    if (!$model->isNewRecord)
                                        echo Html::a('<i class="fa fa-upload"></i> ' . 'Create', ['create'], ['class' => 'btn btn-success']); ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="x_content">

                        <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>

                        <?= $form->field($model, 'instruction')->textarea(['rows' => 3]) ?>

                        <?= $form->field($model, 'status')->dropDownList(['Finished-Success' => 'Finished-Success', 'Finished-Fail' => 'Finished-Fail', 'Unfinished' => 'Unfinished'], ['prompt' => '']) ?>

                        <?= $form->field($model, 'order')->textInput() ?>

                        <?= $form->field($model, 'condition')->radioList([true => 'True', null => 'False'], ['separator' => '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;']) ?>

                        <?= $form->field($model, 'branch')->textInput() ?>

                        <?= $form->field($model, 'group')->textInput() ?>

                        <?= $form->field($model, 'not_active')->checkbox(['value' => true], false) ?>

                        <?= $form->field($model, 'execute_action')->textarea(['rows' => 3]) ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <?php
                                    $icon = '<i class="fa fa-save"></i> ';
                                    echo Html::submitButton($model->isNewRecord ? $icon . 'Save' : $icon . 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                                    echo Html::a('<i class="fa fa-times"></i> Cancel', ['index'], ['class' => 'btn btn-default']); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.row -->

    <?= $dynamicFormStatusApprovalRequire->component(); ?>

    <?= $dynamicFormStatusApprovalAction->component(); ?>

    <?= $dynamicFormStatusApprovalRequireAction->component(); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <?php
                                $icon = '<i class="fa fa-save"></i> ';
                                echo Html::submitButton($model->isNewRecord ? $icon . 'Save' : $icon . 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
                                echo Html::a('<i class="fa fa-times"></i> Cancel', ['index'], ['class' => 'btn btn-default']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>

<?php

$this->registerCssFile($this->params['assetCommon']->baseUrl . '/plugins/icheck/skins/all.css', ['depends' => 'yii\web\YiiAsset']);

$this->registerJsFile($this->params['assetCommon']->baseUrl . '/plugins/icheck/icheck.min.js', ['depends' => 'yii\web\YiiAsset']);

$jscript = '
    $("#statusapproval-status").select2({
        theme: "krajee",
        placeholder: "Pilih",
        minimumResultsForSearch: "Infinity"
    });
';

$this->registerJs($jscript . Yii::$app->params['checkbox-radio-script']()); ?>