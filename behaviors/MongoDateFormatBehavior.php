<?php
namespace app\behaviors;

use app\models\ActiveRecord;
use MongoDB\BSON\UTCDateTime;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;

/**
 * Class MongoDateFormatBehavior
 * @package app\behaviors
 */
class MongoDateFormatBehavior extends Behavior
{
    public $attributes;

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeInsert',
            BaseActiveRecord::EVENT_AFTER_DELETE  => 'beforeInsert',
        ];
    }

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (empty($this->attributes)) {
            throw new InvalidConfigException('Either "attributes" property must be specified.');
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeInsert()
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        foreach ((array)$this->attributes as $attribute) {
            $value = $owner->getAttribute($attribute);
            if ($value) {
                $value = new UTCDateTime(round(strtotime($owner->getAttribute($attribute)) * 1000));
            } else {
                $value = null;
            }
            $owner->setAttribute($attribute, $value);
        }
    }
}