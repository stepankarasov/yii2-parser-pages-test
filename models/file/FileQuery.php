<?php
namespace app\models\file;

use yii\mongodb\ActiveQuery;

/**
 * Class FileQuery
 * @package app\models\file
 */
class FileQuery extends ActiveQuery
{
    /**
     * @param $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere([File::ATTR_MONGO_ID => $id]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function byPageId($id)
    {
        return $this->andWhere([File::ATTR_PAGE_ID => $id]);
    }
}