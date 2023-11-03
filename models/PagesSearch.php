<?php

namespace app\models;

use app\models\Page;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PagesSearch represents the model behind the search form of `common\models\Page`.
 */
class PagesSearch extends Page
{
    public $parent;
    public $_created_from;
    public $_created_to;
    public $_page_size;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'relation_id', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['alias', 'name', 'h1', 'title', 'meta_description', 'meta_keywords', 'type', 'parent', 'template', '_created_from', '_created_to', '_page_size'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Page::find();
        $query->joinWith(['parent']);

        if($this->type == Page::TYPE_PRODUCT) {
            $query->where(['in', 'pages.id', [Page::MAN_SHOES_ID, Page::WOMAN_SHOES_ID, Page::CHILD_SHOES_ID, Page::TEENAGER_SHOES_ID]]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sortOrder' => SORT_ASC
                ]
            ]
        ]);

        /*$dataProvider->sort->attributes['parent'] = [
            'asc' => ['parent.name' => SORT_ASC],
            'desc' => ['parent.name' => SORT_DESC],
        ];*/

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->_created_from and $this->_created_to) {
            $query->andWhere(['between', 'updated_at', strtotime($this->_created_from), strtotime($this->_created_to) + (60 * 60 * 24) - 1]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pages.id' => $this->id,
            'pages.parent_id' => $this->parent_id,
            'pages.relation_id' => $this->relation_id,
            'pages.is_active' => $this->is_active,
            'pages.created_at' => $this->created_at,
            'pages.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'pages.alias', $this->alias])
            ->andFilterWhere(['like', 'pages.name', $this->name])
            ->andFilterWhere(['like', 'pages.type', $this->type])
            ->andFilterWhere(['like', 'pages.h1', $this->h1])
            ->andFilterWhere(['like', 'pages.title', $this->title])
            ->andFilterWhere(['like', 'pages.meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'pages.meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'pages.template', $this->template])
            ->andFilterWhere(['like', 'parent.name', $this->parent]);

        return $dataProvider;
    }
}
