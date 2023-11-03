<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Config */

$this->title = 'Редактировать конфигуратор: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Конфигуратор', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="config-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php

        echo $this->render('_form_new', [
            'model' => $model,
        ]);

        /*if(isset($_GET['new'])) {
            echo $this->render('_form_new', [
                'model' => $model,
            ]);
        }
        else {
            echo $this->render('_form', [
                'model' => $model,
            ]);
        }*/
    ?>

</div>
