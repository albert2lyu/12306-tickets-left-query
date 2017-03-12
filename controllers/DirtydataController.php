<?php

namespace app\controllers;

use Yii;
use app\models\Dirtydata;
use app\models\DirtydataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Station;
/**
 * DirtydataController implements the CRUD actions for Dirtydata model.
 */
class DirtydataController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['loaddirtydata', 'index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['loaddirtydata', 'index', 'create', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    public function actionLoadall($to = null){

        if(!$to){
            DirtyData::loadAll();
        }else{
            DirtyData::loadAll($to);
        }

        //   return $this->redirect(['dirtydata/index']);
    }
    public function actionLoaddirtydata(){
        $dirtydata = new Dirtydata();

        if($dirtydata->load(Yii::$app->request->post()) && $dirtydata->validate()){
            $from = Station::find()->where(['name'=>$dirtydata->from_station_name])->one();
            $to = Station::find()->where(['name'=>$dirtydata->to_station_name])->one();
            if($loadResult = Dirtydata::loadDirtyData($from, $to, $dirtydata->date)){
                return $this->redirect(['dirtydata/index']);
            }else{
                $dirtydata->addError('from_station_name', json_encode($loadResult));
            }
        }
        return $this->render('loaddirtydata',[
            'model'=> $dirtydata
        ]);
    }
    /**
     * Lists all Dirtydata models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DirtydataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dirtydata model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dirtydata model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dirtydata();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dirtydata model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Dirtydata model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dirtydata model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dirtydata the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dirtydata::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
