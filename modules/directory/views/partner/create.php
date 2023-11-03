<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\Partner */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Партнеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
