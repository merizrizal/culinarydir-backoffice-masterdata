<?php

namespace backend\controllers;

use Yii;
use backend\models\Village;
use backend\models\search\VillageSearch;
use sybase\SybaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * VillageController implements the CRUD actions for Village model.
 */
class VillageController extends SybaseController
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
     * Lists all Village models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            $this->layout = 'ajax';
        }

        $searchModel = new VillageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Village model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
            $this->layout = 'ajax';
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Village model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($save = null)
    {
        if (Yii::$app->request->isAjax) {
            $this->layout = 'ajax';
        }

        $render = 'create';

        $model = new Village();

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
     * Updates an existing Village model.
     * If update is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $save = null)
    {
        if (Yii::$app->request->isAjax) {
            $this->layout = 'ajax';
        }

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
     * Deletes an existing Village model.
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

        $return['url'] = Yii::$app->urlManager->createUrl(['village/index']);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    /**
     * Finds the Village model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Village the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Village::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetVillageByDistrict($id)
    {
        $data = Village::find()->andWhere(['district_id' => $id])->orderBy('name')->asArray()->all();

        $row = [];

        foreach ($data as $key => $value) {
            $row[$key]['id'] = $value['id'];
            $row[$key]['text'] = $value['name'];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $row;
    }
}
