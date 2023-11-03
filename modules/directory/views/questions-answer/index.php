<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\directory\models\QuestionsAnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вопросы-ответы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-answer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'question:ntext',
            'answer:ntext',
            'sortOrder',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
