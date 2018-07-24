<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use sycomponent\AjaxRequest;
use sycomponent\NotificationDialog;

/* @var $this yii\web\View */
/* @var $model backend\models\MembershipType */
/* @var $form yii\widgets\ActiveForm */

$ajaxRequest = new AjaxRequest([
    'modelClass' => 'MembershipType',
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

<div class="row">
    <div class="col-sm-12">
        <div class="x_panel">
            <div class="membership-type-form">

                <?php
                $form = ActiveForm::begin([
                    'id' => 'membership-type-form',
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
                ]); ?>

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

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'is_free')->checkbox(['value' => true], false) ?>

                        <?= $form->field($model, 'time_limit')->dropDownList(
                                [
                                    '0' => '0 ' . Yii::t('app', 'Month') . ' / ' . Yii::t('app', 'Unlimited'),
                                    '1' => '1 ' . Yii::t('app', 'Month'),
                                    '2' => '2 ' . Yii::t('app', 'Month'),
                                    '3' => '3 ' . Yii::t('app', 'Month'),
                                    '4' => '4 ' . Yii::t('app', 'Month'),
                                    '5' => '5 ' . Yii::t('app', 'Month'),
                                    '6' => '6 ' . Yii::t('app', 'Month'),
                                    '7' => '7 ' . Yii::t('app', 'Month'),
                                    '8' => '8 ' . Yii::t('app', 'Month'),
                                    '9' => '9 ' . Yii::t('app', 'Month'),
                                    '10' => '10 ' . Yii::t('app', 'Month'),
                                    '11' => '11 ' . Yii::t('app', 'Month'),
                                    '12' => '12 ' . Yii::t('app', 'Month'),
                                ],
                                [
                                    'style' => 'width: 100%'
                                ]) ?>

                        <?= $form->field($model, 'price')->widget(MaskMoney::className()) ?>

                        <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>

                        <?= $form->field($model, 'is_active')->checkbox(['value' => true], false) ?>

                        <?= $form->field($model, 'is_default')->checkbox(['value' => true], false) ?>

                        <?= $form->field($model, 'as_archive')->checkbox(['value' => true], false) ?>

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

                <?php
                ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div><!-- /.row -->

<?php

$this->registerCssFile($this->params['assetCommon']->baseUrl . '/plugins/icheck/skins/all.css', ['depends' => 'yii\web\YiiAsset']);

$this->registerJsFile($this->params['assetCommon']->baseUrl . '/plugins/icheck/icheck.min.js', ['depends' => 'yii\web\YiiAsset']);

$jscript = '
';

$this->registerJs($jscript . Yii::$app->params['checkbox-radio-script']()); ?>