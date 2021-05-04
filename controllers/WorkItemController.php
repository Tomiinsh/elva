<?php

namespace app\controllers;

use app\models\ConstructionSite;
use app\models\EmployeeWorkItem;
use Yii;
use app\models\WorkItem;
use app\models\WorkItemSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * WorkItemController implements the CRUD actions for WorkItem model.
 */
class WorkItemController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view', 'create', 'update', 'delete', 'my-work', 'index'],
                'rules' => [
                    [
                        'actions' => ['view', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['can_manage_work_item'],
                        'roleParams' =>
                            function () {
                            $cs_id = WorkItem::findOne(Yii::$app->request->get('id'))->getAttribute('construction_site_id');
                            return [
                                'construction_site_id' => $cs_id
                            ];
                        }
                    ],
                    [
                        'actions' => ['my-work'],
                        'allow' => true,
                        'roles' => ['employee']
                    ],
                    [
                        'actions' => ['index', 'create'],
                        'allow' => true,
                        'roles' => ['admin', 'manager']
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all WorkItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkItem model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $work_item = new EmployeeWorkItem();

        return $this->render('view', [
            'model' => $model,
            'assignUrl' => ['employee-work-item/assign', 'work_item_id' => $id, 'construction_site_id' => $model->construction_site_id],
            'removeUrl' => ['employee-work-item/remove', 'work_item_id' => $id, 'construction_site_id' => $model->construction_site_id],
            'items' => Json::htmlEncode(['items' => $work_item->getItems($id, $model->construction_site_id)])
        ]);
    }

    /**
     * Creates a new WorkItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WorkItem();

        if(Yii::$app->user->can('manager')) {
            $model->construction_site_id = ConstructionSite::findOne(['manager_id' => Yii::$app->user->identity->employee_id])->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'construction_site_list' => ConstructionSite::getConstructionSitesArray()
        ]);
    }

    /**
     * Updates an existing WorkItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'construction_site_list' => ConstructionSite::getConstructionSitesArray()
        ]);
    }

    /**
     * Deletes an existing WorkItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $employee_work_items = EmployeeWorkItem::findAll(['work_item_id' => $id]);

        if($employee_work_items){
            foreach($employee_work_items as $work_item){
                $work_item->delete();
            }
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionMyWork()
    {
        return $this->render('my-work');
    }

    /**
     * Finds the WorkItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
