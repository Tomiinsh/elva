<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "employee_construction_site".
 *
 * @property int $employee_id
 * @property int $construction_site_id
 *
 * @property ConstructionSite $constructionSite
 * @property Employee $employee
 */
class EmployeeConstructionSite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_construction_site';
    }

    public static function primaryKey()
    {
        return [
            'construction_site_id',
            'employee_id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'construction_site_id'], 'required'],
            [['employee_id', 'construction_site_id'], 'integer'],
            [['construction_site_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConstructionSite::className(), 'targetAttribute' => ['construction_site_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'Employee ID',
            'construction_site_id' => 'Construction Site ID',
        ];
    }

    /**
     * Gets query for [[ConstructionSite]].
     *
     * @return \yii\db\ActiveQuery|ConstructionSiteQuery
     */
    public function getConstructionSite()
    {
        return $this->hasOne(ConstructionSite::className(), ['id' => 'construction_site_id']);
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery|EmployeeQuery
     */
    public function getEmployee()
    {
        return $this->hasMany(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeConstructionSiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeConstructionSiteQuery(get_called_class());
    }

    /**
     * Returns array with available and assigned employees.
     * @param integer $construction_site_id
     * @return array
     */
    public function getItems($construction_site_id)
    {
        return [
            'available' => $this->getAvailableEmployees(),
            'assigned' => $this->getAssignedEmployees($construction_site_id)
        ];
    }

    /**
     * Returns array with assigned employees.
     * @param integer $construction_site_id
     * @return array
     */
    private function getAssignedEmployees($construction_site_id)
    {
        return ArrayHelper::map(static::findAll(['construction_site_id' => $construction_site_id]), 'employee_id', function($cs){
            $employee = Employee::findOne($cs->employee_id);
            return $employee->first_name . " " . $employee->last_name;
        });
    }

    /**
     * Returns array with available employees.
     * @param integer $construction_site_id
     * @return array
     */
    private function getAvailableEmployees()
    {
        $assigned = EmployeeConstructionSite::find()->select(['employee_id'])->column();
        $employees = Employee::find()->andFilterWhere(['NOT IN', 'id', $assigned])->all();
        $filtered_employees = Employee::filterByRoles($employees, ['employee']);

        return ArrayHelper::map($filtered_employees, 'id', function($employee){
            return $employee->first_name . " " . $employee->last_name;
        });
    }

    /**
     * Assigns employee to construction site, granting access to it.
     * @param integer $construction_site_id
     * @param array of employee ids
     */
    public static function assign($construction_site_id, $items)
    {
        foreach($items as $item)
        {
            $ecs = new EmployeeConstructionSite();
            $ecs->construction_site_id = $construction_site_id;
            $ecs->employee_id = $item;
            $ecs->save();
        }
    }
}
