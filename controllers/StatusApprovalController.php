<?php

namespace backoffice\modules\masterdata\controllers;

use Yii;
use core\models\StatusApproval;
use core\models\search\StatusApprovalSearch;
use core\models\StatusApprovalRequire;
use core\models\StatusApprovalAction;
use core\models\StatusApprovalRequireAction;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use sycomponent\AjaxRequest;

/**
 * StatusApprovalController implements the CRUD actions for StatusApproval model.
 */
class StatusApprovalController extends \backoffice\controllers\BaseController
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
     * Lists all StatusApproval models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatusApprovalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StatusApproval model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProviderStatusApprovalRequire = new ActiveDataProvider([
            'query' => StatusApprovalRequire::find()->joinWith(['requireStatusApproval'])->andWhere(['status_approval_require.status_approval_id' => $id]),
            'pagination' => false,
            'sort' => false
        ]);

        $dataProviderStatusApprovalAction = new ActiveDataProvider([
            'query' => StatusApprovalAction::find()->andWhere(['status_approval_action.status_approval_id' => $id]),
            'pagination' => false,
            'sort' => false
        ]);

        $dataProviderStatusApprovalRequireAction = new ActiveDataProvider([
            'query' => StatusApprovalRequireAction::find()->joinWith(['statusApprovalAction'])->andWhere(['status_approval_require_action.status_approval_id' => $id]),
            'pagination' => false,
            'sort' => false
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelStatusApprovalRequire' => new StatusApprovalRequire(),
            'dataProviderStatusApprovalRequire' => $dataProviderStatusApprovalRequire,
            'modelStatusApprovalAction' => new StatusApprovalAction(),
            'dataProviderStatusApprovalAction' => $dataProviderStatusApprovalAction,
            'modelStatusApprovalRequireAction' => new StatusApprovalRequireAction(),
            'dataProviderStatusApprovalRequireAction' => $dataProviderStatusApprovalRequireAction,
        ]);
    }

    /**
     * Creates a new StatusApproval model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($save = null)
    {
        $model = new StatusApproval();
        $modelStatusApprovalRequire = new StatusApprovalRequire();
        $modelStatusApprovalAction = new StatusApprovalAction();
        $modelStatusApprovalRequireAction = new StatusApprovalRequireAction();

        if ($model->load(($post = Yii::$app->request->post()))) {

            if (empty($save)) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                $transaction = Yii::$app->db->beginTransaction();
                $flag = false;

                $model->condition = !empty($model->condition);

                $flag = $model->save();

                if ($flag) {
                    if (!empty($post['StatusApprovalRequire'])) {

                        $modelStatusApprovalRequire = [];

                        foreach ($post['StatusApprovalRequire'] as $i => $statusApprovalRequire) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalRequire['id'])) {

                                    $newModelStatusApprovalRequire = new StatusApprovalRequire();
                                    $newModelStatusApprovalRequire->status_approval_id = $model->id;
                                    $newModelStatusApprovalRequire->require_status_approval_id = $statusApprovalRequire['require_status_approval_id'];

                                    if (($flag = $newModelStatusApprovalRequire->save())) {
                                        array_push($modelStatusApprovalRequire, $newModelStatusApprovalRequire);
                                    } else {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($flag) {
                    if (!empty($post['StatusApprovalAction'])) {

                        $modelStatusApprovalAction = [];

                        foreach ($post['StatusApprovalAction'] as $i => $statusApprovalAction) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalAction['id'])) {

                                    $newModelStatusApprovalAction = new StatusApprovalAction();
                                    $newModelStatusApprovalAction->status_approval_id = $model->id;
                                    $newModelStatusApprovalAction->name = $statusApprovalAction['name'];
                                    $newModelStatusApprovalAction->url = $statusApprovalAction['url'];

                                    if (($flag = $newModelStatusApprovalAction->save())) {
                                        array_push($modelStatusApprovalAction, $newModelStatusApprovalAction);
                                    } else {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($flag) {
                    if (!empty($post['StatusApprovalRequireAction'])) {

                        $modelStatusApprovalRequireAction = [];

                        foreach ($post['StatusApprovalRequireAction'] as $i => $statusApprovalRequireAction) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalRequireAction['id'])) {

                                    $newModelStatusApprovalRequireAction = new StatusApprovalRequireAction();
                                    $newModelStatusApprovalRequireAction->status_approval_id = $model->id;
                                    $newModelStatusApprovalRequireAction->status_approval_action_id = $statusApprovalRequireAction['status_approval_action_id'];

                                    if (($flag = $newModelStatusApprovalRequireAction->save())) {
                                        array_push($modelStatusApprovalRequireAction, $newModelStatusApprovalRequireAction);
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

                    return AjaxRequest::redirect($this, Yii::$app->urlManager->createUrl(['masterdata/status-approval/view', 'id' => $model->id]));
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
            'modelStatusApprovalRequire' => !empty($modelStatusApprovalRequire) ? $modelStatusApprovalRequire : new StatusApprovalRequire(),
            'modelStatusApprovalAction' => !empty($modelStatusApprovalAction) ? $modelStatusApprovalAction : new StatusApprovalAction(),
            'modelStatusApprovalRequireAction' => !empty($modelStatusApprovalRequireAction) ? $modelStatusApprovalRequireAction : new StatusApprovalRequireAction(),
        ]);
    }

    /**
     * Updates an existing StatusApproval model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $save = null)
    {
        $model = $this->findModel($id);
        $modelStatusApprovalRequire = !empty($model->statusApprovalRequires) ? $model->statusApprovalRequires : new StatusApprovalRequire();
        $modelStatusApprovalAction = !empty($model->statusApprovalActions) ? $model->statusApprovalActions : new StatusApprovalAction();
        $modelStatusApprovalRequireAction = !empty($model->statusApprovalRequireActions) ? $model->statusApprovalRequireActions : new StatusApprovalRequireAction();

        if ($model->load(($post = Yii::$app->request->post()))) {

            if (empty($save)) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                $transaction = Yii::$app->db->beginTransaction();
                $flag = false;

                $model->condition = !empty($model->condition);

                $flag = $model->save();

                if ($flag) {
                    if (!empty($post['StatusApprovalRequire'])) {

                        $modelStatusApprovalRequire = [];

                        foreach ($post['StatusApprovalRequire'] as $i => $statusApprovalRequire) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalRequire['id'])) {

                                    $newModelStatusApprovalRequire = new StatusApprovalRequire();
                                    $newModelStatusApprovalRequire->status_approval_id = $model->id;
                                    $newModelStatusApprovalRequire->require_status_approval_id = $statusApprovalRequire['require_status_approval_id'];

                                    if (($flag = $newModelStatusApprovalRequire->save())) {
                                        array_push($modelStatusApprovalRequire, $newModelStatusApprovalRequire);
                                    } else {
                                        break;
                                    }
                                } else {

                                    foreach ($model->statusApprovalRequires as $dataModelStatusApprovalRequire) {

                                        if ($statusApprovalRequire['id'] == $dataModelStatusApprovalRequire->id) {

                                            if (empty($statusApprovalRequire['delete']['id'])) {

                                                $dataModelStatusApprovalRequire->require_status_approval_id = $statusApprovalRequire['require_status_approval_id'];

                                                if (($flag = $dataModelStatusApprovalRequire->save())) {
                                                    array_push($modelStatusApprovalRequire, $dataModelStatusApprovalRequire);
                                                } else {
                                                    break 2;
                                                }
                                            } else {

                                                if (!($flag = $dataModelStatusApprovalRequire->delete())) {
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
                    if (!empty($post['StatusApprovalAction'])) {

                        $modelStatusApprovalAction = [];

                        foreach ($post['StatusApprovalAction'] as $i => $statusApprovalAction) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalAction['id'])) {

                                    $newModelStatusApprovalAction = new StatusApprovalAction();
                                    $newModelStatusApprovalAction->status_approval_id = $model->id;
                                    $newModelStatusApprovalAction->name = $statusApprovalAction['name'];
                                    $newModelStatusApprovalAction->url = $statusApprovalAction['url'];

                                    if (($flag = $newModelStatusApprovalAction->save())) {
                                        array_push($modelStatusApprovalAction, $newModelStatusApprovalAction);
                                    } else {
                                        break;
                                    }
                                } else {

                                    foreach ($model->statusApprovalActions as $dataModelStatusApprovalAction) {

                                        if ($statusApprovalAction['id'] == $dataModelStatusApprovalAction->id) {

                                            if (empty($statusApprovalAction['delete']['id'])) {

                                                $dataModelStatusApprovalAction->name = $statusApprovalAction['name'];
                                                $dataModelStatusApprovalAction->url = $statusApprovalAction['url'];

                                                if (($flag = $dataModelStatusApprovalAction->save())) {
                                                    array_push($modelStatusApprovalAction, $dataModelStatusApprovalAction);
                                                } else {
                                                    break 2;
                                                }
                                            } else {

                                                if (!($flag = $dataModelStatusApprovalAction->delete())) {
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
                    if (!empty($post['StatusApprovalRequireAction'])) {

                        $modelStatusApprovalRequireAction = [];

                        foreach ($post['StatusApprovalRequireAction'] as $i => $statusApprovalRequireAction) {

                            if ($i !== 'index') {

                                if (empty($statusApprovalRequireAction['id'])) {

                                    $newModelStatusApprovalRequireAction = new StatusApprovalRequireAction();
                                    $newModelStatusApprovalRequireAction->status_approval_id = $model->id;
                                    $newModelStatusApprovalRequireAction->status_approval_action_id = $statusApprovalRequireAction['status_approval_action_id'];

                                    if (($flag = $newModelStatusApprovalRequireAction->save())) {
                                        array_push($modelStatusApprovalRequireAction, $newModelStatusApprovalRequireAction);
                                    } else {
                                        break;
                                    }
                                } else {

                                    foreach ($model->statusApprovalRequireActions as $dataModelStatusApprovalRequireAction) {

                                        if ($statusApprovalRequireAction['id'] == $dataModelStatusApprovalRequireAction->id) {

                                            if (empty($statusApprovalRequireAction['delete']['id'])) {

                                                $dataModelStatusApprovalRequireAction->status_approval_action_id = $statusApprovalRequireAction['status_approval_action_id'];

                                                if (($flag = $dataModelStatusApprovalRequireAction->save())) {
                                                    array_push($modelStatusApprovalRequireAction, $dataModelStatusApprovalRequireAction);
                                                } else {
                                                    break 2;
                                                }
                                            } else {

                                                if (!($flag = $dataModelStatusApprovalRequireAction->delete())) {
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
            'modelStatusApprovalRequire' => !empty($modelStatusApprovalRequire) ? $modelStatusApprovalRequire : new StatusApprovalRequire(),
            'modelStatusApprovalAction' => !empty($modelStatusApprovalAction) ? $modelStatusApprovalAction : new StatusApprovalAction(),
            'modelStatusApprovalRequireAction' => !empty($modelStatusApprovalRequireAction) ? $modelStatusApprovalRequireAction : new StatusApprovalRequireAction(),
        ]);
    }

    /**
     * Deletes an existing StatusApproval model.
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

        $return['url'] = Yii::$app->urlManager->createUrl([$this->module->id . '/status-approval/index']);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function actionUp($id) {

        $model = $this->findModel($id);

        if ($model->order > 1) {

            $transaction = Yii::$app->db->beginTransaction();
            $flag = false;

            $modelTemp = StatusApproval::findOne(['order' => $model->order - 1]);
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

        return AjaxRequest::redirect($this, Yii::$app->urlManager->createUrl(['masterdata/status-approval/index']));
    }

    public function actionDown($id) {

        $model = $this->findModel($id);

        $modelTemp = StatusApproval::findOne(['order' => $model->order + 1]);

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

        return AjaxRequest::redirect($this, Yii::$app->urlManager->createUrl(['masterdata/status-approval/index']));
    }

    /**
     * Finds the StatusApproval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StatusApproval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StatusApproval::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
