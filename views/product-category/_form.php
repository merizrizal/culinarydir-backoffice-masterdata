<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use sycomponent\AjaxRequest;
use sycomponent\NotificationDialog;
use backend\models\ProductCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductCategory */
/* @var $form yii\widgets\ActiveForm */

kartik\select2\Select2Asset::register($this);
kartik\select2\ThemeKrajeeAsset::register($this);

$ajaxRequest = new AjaxRequest([
    'modelClass' => 'ProductCategory',
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
            <div class="product-category-form">

                <?php
                $form = ActiveForm::begin([
                    'id' => 'product-category-form',
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

                        <?= $form->field($model, 'parent_id')->dropDownList(
                                ArrayHelper::map(
                                    ProductCategory::find()->andWhere(['IS', 'parent_id', NULL])->andWhere(['is_active' => 1])->orderBy('name')->asArray()->all(),
                                    'id',
                                    function($data) {
                                        return $data['name'];
                                    }
                                ),
                                [
                                    'prompt' => '',
                                ]) ?>

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'is_active')->checkbox(['value' => true], false) ?>

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
    $("#productcategory-parent_id").select2({
        theme: "krajee",
        placeholder: "Pilih"
    });
';

$this->registerJs($jscript . Yii::$app->params['checkbox-radio-script']()); ?>