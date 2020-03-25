<?php

namespace app\behaviors;

use app\models\ActiveRecord;
use MongoDB\BSON\ObjectId;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;

/**
 * Class MongoObjectIdBehavior
 * @package app\behaviors
 */
class MongoObjectIdBehavior extends Behavior
{
    public $attribute;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeInsert',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert'
        ];
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->attribute)) {
            throw new InvalidConfigException('Either "attribute" property must be specified.');
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeInsert()
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        foreach ((array)$this->attribute as $attribute) {
            $attributeValue = $owner->getAttribute($attribute);
            if ($attributeValue) {
                if (is_array($attributeValue)) {
                    foreach ($attributeValue as $key => $value) {
                        $attributeValue[$key] = new ObjectId($value);
                    }
                    $owner->setAttribute($attribute, $attributeValue);
                } else {
                    $owner->setAttribute($attribute, new ObjectId($owner->getAttribute($attribute)));
                }
            }
        }
    }
}