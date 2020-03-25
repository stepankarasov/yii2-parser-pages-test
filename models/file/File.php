<?php

namespace app\models\file;

use app\behaviors\MongoObjectIdBehavior;
use app\models\ActiveRecord;
use app\models\page\Page;
use mongosoft\mongodb\MongoDateBehavior;

/**
 * Class File
 * @package app\models\file
 *
 * @property $_id
 * @property $name
 * @property $file
 * @property $page_id
 * @property $created_at
 * @property $updated_at
 * @property $mime_type
 * @property $size
 */
class File extends ActiveRecord
{
    use FileFinder;
    use FileFormatter;

    const ATTR_ID         = 'id';
    const ATTR_MONGO_ID   = '_id';
    const ATTR_NAME       = 'name';
    const ATTR_PAGE_ID    = 'page_id';
    const ATTR_CREATED_AT = 'created_at';
    const ATTR_UPDATED_AT = 'updated_at';
    const ATTR_MIME_TYPE  = 'mime_type';
    const ATTR_SIZE       = 'size';

    const UPLOAD_FILE_DIR = '/uploads';

    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'file';
    }

    /**
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return [
            static::ATTR_ID => static::ATTR_MONGO_ID,
            static::ATTR_NAME,
            static::ATTR_PAGE_ID,
            static::ATTR_CREATED_AT,
            static::ATTR_UPDATED_AT,
            static::ATTR_MIME_TYPE,
            static::ATTR_SIZE,
        ];
    }

    /**
     * @return FileQuery
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            //
            [
                static::ATTR_PAGE_ID,
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Page::class,
                'targetAttribute' => [static::ATTR_PAGE_ID => Page::ATTR_MONGO_ID]
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'mongoObject'             => [
                'class'     => MongoObjectIdBehavior::class,
                'attribute' => [
                    'page_id'
                ]
            ],
            'timestampBehavior' => [
                'class'              => MongoDateBehavior::class,
                'createdAtAttribute' => static::ATTR_CREATED_AT,
                'updatedAtAttribute' => static::ATTR_UPDATED_AT,
            ]
        ]);
    }

    /**
     * @return array
     */
    public function fields()
    {
        return [
            static::ATTR_ID => static::ATTR_MONGO_ID,
            static::ATTR_NAME,
        ];
    }

}