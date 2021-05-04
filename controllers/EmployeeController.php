<?php

namespace app\controllers;


use Yii;
use app\models\Employee;
use app\models\EmployeeSearch;
use app\models\misc\Constants;
use app\models\User;
use app\models\misc\RoleManager;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
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
                'only' => ['view', 'index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['view', 'index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('manage_employees');
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
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
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $role_manager = new RoleManager($model->getUser()->one());

        if($model->load(Yii::$app->request->post()) && $model->save()) {

            $role_manager->updateRole($_POST['RoleManager']['role']);

            return $this->redirect(['view', 'id' => $model->id]);
        }


        return $this->render('update', [
            'model' => $model,
            'role_manager' => $role_manager
        ]);
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $employee = $this->findModel($id);
        $user = $employee->getUser()->one();

        //Update all employee managers if their manager is deleted.
        if(Yii::$app->authManager->checkAccess($user->id, 'manager')) {
            Employee::updateAll(['manager_id' => Constants::$NO_MANAGER_ID], 'manager_id = ' . $id);
        }

        $user->removeAssignments();
        $user->delete();
        $employee->delete();

        return $this->redirect(['index']);
    }

    /**
     * Returns systems manager list.
     * @return array
     */
    public function actionGetManagerList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $employee_id = null;
        $output = ['output' => '', 'selected' => ''];
        $manager_id_list = Yii::$app->authManager->getUserIdsByRole('manager');

        if(isset($_POST['depdrop_params'])) {
            $params = $_POST['depdrop_params'];
            $selected_role = $params[0];
            $employee_id = $params[1];
        }

        if(isset($selected_role) && $selected_role != 'employee') return $output;
        $output['output'] = $this->buildManagerListArray($manager_id_list, $employee_id);

        return $output;
    }

    /**
     * Returns systems manager list.
     * @param array $manager_id_list
     * @param int $employee_id
     * @return array
     */
    private function buildManagerListArray($manager_id_list, $employee_id)
    {
        $manager_list = [];

        for($i = 0; $i< sizeof($manager_id_list); $i++) {
            $employee = User::findOne($manager_id_list[$i])->getEmployee()->one();

            //Skip request employee
            if (isset($employee_id) && $employee_id == $employee->id) continue;

            $manager_list[$i]['id'] = $employee->id;
            $manager_list[$i]['name'] = $employee->first_name . " " . $employee->last_name;
        }

        return $manager_list;
    }


    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
