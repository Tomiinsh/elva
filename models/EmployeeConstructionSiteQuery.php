<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[EmployeeConstructionSite]].
 *
 * @see EmployeeConstructionSite
 */
class EmployeeConstructionSiteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return EmployeeConstructionSite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return EmployeeConstructionSite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
