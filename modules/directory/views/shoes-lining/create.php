<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\directory\models\ShoesLining */

$this->title = 'Добавление подкладки обуви';
$this->params['breadcrumbs'][] = ['label' => 'Подкладки обуви', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shoes-lining-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
