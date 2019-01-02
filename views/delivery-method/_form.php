<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sycomponent\AjaxRequest;
use sycomponent\NotificationDialog;

/* @var $this yii\web\View */
/* @var $model core\models\DeliveryMethod */
/* @var $form yii\widgets\ActiveForm */

$ajaxRequest = new AjaxRequest([
    'modelClass' => 'DeliveryMethod'
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
			<div class="delivery-method-form">

                <?php
				$form = ActiveForm::begin([
				    'id' => 'delivery-method-form',
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
					
						<?= $form->field($model, 'delivery_name')->textInput(['maxlength' => true]) ?>
            
                        <?= $form->field($model, 'not_active')->checkbox(['value' => true], false) ?>
                    
                        <div class="form-group">
                            <div class="row">
                            	<div class="col-xs-offset-3 col-xs-6">
                            	
									<?php
									$icon = '<i class="fa fa-save"></i> ';
									echo Html::submitButton($model->isNewRecord ? $icon . 'Save' : $icon . 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
									echo Html::a('<i class="fa fa-times"></i> Cancel', ['index'], ['class' => 'btn btn-default']) ?>                            	
                            	
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

$this->registerJs(Yii::$app->params['checkbox-radio-script']()); ?>