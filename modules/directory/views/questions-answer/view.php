<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\QuestionsAnswer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Вопросы-ответы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questions-answer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'question:ntext',
            'answer:ntext',
            'sortOrder',
            'created_at:datetime',
        ],
    ]) ?>

</div>
