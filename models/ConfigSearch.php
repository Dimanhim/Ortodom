<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Config;

/**
 * ConfigSearch represents the model behind the search form about `app\models\Config`.
 */
class ConfigSearch extends Config
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shoes_id', 'brand_id', 'material_id', 'lining_id', 'color', 'heel_left', 'heel_right', 'sole_id', 'last_id'], 'integer'],
            [['name', 'appointment_left', 'appointment_right'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Config::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'shoes_id' => $this->shoes_id,
            'brand_id' => $this->brand_id,
            'material_id' => $this->material_id,
            'lining_id' => $this->lining_id,
            'color' => $this->color,
            'heel_left' => $this->heel_left,
            'heel_right' => $this->heel_right,
            'sole_id' => $this->sole_id,
            'last_id' => $this->last_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'appointment_left', $this->appointment_left])
            ->andFilterWhere(['like', 'appointment_right', $this->appointment_right]);

        return $dataProvider;
    }
}
