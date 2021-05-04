<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "work_item".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $construction_site_id
 *
 * @property EmployeeWorkItem[] $employeeWorkItems
 * @property ConstructionSite $constructionSite
 */
class WorkItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'construction_site_id'], 'required'],
            [['description'], 'string'],
            [['construction_site_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['construction_site_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConstructionSite::className(), 'targetAttribute' => ['construction_site_id' => 'id']],
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
            'description' => 'Apraksts',
            'construction_site_id' => 'Būvobjekta ID',
        ];
    }

    /**
     * Gets query for [[EmployeeWorkItems]].
     *
     * @return \yii\db\ActiveQuery|EmployeeWorkItemQuery
     */
    public function getEmployeeWorkItems()
    {
        return $this->hasMany(EmployeeWorkItem::className(), ['work_item_id' => 'id']);
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
     * {@inheritdoc}
     * @return WorkItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WorkItemQuery(get_called_class());
    }
}
