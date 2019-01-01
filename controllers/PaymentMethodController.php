<?php

namespace backoffice\modules\masterdata\controllers;

use Yii;
use core\models\PaymentMethod;
use core\models\search\PaymentMethodSearch;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * PaymentMethodController implements the CRUD actions for PaymentMethod model.
 */
class PaymentMethodController extends \backoffice\controllers\BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(
            $this->getAccess(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]);
    }

    /**
     * Lists all PaymentMethod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentMethodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PaymentMethod model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PaymentMethod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($save = null)
    {
        $render = 'create';
        
        $model = new PaymentMethod();

        if ($model->load(Yii::$app->request->post())) {
            
            if (empty($save)) {
                
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                
                if ($model->save()) {
                    
                    Yii::$app->session->setFlash('status', 'success');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Create Data Is Success'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Create data process is success. Data has been saved'));
                    
                    $render = 'view';
                } else {
                    
                    $model->setIsNewRecord(true);
                    
                    Yii::$app->session->setFlash('status', 'success');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Create Data Is Success'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Create data process is success. Data has been saved'));
                }
            }
        }

        return $this->render($render, [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PaymentMethod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $save = null)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            if (empty($save)) {
                
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {
                
                if ($model->save()) {
                    
                    Yii::$app->session->setFlash('status', 'success');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Update Data Is Success'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Update data process is success. Data has been saved'));
                } else {
                    
                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Update Data Is Fail'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Update data process is fail. Data fail to save'));
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PaymentMethod model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (($model = $this->findModel($id)) !== false) {
            
            $flag = false;
            $error = '';
            
            try {
                $flag = $model->delete();
            } catch (yii\db\Exception $exc) {
                $error = Yii::$app->params['errMysql'][$exc->errorInfo[1]];
            }
        }
        
        if ($flag) {
            
            Yii::$app->session->setFlash('status', 'success');
            Yii::$app->session->setFlash('message1', Yii::t('app', 'Delete Is Success'));
            Yii::$app->session->setFlash('message2', Yii::t('app', 'Delete process is success. Data has been deleted'));
        } else {
            
            Yii::$app->session->setFlash('status', 'danger');
            Yii::$app->session->setFlash('message1', Yii::t('app', 'Delete Is Fail'));
            Yii::$app->session->setFlash('message2', Yii::t('app', 'Delete process is fail. Data fail to delete' . $error));
        }
        
        $return = [];
        
        $return['url'] = Yii::$app->urlManager->createUrl([$this->module->id . '/payment-method/index']);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    /**
     * Finds the PaymentMethod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PaymentMethod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PaymentMethod::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
