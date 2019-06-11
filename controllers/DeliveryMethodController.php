<?php

namespace backoffice\modules\masterdata\controllers;

use Yii;
use core\models\Business;
use core\models\DeliveryMethod;
use core\models\search\DeliveryMethodSearch;
use sycomponent\AjaxRequest;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use core\models\BusinessDelivery;

/**
 * DeliveryMethodController implements the CRUD actions for DeliveryMethod model.
 */
class DeliveryMethodController extends \backoffice\controllers\BaseController
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
     * Lists all DeliveryMethod models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeliveryMethodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DeliveryMethod model.
     * @param integer $id
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
     * Creates a new DeliveryMethod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($save = null)
    {
        $render = 'create';

        $model = new DeliveryMethod();

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
     * Updates an existing DeliveryMethod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing DeliveryMethod model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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

        $return['url'] = Yii::$app->urlManager->createUrl([$this->module->id . '/delivery-method/index']);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    /**
     * Finds the DeliveryMethod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeliveryMethod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeliveryMethod::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetNotesByDeliveryMethod($id)
    {
        $data = DeliveryMethod::find()->andWhere(['id' => $id])->asArray()->all();

        $row = [];

        $row['note'] = !empty($data[0]['note']) ? $data[0]['note'] : null;
        $row['description'] = !empty($data[0]['description']) ? $data[0]['description'] : null;

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $row;
    }

    public function actionAddToAllBusiness($id, $note = null, $description = null, $save = null)
    {
        $modelBusiness = Business::find()
            ->joinWith([
                'businessDeliveries' => function ($query) use ($id) {

                    $query->andOnCondition(['business_delivery.delivery_method_id' => $id]);
                },
                'membershipType.membershipTypeProductServices.productService'
            ])
            ->andWhere(['product_service.code_name' => 'order-online'])
            ->all();

        if (!empty($modelBusiness)) {

            $flag = false;
            $transaction = Yii::$app->db->beginTransaction();

            foreach ($modelBusiness as $dataBusiness) {

                if (!empty($dataBusiness->businessDeliveries)) {

                    $modelBusinessDelivery = $dataBusiness->businessDeliveries[0];
                } else {

                    $modelBusinessDelivery = new BusinessDelivery();
                    $modelBusinessDelivery->business_id = $dataBusiness->id;
                    $modelBusinessDelivery->is_active = true;
                    $modelBusinessDelivery->delivery_method_id = $id;
                }

                $modelBusinessDelivery->note = !empty($note) ? $note : null;
                $modelBusinessDelivery->description = !empty($description) ? $description : null;

                if (!($flag = $modelBusinessDelivery->save())) {

                    break;
                }
            }

            if ($flag) {

                Yii::$app->session->setFlash('status', 'success');
                Yii::$app->session->setFlash('message1', Yii::t('app', 'Add to Business Is Success'));
                Yii::$app->session->setFlash('message2', Yii::t('app', 'Delivery method is successfully added to all business'));

                $transaction->commit();
            } else {

                Yii::$app->session->setFlash('status', 'danger');
                Yii::$app->session->setFlash('message1', Yii::t('app', 'Add to Business Is Fail'));
                Yii::$app->session->setFlash('message2', Yii::t('app', 'Delivery method is fail to added'));

                $transaction->rollback();
            }
        } else {

            Yii::$app->session->setFlash('status', 'danger');
            Yii::$app->session->setFlash('message1', Yii::t('app', 'Add to Business Is Fail'));
            Yii::$app->session->setFlash('message2', Yii::t('app', 'Business Not Found'));
        }

        return AjaxRequest::redirect($this, Yii::$app->urlManager->createUrl(['masterdata/delivery-method/index']));
    }
}