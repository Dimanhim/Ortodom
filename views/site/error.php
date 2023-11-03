<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Ошибка '.$exception->statusCode;
?>
<div class="site-error">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <div class="alert alert-danger">
        <?php echo nl2br(Html::encode($exception->getMessage())); ?>
    </div>

</div>
