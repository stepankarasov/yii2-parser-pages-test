<?php

namespace app\models\file;

/**
 * Trait FileFormatter
 * @package app\models\file
 */
trait FileFormatter
{
    public function getUrl()
    {
        return  File::UPLOAD_FILE_DIR . '/' . $this->name . ".{$this->mime_type}?width=660&height=400";
    }
}
