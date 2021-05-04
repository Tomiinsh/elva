<?php

namespace app\controllers;

use app\models\Employee;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\forms\SignupForm;
use yii\widgets\ActiveForm;
use app\models\ConstructionSite;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest) return $this->redirect(['site/login']);
        if(Yii::$app->user->can('employee')) {
            return $this->redirect(['work-item/my-work']);
        }

        $construction_site = null;
        $employee_data_provider = null;

        if(Yii::$app->user->can('manager')){
            $construction_site = ConstructionSite::findOne(['manager_id' => Yii::$app->user->identity->employee_id]);

            $employee_data_provider = new ActiveDataProvider([
                'query' => Employee::find()->where(['manager_id' => Yii::$app->user->identity->employee_id])
            ]);
        }

        return $this->render('index', [
            'construction_site' => $construction_site,
            'employee_data_provider' => $employee_data_provider
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if(Yii::$app->user->can('employee')) {
                return $this->redirect(['work-item/my-work']);
            }
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signup action.
     *
     * @return Response|string|array
     */
    public function actionSignup()
    {
        if(!Yii::$app->user->isGuest)
        {
            return $this->redirect('/site/index');
        }

        $model = new SignupForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if($model->load(Yii::$app->request->post()) && $model->signup())
        {
            return $this->redirect(Yii::$app->homeUrl);
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }
}
