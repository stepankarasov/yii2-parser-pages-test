<?php
namespace app\models;

/**
 * Class ActiveRecord
 * @package app\models
 *
 * @property string $id
 */
class ActiveRecord extends \yii\mongodb\ActiveRecord
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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('_id');
    }
}
