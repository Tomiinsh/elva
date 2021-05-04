<?php


namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\Employee;
use app\models\misc\RoleManager;
use app\models\misc\Constants;


class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_repeat;
    public $first_name;
    public $last_name;
    public $date_of_birth;

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat', 'first_name', 'last_name', 'date_of_birth'], 'required', 'message' => 'Lūdzu ievadi {attribute}'],
            [['username'], 'unique', 'targetClass' => 'app\models\User', 'message' => 'Lietotājvārds jau ir aizņemts. Lūdzu izvēlies citu!'],
            [['username'], 'string', 'min' => 6, 'max' => 60, 'tooLong' => 'Lietotājvārds nevar būt garāks par {max} rakstzīmēm!', 'tooShort' => 'Lietotājvārds nevar būt īsāks par {min} rakstzīmēm!'],
            [['password'], 'string', 'min' => 6, 'max' => 16, 'tooLong' => 'Parole nevar būt garāka par {max} rakstzīmēm!', 'tooShort' => 'Parole nevar būt īsāka par {min} rakstzīmēm!'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Ievadītās paroles nav vienādas!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Lietotājvārds',
            'first_name' => 'Vārds',
            'last_name' => 'Uzvārds',
            'date_of_birth' => 'Dzimšanas datums',
            'password' => 'Parole',
            'password_repeat' => 'Parole atkārtoti'
        ];
    }

    public function signup()
    {
        $user = new User();
        $employee = new Employee();

        $employee->first_name = $this->first_name;
        $employee->last_name = $this->last_name;
        $employee->date_of_birth = $this->date_of_birth;
        $employee->manager_id = Constants::$NO_MANAGER_ID;

        $user->username = $this->username;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $user->access_token = Yii::$app->getSecurity()->generateRandomString(60);
        $user->auth_key = Yii::$app->getSecurity()->generateRandomString(60);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $employee->save();
            $user->employee_id = $employee->id;
            $user->save();

            RoleManager::setDefaultRole($user->id);

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        Yii::error("User was not saved!");
        return false;
    }
}