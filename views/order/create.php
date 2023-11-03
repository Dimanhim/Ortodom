<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = 'Новый заказ';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-create">

    <h1><?php echo Html::encode($this->title); ?></h1>

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
            echo $this->render('_form_create', [
                'model' => $model,
            ]);
        }*/
    ?>

</div>
