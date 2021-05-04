<?php

namespace app\controllers;

use Yii;
use app\models\EmployeeConstructionSite;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\EmployeeWorkItem;

class EmployeeConstructionSiteController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['assign', 'remove'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['assign', 'remove'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('manage_construction_sites');
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Assign user access to construction site.
     * @param integer $id
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);

        EmployeeConstructionSite::assign($id, $items);

        return (new EmployeeConstructionSite())->getItems($id);
    }

    /**
     * Remove user access to construction site.
     * @param integer $id
     * @return array
     */
    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);

        foreach($items as $item)
        {
            EmployeeConstructionSite::find()->where(['construction_site_id' => $id])->andWhere(['employee_id' => $item])->one()->delete();

            $employee_work_items = EmployeeWorkItem::find()
                ->join('JOIN', 'work_item', 'work_item_id = id')
                ->where('employee_work_item.employee_id = ' . $item)
                ->all();

            foreach($employee_work_items as $work_item) $work_item->delete();

        }

        return (new EmployeeConstructionSite())->getItems($id);
    }

}
