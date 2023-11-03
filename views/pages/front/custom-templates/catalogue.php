<?php

use app\models\Page;
use himiklab\thumbnail\EasyThumbnailImage;
use app\modules\directory\models\AgeGroup;

$pages = Page::find()->where(['in', 'id', AgeGroup::ageGroupPageIds()])->all();


?>
<section class="catalog-info page-info section">
    <div class="page-info__wrap">
        <div class="container">
            <div class="page-info__inner">
                <div class="page-info__text page-info__item">
                    <?= $data->content ?>
                </div>
                <div class="catalog-info__contacts page-info__item">
                    <p class="catalog-info__contacts-text">По всем интересующим Вас вопросам можете звонить нам по телефонам:
                    </p>
                    <div class="catalog-info__links">
                        <p class="contacts-tel">
                            <a class="contacts-tel__link link" href="tel:+79219344554">+7 (921) 934-4554</a>
                        </p>
                        <p class="contacts-tel">
                            <a class="contacts-tel__link link" href="tel:88002227002">8 (800) 222-7002</a>
                            звонок по России бесплатный!
                        </p>
                    </div>
                    <a class="catalog-info__btn btn" href="#" target="_blank">Скачать полный каталог 2022</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="catalog-info page-info section">
    <div class="page-info__wrap">
        <div class="container">
            <?php if($pages) : ?>
                <?php foreach($pages as $page) : ?>
                    <div class="">
                        <h2><?= $page->name ?></h2>
                    </div>
                    <?php if($products = $page->getParentsAgePages(3)) : ?>
                        <div class="page-info__inner" style="margin: 0;">
                            <?= $this->render('//pages/front/_product_card', [
                                'products' => $products,
                            ]) ?>
                        </div>
                        <a class="btn" href="<?= $page->getFullUri() ?>" style="margin-bottom: 50px;">Посмотреть все</a>
                    <?php endif; ?>

                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>



