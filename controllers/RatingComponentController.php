<?php

namespace backoffice\modules\masterdata\controllers;

use Yii;
use core\models\RatingComponent;
use core\models\search\RatingComponentSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * RatingComponentController implements the CRUD actions for RatingComponent model.
 */
class RatingComponentController extends \backoffice\controllers\BaseController
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
     * Lists all RatingComponent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RatingComponentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RatingComponent model.
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
     * Creates a new RatingComponent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($save = null)
    {
        $render = 'create';

        $model = new RatingComponent();

        if ($model->load(Yii::$app->request->post())) {

            if (empty($save)) {

                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            } else {

                $last = RatingComponent::find()
                        ->orderBy('order DESC')
                        ->asArray()->one();

                $model->order = $last['order'] + 1;

                if ($model->save()) {

                    Yii::$app->session->setFlash('status', 'success');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Create Data Is Success'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Create data process is success. Data has been saved'));

                    $render = 'view';
                } else {

                    $model->setIsNewRecord(true);

                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message1', Yii::t('app', 'Create Data Is Fail'));
                    Yii::$app->session->setFlash('message2', Yii::t('app', 'Create data process is fail. Data fail to save'));
                }
            }
        }

        return $this->render($render, [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RatingComponent model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing RatingComponent model.
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

        $return['url'] = Yii::$app->urlManager->createUrl([$this->module->id . '/rating-component/index']);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function actionUp($id) {

        $model = $this->findModel($id);

        if ($model->order > 1) {

            $transaction = Yii::$app->db->beginTransaction();
            $flag = false;

            $modelTemp = RatingComponent::findOne(['order' => $model->order - 1]);
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

        return $this->runAction('index');
    }

    public function actionDown($id) {

        $model = $this->findModel($id);

        $modelTemp = RatingComponent::findOne(['order' => $model->order + 1]);

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

        return $this->runAction('index');
    }

    /**
     * Finds the RatingComponent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RatingComponent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RatingComponent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
