<?php

namespace app\models\page;

use app\models\file\File;

/**
 * Class PageRelations
 * @package app\models\page
 */
trait PageRelations
{
    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->hasMany(File::class, [File::ATTR_PAGE_ID => Page::ATTR_ID]);
    }
}