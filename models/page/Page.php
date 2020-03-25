<?php

namespace app\models\page;

use app\behaviors\MongoDateFormatBehavior;
use app\models\file\File;
use app\models\ActiveRecord;
use mongosoft\mongodb\MongoDateBehavior;

/**
 * Class Page
 *
 * /**
 * This is the model class for table "page".
 *
 * @property int    $id
 * @property string $title
 * @property string $content
 * @property string $url
 * @property string $status
 * @property string $created_at
 * @property string $parsed_at
 *
 * @property File[] $files
 */
class Page extends ActiveRecord
{
    use PageRelations;
    use PageFinder;
    use PageFormatter;

    const ATTR_ID         = 'id';
    const ATTR_MONGO_ID   = '_id';
    const ATTR_TITLE      = 'title';
    const ATTR_CONTENT    = 'content';
    const ATTR_URL        = 'url';
    const ATTR_STATUS     = 'status';
    const ATTR_CREATED_AT = 'created_at';
    const ATTR_PARSED_AT  = 'parsed_at';
    const ATTR_FILES      = 'files';

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAIL    = 'fail';

    /**
     * @return PageQuery
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'page';
    }

    /**
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return [
            static::ATTR_MONGO_ID,
            static::ATTR_TITLE,
            static::ATTR_CONTENT,
            static::ATTR_URL,
            static::ATTR_STATUS,
            static::ATTR_CREATED_AT,
            static::ATTR_PARSED_AT,
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            static::ATTR_MONGO_ID   => 'ID',
            static::ATTR_TITLE      => 'Заголовок',
            static::ATTR_CONTENT    => 'Контент',
            static::ATTR_URL        => 'Ссылка',
            static::ATTR_FILES      => 'Картинки',
            static::ATTR_STATUS     => 'Статус',
            static::ATTR_CREATED_AT => 'Дата создания',
            'createdAtFormatAdmin'  => 'Дата создания',
            static::ATTR_PARSED_AT  => 'Дата парсинга',
            'parsedAtFormatAdmin'   => 'Дата парсинга',
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //
            [static::ATTR_TITLE, 'string'],
            [static::ATTR_TITLE, 'trim'],
            [[static::ATTR_TITLE], 'default', 'value' => 'В обработке'],
            //
            [static::ATTR_CONTENT, 'string'],
            [static::ATTR_CONTENT, 'trim'],
            //
            [static::ATTR_URL, 'string'],
            [static::ATTR_URL, 'trim'],
            //
            [
                [static::ATTR_STATUS],
                'in',
                'range' => [static::STATUS_PENDING, static::STATUS_SUCCESS, static::STATUS_FAIL]
            ],
            [[static::ATTR_STATUS], 'default', 'value' => static::STATUS_PENDING],
            //
            [[static::ATTR_CREATED_AT, static::ATTR_PARSED_AT], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            static::ATTR_ID         => static::ATTR_MONGO_ID,
            static::ATTR_TITLE,
            static::ATTR_CONTENT,
            static::ATTR_URL,
            static::ATTR_STATUS,
            static::ATTR_CREATED_AT => 'createdAtFormatAdmin',
            static::ATTR_PARSED_AT  => 'parsedAtFormatAdmin',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'mongoDateFormatBehavior' => [
                'class'      => MongoDateFormatBehavior::class,
                'attributes' => [
                    static::ATTR_CREATED_AT,
                    static::ATTR_PARSED_AT
                ]
            ],
            'timestampBehavior'       => [
                'class'              => MongoDateBehavior::class,
                'createdAtAttribute' => static::ATTR_PARSED_AT,
                'updatedAtAttribute' => static::ATTR_PARSED_AT,
            ],
        ];
    }
}