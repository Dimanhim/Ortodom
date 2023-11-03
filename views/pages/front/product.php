<?php

use app\models\Page;
use himiklab\thumbnail\EasyThumbnailImage;

?>
<section class="section section--pb-100">
    <div class="container">
        <div class="grid-card">
            <?php
            //if($pages = Page::findAll(['type' => Page::TYPE_PRODUCT, 'parent_id' => $page->id])) :
            if($products = $page->parentsAgePages) : ?>
                <?= $this->render('_product_card', [
                    'products' => $products,
                ]) ?>
            <?php endif;
            ?>
        </div>
    </div>
</section>
