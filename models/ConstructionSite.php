<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "construction_site".
 *
 * @property int $id
 * @property string $name
 * @property string $location
 * @property int $quadrature
 * @property int|null $manager_id
 *
 * @property Employee $manager
 * @property EmployeeConstructionSite[] $employeeConstructionSites
 * @property WorkItem[] $workItems
 */
class ConstructionSite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'construction_site';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'location', 'quadrature'], 'required'],
            [['quadrature', 'manager_id'], 'integer'],
            [['name', 'location'], 'string', 'max' => 100],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nosaukums',
            'location' => 'Vieta',
            'quadrature' => 'Kvadratūra',
            'manager_id' => 'Menedžera ID',
        ];
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery|EmployeeQuery
     */
    public function getManager()
    {
        return $this->hasOne(Employee::className(), ['id' => 'manager_id'])->one();
    }

    /**
     * Gets query for [[EmployeeConstructionSites]].
     *
     * @return \yii\db\ActiveQuery|EmployeeConstructionSiteQuery
     */
    public function getEmployeeConstructionSites()
    {
        return $this->hasMany(EmployeeConstructionSite::className(), ['construction_site_id' => 'id']);
    }

    /**
     * Gets query for [[WorkItems]].
     *
     * @return \yii\db\ActiveQuery|WorkItemQuery
     */
    public function getWorkItems()
    {
        return $this->hasMany(WorkItem::className(), ['construction_site_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ConstructionSiteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConstructionSiteQuery(get_called_class());
    }

    /**
     * Gets array populated with available construction sites.
     * @return array
     */
    public static function getConstructionSitesArray()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
    }

    /**
     * Gets array populated with employees that have access to a construction site.
     * @param integer $id
     * @return array
     */
    public static function getAllowedEmployeeIds($id)
    {
        return EmployeeConstructionSite::find()->select(['employee_id'])
            ->where(['construction_site_id' => $id])
            ->column();
    }
}
