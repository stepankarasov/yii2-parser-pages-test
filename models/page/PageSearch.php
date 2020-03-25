<?php

namespace app\models\page;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PageSearch
 */
class PageSearch extends Page
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //
            [[static::ATTR_TITLE, static::ATTR_CONTENT, static::ATTR_URL, static::ATTR_STATUS], 'string'],
            //
            [[static::ATTR_CREATED_AT, static::ATTR_PARSED_AT], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return array|ActiveDataProvider
     * @throws \yii\base\ErrorException
     */
    public function search($params)
    {
        $query = Page::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => [Page::ATTR_MONGO_ID => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return [];
        }

        return $dataProvider;
    }

    public function searchAdmin($params)
    {
        $query = Page::find()->orderBy([Page::ATTR_PARSED_AT => SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => [Page::ATTR_MONGO_ID => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return [];
        }

        return $dataProvider;
    }
}
