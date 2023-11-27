<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;
use yii\helpers\Html;

/**
 * JournalSearch represents the model behind the search form about `app\models\Order`.
 */
class JournalSearch extends Order
{
    const TYPE_OUTFIT_CUT = 1;
    const TYPE_OUTFIT_PUFF = 2;
    const TYPE_OUTFIT_READY = 3;

    const TYPE_OUTFIT_FULL = 4;

    const TYPE_STATUS_READY = 5;
    const TYPE_STATUS_PUFF = 6;
    const TYPE_STATUS_CUT = 7;
    const TYPE_STATUS_PRODUCTION = 8;

    public $outfits = [
        self::TYPE_OUTFIT_CUT => [
            'button_name' => 'Наряд крой',
            'button_id' => 'outfit-cut',
            'view_template' => 'outfit/outfit-cut',
        ],
        self::TYPE_OUTFIT_PUFF => [
            'button_name' => 'Наряд затяжка',
            'button_id' => 'outfit-puff',
            'view_template' => 'outfit/outfit-puff',
        ],
        self::TYPE_OUTFIT_READY => [
            'button_name' => 'Наряд готов к отправке',
            'button_id' => 'outfit-ready',
            'view_template' => 'outfit/outfit-ready',
        ],
        self::TYPE_OUTFIT_FULL => [
            'button_name' => 'btn',
            'button_id' => 'outfit-full',
            'view_template' => 'outfit/outfit-full',
        ],

        self::TYPE_STATUS_READY => [
            'button_name' => 'btn',
            'button_id' => 'outfit-full',
            'view_template' => 'outfit/outfit-status-ready',
        ],
        self::TYPE_STATUS_PUFF => [
            'button_name' => 'btn',
            'button_id' => 'outfit-full',
            'view_template' => 'outfit/outfit-status-puff',
        ],
        self::TYPE_STATUS_CUT => [
            'button_name' => 'btn',
            'button_id' => 'outfit-full',
            'view_template' => 'outfit/outfit-status-cut',
        ],
        self::TYPE_STATUS_PRODUCTION => [
            'button_name' => 'btn',
            'button_id' => 'outfit-full',
            'view_template' => 'outfit/outfit-status-production',
        ],
    ];
    /**
     * @var string
     */
    public $acceptedStart;

    /**
     * @var string
     */
    public $acceptedEnd;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'patient_id', 'status_id', 'status_date', 'payment_id', 'diagnosis_id', 'shoes_id', 'appointment_left_id', 'appointment_right_id', 'brand_id', 'material_id', 'lining_id', 'color_id', 'sole_id', 'last_id', 'representative_name', 'referral', 'appointment_left_data', 'appointment_left', 'appointment_right', 'appointment_right_data', 'heel_left', 'heel_left_data', 'heel_right', 'heel_right_data', 'block', 'accepted', 'issued', 'model', 'color', 'size', 'scan', 'shoes_data', 'brand_data', 'material_data', 'lining_data', 'color_data', 'sole_data', 'last_data', 'highlightLine', 'prepaid', 'cost', 'acceptedStart', 'acceptedEnd'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        $labels['acceptedStart'] = 'Начало приема';
        $labels['acceptedEnd'] = 'Конец приема';

        return $labels;
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
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
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
            //'model' => $this->model,
        ]);

        $query->andFilterWhere(['like', 'referral', $this->referral])
            ->andFilterWhere(['like', 'representative_name', $this->representative_name])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'model', $this->brand_id])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'color_id', $this->color_id])
            ->andFilterWhere(['like', 'size', $this->size]);

        return $dataProvider;
    }

    public function searchModel($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $this->load($params);
        if($params['sort']) {
            $sortAttribute = str_replace('-', '', $params['sort']);
            if(preg_match("/-/", $params['sort'])) {
                $query->orderBy([$sortAttribute => SORT_DESC]);
            }
            else {
                $query->orderBy([$sortAttribute => SORT_ASC]);
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
            $query->andWhere(['in', 'id', $ids]);
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
            ->andFilterWhere(['like', 'model', $this->brand_id])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'size', $this->size]);

        return $query->all();
    }

    public function getHeaderId()
    {
        $sortName = '';
        $className = '';
        $str = '';
        if($request = Yii::$app->request->get('sort')) {
            if(($request == 'id') || ($request == '-id')) {
                if($request == 'id') {
                    $sortName = '-id';
                    $className = 'desc';
                } else {
                    $sortName = 'id';
                    $className = 'asc';
                }
            }
        } else {
            $sortName = '-id';
        }
        $str .= Html::a('№', Yii::$app->urlManager->createUrl(['journal/index', 'sort' => $sortName]), ['data-sort' => $sortName, 'class' => $className]);
        $str .= ' '.Html::a('<span class="glyphicon glyphicon-search" style="margin-left:20px"></span>', '#', ['class' => 'view-modal-select-id']);
        return $str;
    }
}
