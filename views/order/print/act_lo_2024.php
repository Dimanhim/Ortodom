<?php

use app\models\PrintTypes;

?>
<?= $this->render('act_lo', ['defaultPrice' => PrintTypes::PRICE_LO_2024, 'model' => $model, 'new' => $new]) ?>

