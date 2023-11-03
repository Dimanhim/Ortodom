<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @var string
     */
    public $acceptedStart;

    /**
     * @var string
     */
    public $acceptedEnd;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_id', 'status_id', 'diagnosis_id', 'shoes_id', 'checkbox'], 'integer'],
            [['id', 'representative_name', 'referral', 'accepted', 'issued', 'acceptedStart', 'acceptedEnd', 'patient_id', 'model', 'color', 'size', 'changeStatus'], 'safe'],
            [['prepaid', 'cost'], 'number'],
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

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        $labels['acceptedStart'] = 'Начало приема';
        $labels['acceptedEnd'] = 'Конец приема';

        return $labels;
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $returnDataProvider = true)
    {
        $query = Order::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        if($returnDataProvider) {
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                //'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);
        }


        $this->load($params);

        if($returnDataProvider) {
            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }
        }

        if (!empty($this->accepted)) {
            $accepted = date('Y-m-d', strtotime($this->accepted));
            $query->andFilterWhere([
                'accepted' => $accepted,
            ]);
        }

        if (!empty($this->issued)) {
            $issued = date('Y-m-d', strtotime($this->issued));
            $query->andFilterWhere([
                'issued' => $issued,
            ]);
        }

        if (!empty($this->acceptedStart)) {
            $startDate = date('Y-m-d', strtotime($this->acceptedStart));
            $query->andFilterCompare('accepted', $startDate, '>=');
        }

        if (!empty($this->acceptedEnd)) {
            $endDate = date('Y-m-d', strtotime($this->acceptedEnd));
            $query->andFilterCompare('accepted', $endDate, '<=');
        }
        if($this->id) {
            $ids = explode(',', $this->id);
            if(count($ids) == 1) {
                 \Yii::$app->controller->redirect(['order/view', 'id' => $ids[0]]);
            }
            elseif(isset($ids[1]) && !$ids[1]) {
                 \Yii::$app->controller->redirect(['order/view', 'id' => $ids[0]]);
            }
            else {
                $query->andFilterWhere(['in', 'id', explode(',', $this->id)]);
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
            'payment_id' => $this->payment_id,
            'status_id' => $this->status_id,
            'patient_id' => $this->patient_id,
            'diagnosis_id' => $this->diagnosis_id,
            'shoes_id' => $this->shoes_id,
            'prepaid' => $this->prepaid,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'referral', $this->referral])
            ->andFilterWhere(['like', 'representative_name', $this->representative_name])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'size', $this->size]);

        return $returnDataProvider ? $dataProvider : $query->all();
    }
}
