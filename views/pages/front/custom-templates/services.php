<?php

use app\models\Page;

?>
<section class="section section--pb-100">
    <div class="container">
        <div class="grid-card">
            <?php
                if($services = Page::findAll(['type' => Page::TYPE_SERVICE])) :
                    foreach($services as $service) :
                        $serviceData = $service->dataSource;
             ?>
                    <div class="grid-card__item card card--services">
                        <a class="card__name" href="<?= $service->getFullUri() ?>"><?= $serviceData->name ?></a>
                        <p class="card__text">
                            <?= $serviceData->short_description ?>
                        </p>
                        <a class="card__more more-link" href="<?= $service->getFullUri() ?>">
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
