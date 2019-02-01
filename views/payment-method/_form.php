<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sycomponent\AjaxRequest;
use sycomponent\NotificationDialog;

/* @var $this yii\web\View */
/* @var $model core\models\PaymentMethod */
/* @var $form yii\widgets\ActiveForm */

kartik\select2\Select2Asset::register($this);
kartik\select2\ThemeKrajeeAsset::register($this);

$ajaxRequest = new AjaxRequest([
    'modelClass' => 'PaymentMethod'
]);

$ajaxRequest->form();

$status = Yii::$app->session->getFlash('status');
$message1 = Yii::$app->session->getFlash('message1');
$message2 = Yii::$app->session->getFlash('message2');

if ($status !== null) {
    
    $notif = new NotificationDialog([
        'status' => $status,
        'message1' => $message1,
        'message2' => $message2,
    ]);
    
    $notif->theScript();
    echo $notif->renderDialog();
} ?>

<?= $ajaxRequest->component() ?>

<div class="row">
	<div class="col-xs-12">
		<div class="x_panel">
			<div class="payment-method-form">
			
				<?php
				$form = ActiveForm::begin([
				    'id' => 'payment-method-form',
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
                                        echo Html::a('<i class="fa fa-upload"></i> Create', ['create'], ['class' => 'btn btn-success']); ?>
                                
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="x_content">

                        <?= $form->field($model, 'payment_name')->textInput(['maxlength' => true]) ?>
                    
                        <?= $form->field($model, 'method')->dropDownList(
                            [ 'Cash' => 'Cash', 'Credit Card' => 'Credit Card', 'Debit Card' => 'Debit Card', 'Transfer' => 'Transfer', 'E-Wallet' => 'E-Wallet' ],
                            ['prompt' => '']
                        ) ?>
                        
                        <?= $form->field($model, 'note')->textarea(['rows' => 2]) ?>
                        
                        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                    
                        <?= $form->field($model, 'not_active')->checkbox(['value' => true], false) ?>
                        
                        <div class="form-group">
                            <div class="row">
                            	<div class="col-xs-offset-3 col-xs-6">
                            	
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
</div>

<?php
$this->registerCssFile($this->params['assetCommon']->baseUrl . '/plugins/icheck/skins/all.css', ['depends' => 'yii\web\YiiAsset']);

$this->registerJsFile($this->params['assetCommon']->baseUrl . '/plugins/icheck/icheck.min.js', ['depends' => 'yii\web\YiiAsset']);

$jscript = '
    $("#paymentmethod-method").select2({
        theme: "krajee",
        placeholder: "' . Yii::t('app', 'Method') . '",
        minimumResultsForSearch: Infinity
    });
';

$this->registerJs(Yii::$app->params['checkbox-radio-script']() . $jscript); ?>