<?php
namespace app\rbac;

use yii\rbac\Rule;

    /**
    * Checks if authorID matches user passed via params
    */
    class CanHaveManager extends Rule
    {
        public $name = 'CanHaveManager';

        /**
        * @param string|int $user the user ID.
        * @param Item $item the role or permission that this rule is associated with
        * @param array $params parameters passed to ManagerInterface::checkAccess().
        * @return bool a value indicating whether the rule permits the role or permission it is associated with.
        */
        public function execute($user, $item, $params)
        {
            if(isset($params['emplooyee'])) {
                return $params->params['employee']->manager_id === null;
            }

            return false;
//            return isset($params['post']) ? $params['post']->createdBy == $user : false;
        }
    }
?>