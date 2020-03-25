<?php
namespace app\models;

/**
 * Class Model
 * @package app\models
 */
class Model extends \yii\base\Model
{
    /**
     * @param array $data
     * @param string $formName
     * @return bool
     */
    public function load($data, $formName = '')
    {
        return parent::load($data, $formName);
    }
}
