<?php

namespace backoffice\modules\masterdata\controllers;

use Yii;
use core\models\MembershipType;
use core\models\search\MembershipTypeSearch;
use core\models\MembershipTypeProductService;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use sycomponent\AjaxRequest;

/**
 * MembershipTypeController implements the CRUD actions for MembershipType model.
 */
class MembershipTypeController extends \backoffice\controllers\BaseController
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
     * Lists all MembershipType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MembershipTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MembershipType model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProviderMembershipTypeProductService = new ActiveDataProvider([
            'query' => MembershipTypeProductService::find()->joinWith(['productService'])->andWhere(['membership_type_product_service.membership_type_id' => $id]),
            'pagination' => false,
            'sort' => false
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelMembershipTypeProductService' => new MembershipTypeProductService(),
            'dataProviderMembershipTypeProductService' => $dataProviderMembershipTypeProductService,
        ]);
    }

    /**
     * Creates a new MembershipType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($save = null)
    {
        $model = new MembershipType();
        $modelMembershipTypeProductService = new MembershipTypeProductService();

        if ($model->load(($post = Yii::$app->request->post()))) {

            if (empty($save)) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                $transaction = Yii::$app->db->beginTransaction();
                $flag = false;

                $last = MembershipType::find()
                        ->orderBy('order DESC')
                        ->asArray()->one();

                $model->order = $last['order'] + 1;

                $flag = $model->save();

                if ($flag) {
                    if (!empty($post['MembershipTypeProductService'])) {

                        $modelMembershipTypeProductService = [];

                        foreach ($post['MembershipTypeProductService'] as $i => $membershipTypeProductService) {

                            if ($i !== 'index') {

                                if (empty($membershipTypeProductService['id'])) {

                                    $newModelMembershipTypeProductService = new MembershipTypeProductService();
                                    $newModelMembershipTypeProductService->membership_type_id = $model->id;
                                    $newModelMembershipTypeProductService->product_service_id = $membershipTypeProductService['product_service_id'];
                                    $newModelMembershipTypeProductService->note = $membershipTypeProductService['note'];

                                    if (($flag = $newModelMembershipTypeProductService->save())) {
                                        array_push($modelMembershipTypeProductService, $newModelMembershipTypeProductService);
                                    } else {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($flag) {

                    Yii::$app->session->setFlash('status', 'success');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Create Data Is Success'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Create data process is success. Data has been saved'));

                    $transaction->commit();

                    return AjaxRequest::redirect($this, Yii::$app->urlManager->createUrl(['masterdata/membership-type/view', 'id' => $model->id]));
                } else {

                    $model->setIsNewRecord(true);

                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Create Data Is Fail'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Create data process is fail. Data fail to save'));

                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelMembershipTypeProductService' => !empty($modelMembershipTypeProductService) ? $modelMembershipTypeProductService : new MembershipTypeProductService(),
        ]);
    }

    /**
     * Updates an existing MembershipType model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $save = null)
    {
        $model = $this->findModel($id);
        $modelMembershipTypeProductService = !empty($model->membershipTypeProductServices) ? $model->membershipTypeProductServices : new MembershipTypeProductService();

        if ($model->load(($post = Yii::$app->request->post()))) {

            if (empty($save)) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                $transaction = Yii::$app->db->beginTransaction();
                $flag = false;

                $flag = $model->save();

                if ($flag) {
                    if (!empty($post['MembershipTypeProductService'])) {

                        $modelMembershipTypeProductService = [];

                        foreach ($post['MembershipTypeProductService'] as $i => $membershipTypeProductService) {

                            if ($i !== 'index') {

                                if (empty($membershipTypeProductService['id'])) {

                                    $newModelMembershipTypeProductService = new MembershipTypeProductService();
                                    $newModelMembershipTypeProductService->membership_type_id = $model->id;
                                    $newModelMembershipTypeProductService->product_service_id = $membershipTypeProductService['product_service_id'];
                                    $newModelMembershipTypeProductService->note = $membershipTypeProductService['note'];

                                    if (($flag = $newModelMembershipTypeProductService->save())) {
                                        array_push($modelMembershipTypeProductService, $newModelMembershipTypeProductService);
                                    } else {
                                        break;
                                    }
                                } else {

                                    foreach ($model->membershipTypeProductServices as $dataModelMembershipTypeProductService) {

                                        if ($membershipTypeProductService['id'] == $dataModelMembershipTypeProductService->id) {

                                            if (empty($membershipTypeProductService['delete']['id'])) {

                                                $dataModelMembershipTypeProductService->product_service_id = $membershipTypeProductService['product_service_id'];
                                                $dataModelMembershipTypeProductService->note = $membershipTypeProductService['note'];

                                                if (($flag = $dataModelMembershipTypeProductService->save())) {
                                                    array_push($modelMembershipTypeProductService, $dataModelMembershipTypeProductService);
                                                } else {
                                                    break 2;
                                                }
                                            } else {

                                                if (!($flag = $dataModelMembershipTypeProductService->delete())) {
                                                    break 2;
                                                }
                                            }

                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if ($flag) {

                    Yii::$app->session->setFlash('status', 'success');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Update Data Is Success'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Update data process is success. Data has been saved'));

                    $transaction->commit();
                } else {

                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Update Data Is Fail'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Update data process is fail. Data fail to save'));

                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelMembershipTypeProductService' => !empty($modelMembershipTypeProductService) ? $modelMembershipTypeProductService : new MembershipTypeProductService(),
        ]);
    }

    /**
     * Deletes an existing MembershipType model.
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

        $return['url'] = Yii::$app->urlManager->createUrl([$this->module->id . '/membership-type/index']);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function actionUp($id) {

        $model = $this->findModel($id);

        if ($model->order > 1) {

            $transaction = Yii::$app->db->beginTransaction();
            $flag = false;

            $modelTemp = MembershipType::findOne(['order' => $model->order - 1]);
            $modelTemp->order = $model->order;

            $model->order = 0;

            if (($flag = $model->save())) {

                if (($flag = $modelTemp->save())) {

                    $model->order = $modelTemp->order - 1;

                    $flag = $model->save();
                }
            }

            if ($flag) {
                $transaction->commit();
            } else {

                Yii::$app->session->setFlash('status', 'danger');
                Yii::$app->session->setFlash('message1', Yii::t('app', 'Update Data Is Fail'));
                Yii::$app->session->setFlash('message2', Yii::t('app', 'Update data process is fail. Data fail to save'));

                $transaction->rollBack();
            }
        }

        return AjaxRequest::redirect($this, Yii::$app->urlManager->createUrl(['masterdata/membership-type/index']));
    }

    public function actionDown($id) {

        $model = $this->findModel($id);

        $modelTemp = MembershipType::findOne(['order' => $model->order + 1]);

        if ($modelTemp !== null) {

            $transaction = Yii::$app->db->beginTransaction();
            $flag = false;

            $modelTemp->order = $model->order;

            $model->order = 0;

            if (($flag = $model->save())) {

                if (($flag = $modelTemp->save())) {

                    $model->order = $modelTemp->order + 1;

                    $flag = $model->save();
                }
            }

            if ($flag) {
                $transaction->commit();
            } else {

                Yii::$app->session->setFlash('status', 'danger');
                Yii::$app->session->setFlash('message1', Yii::t('app', 'Update Data Is Fail'));
                Yii::$app->session->setFlash('message2', Yii::t('app', 'Update data process is fail. Data fail to save'));

                $transaction->rollBack();
            }
        }

        return AjaxRequest::redirect($this, Yii::$app->urlManager->createUrl(['masterdata/membership-type/index']));
    }

    /**
     * Finds the MembershipType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MembershipType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MembershipType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
