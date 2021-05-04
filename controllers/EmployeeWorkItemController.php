<?php

namespace app\controllers;

use app\models\EmployeeWorkItem;
use yii\web\Response;
use Yii;

class EmployeeWorkItemController extends \yii\web\Controller
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

        ];
    }

    /**
     * Assigns work items for given user.
     * @param integer $work_item_id
     * @param integer $construction_site_id
     * @return array
     */
    public function actionAssign($work_item_id, $construction_site_id)
    {
        $items = Yii::$app->getRequest()->post('items', []);

        EmployeeWorkItem::assign($work_item_id, $items);

        return (new EmployeeWorkItem())->getItems($work_item_id, $construction_site_id);
    }

    /**
     * Removes work items for given user.
     * @param integer $work_item_id
     * @param integer $construction_site_id
     * @return array
     */
    public function actionRemove($work_item_id, $construction_site_id)
    {
        $items = Yii::$app->getRequest()->post('items', []);

        foreach($items as $item)
        {
            $work_item = EmployeeWorkItem::find()->where(['work_item_id' => $work_item_id])
                ->andWhere(['employee_id' => $item])->one();
            if(isset($work_item)) $work_item->delete();
        }

        return (new EmployeeWorkItem())->getItems($work_item_id, $construction_site_id);
    }

}
