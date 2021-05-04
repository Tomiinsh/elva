<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EmployeeWorkItem]].
 *
 * @see EmployeeWorkItem
 */
class EmployeeWorkItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EmployeeWorkItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeWorkItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
