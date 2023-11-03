<?php

use yii\helpers\Url;
?>
<ul class="ul-list">
    <?php foreach($colors as $color) : ?>
        <?php if($colorModel = $model->getColor($color)) : ?>
            <li>
                <a href="<?= Url::to(['shoes-color/view', 'id' => $color]) ?>">
                    <?= $colorModel->name ?>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
