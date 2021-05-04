<?php

namespace app\models\misc;

use app\models\AuthAssignment;
use app\models\AuthItem;
use Yii;
use yii\base\Model;
use yii\rbac\DbManager;
use app\models\User;

class RoleManager extends Model
{
    private $user;
    public $new_role;
    public $role;

    /**
     * The constructor.
     *
     * @param User $user the role that will be assigned to the user.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->role = ($roles = Yii::$app->authManager->getRolesByUser($this->user->id)) ? array_keys($roles)[0] : null;
    }

    /**
     * Updates users role.
     *
     * @param string $role_name the role that will be assigned to the user.
     * @return bool
     */
    public function updateRole($role_name)
    {
        $assignment = $this->getCurrentRole();
        $assignment->item_name = $role_name;
        return $assignment->save();
    }

    /**
     * Sets the new role name.
     *
     * @param string $role_name the role that will be assigned to the user.
     * @return RoleManager
     */
    public function setNewRole($role_name)
    {
        $this->new_role = $role_name;
        return $this;
    }

    /**
     * Gets all available system roles.
     *
     * @return string[]
     */
    public static function getRoleArray()
    {
        $items = AuthItem::find()->where(['type' => 1])->all();

        $role_list = [];

        foreach($items as $item) {
            $role_list[$item->name] = $item->name;
        }

        return $role_list;
    }

    /**
     * Sets the default role to user.
     *
     * @param int $user_id the users ID.
     */
    public static function setDefaultRole($user_id)
    {
        $auth = new DbManager();

        $role = $auth->getRole(Constants::$DEFAULT_ROLE);
        $auth->assign($role, $user_id);
    }

    /**
     * Removes all assignments for user.
     *
     * @return bool
     */
    public function removeAssignments()
    {
        return Yii::$app->authManager->revokeAll($this->user->id);
    }

    /**
     * Gets current role for the user.
     *
     * @return AuthAssignment
     */
    private function getCurrentRole()
    {
        return AuthAssignment::find()->where(['user_id' => $this->user->id])->andWhere(['item_name' => $this->role])->one();
    }
}
