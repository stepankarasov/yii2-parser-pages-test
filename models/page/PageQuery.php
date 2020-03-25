<?php

namespace app\models\page;

use MongoDB\BSON\ObjectId;
use yii\mongodb\ActiveQuery;

/**
 * Class PageQuery
 */
class PageQuery extends ActiveQuery
{
    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere([Page::ATTR_ID => new ObjectId($id)]);
    }
}