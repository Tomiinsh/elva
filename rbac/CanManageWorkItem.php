<?php
namespace app\rbac;
use app\models\ConstructionSite;
use yii\rbac\Rule;
use Yii;
use app\models\User;

class CanManageWorkItem extends Rule
{
    public $name = 'CanManageWorkItem';

    public function execute($user, $item, $params)
    {
        if(Yii::$app->authManager->checkAccess($user, 'admin')) return true;

        if(isset($params['construction_site_id'])) {
            return ConstructionSite::findOne($params['construction_site_id'])->getAttribute('manager_id') == User::findOne($user)->getAttribute('employee_id');
        }

        return false;
    }
}



?>