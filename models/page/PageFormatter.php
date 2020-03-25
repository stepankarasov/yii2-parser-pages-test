<?php

namespace app\models\page;

/**
 * Class PageFormatter
 * @package app\models\page
 */
trait PageFormatter
{
    /**
     * @return mixed
     */
    public function getCreatedAtFormatAdmin()
    {
        return $this->created_at ? $this->created_at->toDateTime()->format('d.m.Y H:i') : null;
    }

    /**
     * @return mixed
     */
    public function getParsedAtFormatAdmin()
    {
        return $this->parsed_at ? $this->parsed_at->toDateTime()->format('d.m.Y H:i') : null;
    }

}