<?php
namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property int|null $manager_id
 *
 * @property ConstructionSite[] $constructionSites
 * @property Employee $id0
 * @property Employee $employee
 * @property EmployeeConstructionSite[] $employeeConstructionSites
 * @property EmployeeWorkItem[] $employeeWorkItems
 * @property User[] $users
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'date_of_birth'], 'required'],
            [['date_of_birth'], 'safe'],
            [['manager_id'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['manager_id'], 'exist', 'skipOnError' => false, 'targetClass' => Employee::className(), 'targetAttribute' => ['manager_id' => 'id']],
            ['manager_id', 'checkValidManager', 'skipOnEmpty' => false]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Vārds',
            'last_name' => 'Uzvārds',
            'date_of_birth' => 'Dzimšanas datums',
            'manager_id' => 'Menedžeris',
        ];
    }

    /**
     * Gets query for [[ConstructionSites]].
     *
     * @return \yii\db\ActiveQuery|ConstructionSiteQuery
     */
    public function getConstructionSites()
    {
        return $this->hasMany(ConstructionSite::className(), ['manager_id' => 'id']);
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery|EmployeeQuery
     */
    public function getId0()
    {
        return $this->hasOne(Employee::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery|EmployeeQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[EmployeeConstructionSites]].
     *
     * @return \yii\db\ActiveQuery|EmployeeConstructionSiteQuery
     */
    public function getEmployeeConstructionSites()
    {
        return $this->hasMany(EmployeeConstructionSite::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[EmployeeWorkItems]].
     *
     * @return \yii\db\ActiveQuery|EmployeeWorkItemQuery
     */
    public function getEmployeeWorkItems()
    {
        return $this->hasMany(EmployeeWorkItem::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[WorkItems]].
     *
     * @return \yii\db\ActiveQuery|WorkItemQuery
     */
    public function getWorkItems()
    {
        return $this->hasMany(WorkItem::className(), ['id' => 'work_item_id'])->via('employeeWorkItems');
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['employee_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeQuery(get_called_class());
    }

    /**
     * Check if manager ID is valid
     * @param $attribute
     */
    public function checkValidManager($attribute)
    {
        //null manager is accepted
        if($this->$attribute == null) return true;

        $user_id = static::findOne(['id' => $this->$attribute])->getUser()->one()->id;

        if(!Yii::$app->authManager->checkAccess($user_id, 'manager')){
            $this->addError($attribute, 'Šis darbinieks nav menedžeris!');
        }

        if($this->id == $this->$attribute){
            $this->addError($attribute, 'Menedžeris nevar būt menedžeris pats sev!');
        }

        if(Yii::$app->authManager->checkAccess($user_id, 'admin')){
             $this->addError($attribute, 'Administratoram nevar būt menedžeris!');
        }

    }

    /**
     * Filters employees by role.
     * @param array $employee_list
     * @param array $role_list
     * @return array
     */
    public static function filterByRoles($employee_list, $role_list)
    {
        $filtered_employees = [];

        foreach($employee_list as $employee)
        {
            foreach($role_list as $role)
            {
                if(Yii::$app->authManager->checkAccess($employee->getUser()->one()->id, $role))
                {
                    array_push($filtered_employees, $employee);
                }
            }
        }

        return $filtered_employees;
    }

    /**
     * Returns mapped employee list.
     * @param array $list
     * @param string $from
     * @return array
     */
    public static function fullNameMap($list, $from)
    {
        return ArrayHelper::map($list, $from, function($employee){
            return $employee->first_name . " " . $employee->last_name;
        });
    }

}
