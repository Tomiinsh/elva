<?php

namespace app\controllers;

use app\models\ConstructionSite;
use app\models\EmployeeConstructionSite;
use yii\web\Response;
use app\models\Employee;

class ApiController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'only' => ['get-construction-site-info'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],

        ];
    }

    /**
     * Returns construction site and access information.
     * @param integer $id
     * @return array
     */
    public function actionGetConstructionSiteInfo($id)
    {
        $output = [];
        $construction_site = ConstructionSite::findOne($id);
        $construction_site_access = EmployeeConstructionSite::findAll($id);

        if(isset($construction_site))
        {
            $output['message'] = 'success';

            $output['construction_site'] = [
                'id' => $construction_site->id,
                'name' => $construction_site->name,
                'location' => $construction_site->location,
                'manager' => $construction_site->getManager()
            ];

            foreach($construction_site_access as $access_item)
            {
                $employee = Employee::findOne($access_item->employee_id);

                $output['access'][$employee->id] = $employee;
            }
        } else {
            $output['message'] = 'Construction site not found!';
        }

        return $output;
    }

}
