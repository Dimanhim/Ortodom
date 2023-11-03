<?php

use app\models\PrintTypes;

?>
<?= $this->render('act_lo', ['defaultPrice' => PrintTypes::PRICE_LO_2023, 'model' => $model, 'new' => $new]) ?>
