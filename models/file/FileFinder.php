<?php

namespace app\models\file;

/**
 * Trait FileFinder
 * @package app\models\file
 */
trait FileFinder
{
    /**
     * @return FileQuery
     */
    public static function query()
    {
        return static::find();
    }

    /**
     * @param $id
     * @return File
     */
    public static function findOneById($id)
    {
        /** @var File $model */
        $model = static::query()
            ->byId($id)
            ->one();

        return $model;
    }

    /**
     * @param $pageId
     * @return array|File|\yii\mongodb\ActiveRecord
     */
    public static function findAllForPage($pageId)
    {
        /** @var File $model */
        $model = static::query()
            ->byPageId($pageId)
            ->all();

        return $model;
    }
}