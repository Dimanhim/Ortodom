<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\AgeGroup */

$this->title = 'Возрастная группа';
$this->params['breadcrumbs'][] = ['label' => 'Возрастная группа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="age-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
