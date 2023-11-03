<?php

use app\models\Page;

?>
<section class="section section--pb-100">
    <div class="container">
        <div class="grid-card">
            <?php
            if($pages = Page::findAll(['type' => Page::TYPE_ARTICLE])) :
                foreach($pages as $page) :
                    $data = $page->dataSource;
                    ?>
                    <div class="grid-card__item card card--services">
                        <a class="card__name" href="<?= $page->getFullUri() ?>"><?= $data->name ?></a>
                        <p class="card__text">
                            <?= $data->short_description ?>
                        </p>
                        <a class="card__more more-link" href="<?= $page->getFullUri() ?>">
                            <span class="more-link__text">подробнее</span>
                            <img class="more-link__icon" src="/design/img/arrow-more.svg" alt="arrow">
                        </a>
                    </div>
                <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
