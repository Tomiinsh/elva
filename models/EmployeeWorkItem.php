<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee_work_item".
 *
 * @property int $employee_id
 * @property int $work_item_id
 *
 * @property Employee $employee
 * @property WorkItem $workItem
 */
class EmployeeWorkItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_work_item';
    }

    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return [
            'work_item_id',
            'employee_id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'work_item_id'], 'required'],
            [['employee_id', 'work_item_id'], 'integer'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['work_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => WorkItem::className(), 'targetAttribute' => ['work_item_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeConstructionSite::className(), 'targetAttribute' => ['employee_id' => 'employee_id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'employee_id' => 'Darbinieks',
            'work_item_id' => 'Darbs',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery|EmployeeQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * Gets query for [[WorkItem]].
     *
     * @return \yii\db\ActiveQuery|WorkItemQuery
     */
    public function getWorkItem()
    {
        return $this->hasOne(WorkItem::className(), ['id' => 'work_item_id']);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeWorkItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeWorkItemQuery(get_called_class());
    }

    /**
     * Returns array with available and assigned employees.
     * @param integer $construction_site_id
     * @param integer $work_item_id
     * @return array
     */
    public function getItems($work_item_id, $construction_site_id)
    {
        return [
            'available' => $this->getAvailableEmployees($construction_site_id, $work_item_id),
            'assigned' => $this->getAssignedEmployees($work_item_id)
        ];
    }

    /**
     * Returns array with assigned employees.
     * @param integer $work_item_id
     * @return array
     */
    private function getAssignedEmployees($work_item_id)
    {
        $employee_work_items = EmployeeWorkItem::findAll(['work_item_id' => $work_item_id]);

        if(isset($employee_work_items)) {
            $employee_list = [];
            foreach($employee_work_items as $item)
            {
                array_push($employee_list, $item->getEmployee()->one());
            }

            return Employee::fullNameMap($employee_list, 'id');
        }
        return [];
    }

    /**
     * Returns array with available employees.
     * @param integer $construction_site_id
     * @param integer $work_item_id
     * @return array
     */
    private function getAvailableEmployees($construction_site_id, $work_item_id)
    {
        $allowed_employees = ConstructionSite::getAllowedEmployeeIds($construction_site_id);

        if(sizeof($allowed_employees) > 0)
        {
            $assigned = static::find()->select(['employee_id'])->where(['work_item_id' => $work_item_id])->column();

            $employees = Employee::find()
                ->andFilterWhere(['NOT IN', 'id', $assigned])
                ->andFilterWhere(['IN', 'id', $allowed_employees])
                ->all();

            $filtered_employees = Employee::filterByRoles($employees, ['employee']);

            return Employee::fullNameMap($filtered_employees, 'id');
        }

        return [];
    }

    /**
     * Assigns work item to an Employee.
     * @param integer $work_item_id
     * @param array $items
     * @return array
     */
    public static function assign($work_item_id, $items)
    {
        foreach($items as $item)
        {
            $employee_work_item = new EmployeeWorkItem();

            //only employees manager or admin can add work items to an employee.
            if(Yii::$app->user->identity->employee_id === Employee::findOne($item)->manager_id || Yii::$app->user->can('admin'))
            {
                $employee_work_item->work_item_id = $work_item_id;
                $employee_work_item->employee_id = $item;
                $employee_work_item->save();
            }
        }
    }
}
