<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ConstructionSite]].
 *
 * @see ConstructionSite
 */
class ConstructionSiteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ConstructionSite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ConstructionSite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
