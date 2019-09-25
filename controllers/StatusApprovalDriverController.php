<?php

namespace backoffice\modules\masterdata\controllers;

use core\models\StatusApprovalDriver;
use core\models\StatusApprovalDriverAction;
use core\models\StatusApprovalDriverRequire;
use core\models\StatusApprovalDriverRequireAction;
use core\models\search\StatusApprovalDriverSearch;
use sycomponent\AjaxRequest;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * StatusApprovalDriverController implements the CRUD actions for StatusApprovalDriver model.
 */
class StatusApprovalDriverController extends \backoffice\controllers\BaseController
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
     * Lists all StatusApprovalDriver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatusApprovalDriverSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StatusApprovalDriver model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProviderStatusApprovalDriverRequire = new ActiveDataProvider([
            'query' => StatusApprovalDriverRequire::find()->joinWith(['requireStatusApprovalDriver'])->andWhere(['status_approval_driver_require.status_approval_driver_id' => $id]),
            'pagination' => false,
            'sort' => false
        ]);

        $dataProviderStatusApprovalDriverAction = new ActiveDataProvider([
            'query' => StatusApprovalDriverAction::find()->andWhere(['status_approval_driver_action.status_approval_driver_id' => $id]),
            'pagination' => false,
            'sort' => false
        ]);

        $dataProviderStatusApprovalDriverRequireAction = new ActiveDataProvider([
            'query' => StatusApprovalDriverRequireAction::find()->joinWith(['statusApprovalDriverAction'])->andWhere(['status_approval_driver_require_action.status_approval_driver_id' => $id]),
            'pagination' => false,
            'sort' => false
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelStatusApprovalDriverRequire' => new StatusApprovalDriverRequire(),
            'dataProviderStatusApprovalDriverRequire' => $dataProviderStatusApprovalDriverRequire,
            'modelStatusApprovalDriverAction' => new StatusApprovalDriverAction(),
            'dataProviderStatusApprovalDriverAction' => $dataProviderStatusApprovalDriverAction,
            'modelStatusApprovalDriverRequireAction' => new StatusApprovalDriverRequireAction(),
            'dataProviderStatusApprovalDriverRequireAction' => $dataProviderStatusApprovalDriverRequireAction,
        ]);
    }

    /**
     * Creates a new StatusApprovalDriver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($save = null)
    {
        $model = new StatusApprovalDriver();
        $modelStatusApprovalDriverRequire = new StatusApprovalDriverRequire();
        $modelStatusApprovalDriverAction = new StatusApprovalDriverAction();
        $modelStatusApprovalDriverRequireAction = new StatusApprovalDriverRequireAction();

        if ($model->load(($post = \Yii::$app->request->post()))) {

            if (empty($save)) {

                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                $transaction = \Yii::$app->db->beginTransaction();
                $flag = false;

                $model->condition = !empty($model->condition);

                if (($flag = $model->save())) {

                    if (!empty($post['StatusApprovalDriverRequire'])) {

                        $modelStatusApprovalDriverRequire = [];

                        foreach ($post['StatusApprovalDriverRequire'] as $i => $statusApprovalDriverRequire) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalDriverRequire['id'])) {

                                    $newModelStatusApprovalDriverRequire = new StatusApprovalDriverRequire();
                                    $newModelStatusApprovalDriverRequire->status_approval_driver_id = $model->id;
                                    $newModelStatusApprovalDriverRequire->require_status_approval_driver_id = $statusApprovalDriverRequire['require_status_approval_driver_id'];

                                    if (($flag = $newModelStatusApprovalDriverRequire->save())) {

                                        array_push($modelStatusApprovalDriverRequire, $newModelStatusApprovalDriverRequire);
                                    } else {

                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($flag) {

                    if (!empty($post['StatusApprovalDriverAction'])) {

                        $modelStatusApprovalDriverAction = [];

                        foreach ($post['StatusApprovalDriverAction'] as $i => $statusApprovalDriverAction) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalDriverAction['id'])) {

                                    $newModelStatusApprovalDriverAction = new StatusApprovalDriverAction();
                                    $newModelStatusApprovalDriverAction->status_approval_driver_id = $model->id;
                                    $newModelStatusApprovalDriverAction->name = $statusApprovalDriverAction['name'];
                                    $newModelStatusApprovalDriverAction->url = $statusApprovalDriverAction['url'];

                                    if (($flag = $newModelStatusApprovalDriverAction->save())) {

                                        array_push($modelStatusApprovalDriverAction, $newModelStatusApprovalDriverAction);
                                    } else {

                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($flag) {

                    if (!empty($post['StatusApprovalDriverRequireAction'])) {

                        $modelStatusApprovalDriverRequireAction = [];

                        foreach ($post['StatusApprovalDriverRequireAction'] as $i => $statusApprovalDriverRequireAction) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalDriverRequireAction['id'])) {

                                    $newModelStatusApprovalDriverRequireAction = new StatusApprovalDriverRequireAction();
                                    $newModelStatusApprovalDriverRequireAction->status_approval_driver_id = $model->id;
                                    $newModelStatusApprovalDriverRequireAction->status_approval_driver_action_id = $statusApprovalDriverRequireAction['status_approval_driver_action_id'];

                                    if (($flag = $newModelStatusApprovalDriverRequireAction->save())) {

                                        array_push($modelStatusApprovalDriverRequireAction, $newModelStatusApprovalDriverRequireAction);
                                    } else {

                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($flag) {

                    \Yii::$app->session->setFlash('status', 'success');
                    \Yii::$app->session->setFlash('message1', \Yii::t('app', 'Create Data Is Success'));
                    \Yii::$app->session->setFlash('message2', \Yii::t('app', 'Create data process is success. Data has been saved'));

                    $transaction->commit();

                    return AjaxRequest::redirect($this, \Yii::$app->urlManager->createUrl(['masterdata/status-approval-driver/view', 'id' => $model->id]));
                } else {

                    $model->setIsNewRecord(true);

                    \Yii::$app->session->setFlash('status', 'danger');
                    \Yii::$app->session->setFlash('message1', \Yii::t('app', 'Create Data Is Fail'));
                    \Yii::$app->session->setFlash('message2', \Yii::t('app', 'Create data process is fail. Data fail to save'));

                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelStatusApprovalDriverRequire' => !empty($modelStatusApprovalDriverRequire) ? $modelStatusApprovalDriverRequire : new StatusApprovalDriverRequire(),
            'modelStatusApprovalDriverAction' => !empty($modelStatusApprovalDriverAction) ? $modelStatusApprovalDriverAction : new StatusApprovalDriverAction(),
            'modelStatusApprovalDriverRequireAction' => !empty($modelStatusApprovalDriverRequireAction) ? $modelStatusApprovalDriverRequireAction : new StatusApprovalDriverRequireAction(),
        ]);
    }

    /**
     * Updates an existing StatusApprovalDriver model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id, $save = null)
    {
        $model = $this->findModel($id);
        $modelStatusApprovalDriverRequire = !empty($model->statusApprovalDriverRequires) ? $model->statusApprovalDriverRequires : new StatusApprovalDriverRequire();
        $modelStatusApprovalDriverAction = !empty($model->statusApprovalDriverActions) ? $model->statusApprovalDriverActions : new StatusApprovalDriverAction();
        $modelStatusApprovalDriverRequireAction = !empty($model->statusApprovalDriverRequireActions) ? $model->statusApprovalDriverRequireActions : new StatusApprovalDriverRequireAction();

        if ($model->load(($post = \Yii::$app->request->post()))) {

            if (empty($save)) {

                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                $transaction = \Yii::$app->db->beginTransaction();
                $flag = false;

                $model->condition = !empty($model->condition);

                if (($flag = $model->save())) {

                    if (!empty($post['StatusApprovalDriverRequire'])) {

                        $modelStatusApprovalDriverRequire = [];

                        foreach ($post['StatusApprovalDriverRequire'] as $i => $statusApprovalDriverRequire) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalDriverRequire['id'])) {

                                    $newModelStatusApprovalDriverRequire = new StatusApprovalDriverRequire();
                                    $newModelStatusApprovalDriverRequire->status_approval_driver_id = $model->id;
                                    $newModelStatusApprovalDriverRequire->require_status_approval_driver_id = $statusApprovalDriverRequire['require_status_approval_driver_id'];

                                    if (($flag = $newModelStatusApprovalDriverRequire->save())) {

                                        array_push($modelStatusApprovalDriverRequire, $newModelStatusApprovalDriverRequire);
                                    } else {

                                        break;
                                    }
                                } else {

                                    foreach ($model->statusApprovalDriverRequires as $dataModelStatusApprovalDriverRequire) {

                                        if ($statusApprovalDriverRequire['id'] == $dataModelStatusApprovalDriverRequire->id) {

                                            if (empty($statusApprovalDriverRequire['delete']['id'])) {

                                                $dataModelStatusApprovalDriverRequire->require_status_approval_driver_id = $statusApprovalDriverRequire['require_status_approval_driver_id'];

                                                if (($flag = $dataModelStatusApprovalDriverRequire->save())) {

                                                    array_push($modelStatusApprovalDriverRequire, $dataModelStatusApprovalDriverRequire);
                                                } else {

                                                    break 2;
                                                }
                                            } else {

                                                if (!($flag = $dataModelStatusApprovalDriverRequire->delete())) {

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

                    if (!empty($post['StatusApprovalDriverAction'])) {

                        $modelStatusApprovalDriverAction = [];

                        foreach ($post['StatusApprovalDriverAction'] as $i => $statusApprovalDriverAction) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalDriverAction['id'])) {

                                    $newModelStatusApprovalDriverAction = new StatusApprovalDriverAction();
                                    $newModelStatusApprovalDriverAction->status_approval_driver_id = $model->id;
                                    $newModelStatusApprovalDriverAction->name = $statusApprovalDriverAction['name'];
                                    $newModelStatusApprovalDriverAction->url = $statusApprovalDriverAction['url'];

                                    if (($flag = $newModelStatusApprovalDriverAction->save())) {

                                        array_push($modelStatusApprovalDriverAction, $newModelStatusApprovalDriverAction);
                                    } else {

                                        break;
                                    }
                                } else {

                                    foreach ($model->statusApprovalDriverActions as $dataModelStatusApprovalDriverAction) {

                                        if ($statusApprovalDriverAction['id'] == $dataModelStatusApprovalDriverAction->id) {

                                            if (empty($statusApprovalDriverAction['delete']['id'])) {

                                                $dataModelStatusApprovalDriverAction->name = $statusApprovalDriverAction['name'];
                                                $dataModelStatusApprovalDriverAction->url = $statusApprovalDriverAction['url'];

                                                if (($flag = $dataModelStatusApprovalDriverAction->save())) {

                                                    array_push($modelStatusApprovalDriverAction, $dataModelStatusApprovalDriverAction);
                                                } else {

                                                    break 2;
                                                }
                                            } else {

                                                if (!($flag = $dataModelStatusApprovalDriverAction->delete())) {

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

                    if (!empty($post['StatusApprovalDriverRequireAction'])) {

                        $modelStatusApprovalDriverRequireAction = [];

                        foreach ($post['StatusApprovalDriverRequireAction'] as $i => $statusApprovalDriverRequireAction) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalDriverRequireAction['id'])) {

                                    $newModelStatusApprovalDriverRequireAction = new StatusApprovalDriverRequireAction();
                                    $newModelStatusApprovalDriverRequireAction->status_approval_driver_id = $model->id;
                                    $newModelStatusApprovalDriverRequireAction->status_approval_driver_action_id = $statusApprovalDriverRequireAction['status_approval_driver_action_id'];

                                    if (($flag = $newModelStatusApprovalDriverRequireAction->save())) {

                                        array_push($modelStatusApprovalDriverRequireAction, $newModelStatusApprovalDriverRequireAction);
                                    } else {

                                        break;
                                    }
                                } else {

                                    foreach ($model->statusApprovalDriverRequireActions as $dataModelStatusApprovalDriverRequireAction) {

                                        if ($statusApprovalDriverRequireAction['id'] == $dataModelStatusApprovalDriverRequireAction->id) {

                                            if (empty($statusApprovalDriverRequireAction['delete']['id'])) {

                                                $dataModelStatusApprovalDriverRequireAction->status_approval_driver_action_id = $statusApprovalDriverRequireAction['status_approval_driver_action_id'];

                                                if (($flag = $dataModelStatusApprovalDriverRequireAction->save())) {

                                                    array_push($modelStatusApprovalDriverRequireAction, $dataModelStatusApprovalDriverRequireAction);
                                                } else {

                                                    break 2;
                                                }
                                            } else {

                                                if (!($flag = $dataModelStatusApprovalDriverRequireAction->delete())) {

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

                    \Yii::$app->session->setFlash('status', 'success');
                    \Yii::$app->session->setFlash('message1', \Yii::t('app', 'Update Data Is Success'));
                    \Yii::$app->session->setFlash('message2', \Yii::t('app', 'Update data process is success. Data has been saved'));

                    $transaction->commit();
                } else {

                    \Yii::$app->session->setFlash('status', 'danger');
                    \Yii::$app->session->setFlash('message1', \Yii::t('app', 'Update Data Is Fail'));
                    \Yii::$app->session->setFlash('message2', \Yii::t('app', 'Update data process is fail. Data fail to save'));

                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelStatusApprovalDriverRequire' => !empty($modelStatusApprovalDriverRequire) ? $modelStatusApprovalDriverRequire : new StatusApprovalDriverRequire(),
            'modelStatusApprovalDriverAction' => !empty($modelStatusApprovalDriverAction) ? $modelStatusApprovalDriverAction : new StatusApprovalDriverAction(),
            'modelStatusApprovalDriverRequireAction' => !empty($modelStatusApprovalDriverRequireAction) ? $modelStatusApprovalDriverRequireAction : new StatusApprovalDriverRequireAction(),
        ]);
    }

    /**
     * Deletes an existing StatusApprovalDriver model.
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
            } catch (\yii\db\Exception $exc) {
                $error = \Yii::$app->params['errMysql'][$exc->errorInfo[1]];
            }
        }

        if ($flag) {

            \Yii::$app->session->setFlash('status', 'success');
            \Yii::$app->session->setFlash('message1', \Yii::t('app', 'Delete Is Success'));
            \Yii::$app->session->setFlash('message2', \Yii::t('app', 'Delete process is success. Data has been deleted'));
        } else {

            \Yii::$app->session->setFlash('status', 'danger');
            \Yii::$app->session->setFlash('message1', \Yii::t('app', 'Delete Is Fail'));
            \Yii::$app->session->setFlash('message2', \Yii::t('app', 'Delete process is fail. Data fail to delete' . $error));
        }

        $return = [];

        $return['url'] = \Yii::$app->urlManager->createUrl([$this->module->id . '/status-approval-driver/index']);

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function actionUp($id)
    {
        $model = $this->findModel($id);

        if ($model->order > 1) {

            $transaction = \Yii::$app->db->beginTransaction();
            $flag = false;

            $modelTemp = StatusApprovalDriver::findOne(['order' => $model->order - 1]);
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

                \Yii::$app->session->setFlash('status', 'danger');
                \Yii::$app->session->setFlash('message1', \Yii::t('app', 'Update Data Is Fail'));
                \Yii::$app->session->setFlash('message2', \Yii::t('app', 'Update data process is fail. Data fail to save'));

                $transaction->rollBack();
            }
        }

        return AjaxRequest::redirect($this, \Yii::$app->urlManager->createUrl(['masterdata/status-approval-driver/index']));
    }

    public function actionDown($id)
    {
        $model = $this->findModel($id);

        $modelTemp = StatusApprovalDriver::findOne(['order' => $model->order + 1]);

        if ($modelTemp !== 0) {

            $transaction = \Yii::$app->db->beginTransaction();
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

                \Yii::$app->session->setFlash('status', 'danger');
                \Yii::$app->session->setFlash('message1', \Yii::t('app', 'Update Data Is Fail'));
                \Yii::$app->session->setFlash('message2', \Yii::t('app', 'Update data process is fail. Data fail to save'));

                $transaction->rollBack();
            }
        }

        return AjaxRequest::redirect($this, \Yii::$app->urlManager->createUrl(['masterdata/status-approval-driver/index']));
    }

    /**
     * Finds the StatusApprovalDriver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return StatusApprovalDriver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StatusApprovalDriver::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
