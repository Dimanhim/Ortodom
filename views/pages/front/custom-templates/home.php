<?php

use app\models\Service;
use app\modules\directory\models\QuestionsAnswer;
use yii\helpers\Url;
use app\models\Slider;

$sliders = Slider::find()->all();

?>
<?php if($sliders) : ?>
<section class="banners">
    <div class="banners__slider swiper">
        <div class="swiper-wrapper">
            <?php foreach($sliders as $slider) : ?>
                <?php //if($slider->backgroundImage && $slider->mainImage && $slider->imageInfo) : ?>
                    <div class="swiper-slide">
                        <div class="banners__item">
                            <?php if($slider->backgroundImage) : ?>
                            <img class="banners__bg-circles" src="<?= $slider->backgroundImage->path ?>" alt="bg">
                            <?php endif; ?>
                            <?php if($slider->mainImage) : ?>
                            <img class="banners__bg" src="<?= $slider->mainImage->path ?>" alt="bg">
                            <?php endif; ?>
                            <div class="container">
                                <div class="banners__item-wrap">
                                    <h1 class="banners__title"><?= $slider->title ?><br>
                                        <span class="banners__title--ml"><?= $slider->name ?></span>
                                        <b><?= $slider->sub_name ?></b>
                                    </h1>
                                    <?php if($slider->imageInfo) : ?>
                                        <img class="banners__item-img" src="<?= $slider->imageInfo->path ?>" alt="info">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php //endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="banners__nav">
            <button class="banners__slider-btn banners__slider-prev slider-btn" type="button">
                <img src="/design/img/arrow-left.svg" alt="arrow">
            </button>
            <div class="banners__slider-pagination"></div>
            <button class="banners__slider-btn banners__slider-next slider-btn" type="button">
                <img src="/design/img/arrow-right.svg" alt="arrow">
            </button>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($pageNews = $page->news) : ?>
<section class="home-slider">
    <div class="container">
        <div class="slider-head">
            <h2 class="slider-head__title title">Новости и статьи</h2>
            <div class="slider-head__nav">
                <button class="slider-head__btn slider-head__prev js_news-prev slider-btn" type="button">
                    <img src="/design/img/arrow-left-green.svg" alt="arrow">
                </button>
                <button class="slider-head__btn slider-head__next js_news-next slider-btn" type="button">
                    <img src="/design/img/arrow-right-green.svg" alt="arrow">
                </button>
            </div>
        </div>

        <div class="home-slider__slider js_news-slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($pageNews as $singleNews) : ?>
                <?php $pageData = $singleNews->dataSource ?>
                <div class="swiper-slide">
                    <div class="home-slider__item card">
                        <p class="home-slider__date"><?= $pageData->user_date ? $pageData->user_date : date('d.m.Y', $pageData->created_at) ?></p>
                        <a class="card__name" href="<?= $singleNews->getFullUri() ?>"><?= $pageData->name ?></a>
                        <p class="card__text">
                        <?= $pageData->short_description ?>
                        </p>
                        <a class="card__more more-link" href="<?= $singleNews->getFullUri() ?>">
                            <span class="more-link__text">подробнее</span>
                            <img class="more-link__icon" src="/design/img/arrow-more.svg" alt="arrow">
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="home-slider__btn-wrap">
            <a class="btn" href="/articles">Все новости</a>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="how">
    <div class="container">
        <h2 class="how__title title">Как заказать ортопедическую обувь?</h2>
        <p class="how__subtitle">Рассмотрим самые распространенные варианты</p>
        <div class="how__wrap">
            <div class="how__item">
                <div class="how__item-icon">
                    <img src="/design/img/how-1.svg" alt="icon">
                </div>
                <div class="how__item-wrap">
                    <p class="how__item-text">По направлению отдела<br> социальной защиты
                        населения</p>
                    <a class="more-link" href="#">
                        <span class="more-link__text">подробнее</span>
                        <img class="more-link__icon" src="/design/img/arrow-more.svg" alt="arrow">
                    </a>
                </div>
            </div>
            <div class="how__item">
                <div class="how__item-icon">
                    <img src="/design/img/how-2.svg" alt="icon">
                </div>
                <div class="how__item-wrap">
                    <p class="how__item-text">За собственные средства<br>
                        с возможностью
                        дальнейшей компенсации</p>
                    <a class="more-link" href="#">
                        <span class="more-link__text">подробнее</span>
                        <img class="more-link__icon" src="/design/img/arrow-more.svg" alt="arrow">
                    </a>
                </div>
            </div>
            <div class="how__item">
                <div class="how__item-icon">
                    <img src="/design/img/how-3.svg" alt="icon">
                </div>
                <div class="how__item-wrap">
                    <p class="how__item-text">По направлению<br>
                        фонда социального страхования</p>
                    <a class="more-link" href="#">
                        <span class="more-link__text">подробнее</span>
                        <img class="more-link__icon" src="/design/img/arrow-more.svg" alt="arrow">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if($services = Service::getModels()) : ?>
<section class="home-slider">
    <div class="container">
        <div class="slider-head">
            <h2 class="slider-head__title title">Наши услуги</h2>
            <div class="slider-head__nav">
                <button class="slider-head__btn slider-head__prev js_services-prev slider-btn" type="button">
                    <img src="/design/img/arrow-left-green.svg" alt="arrow">
                </button>
                <button class="slider-head__btn slider-head__next js_services-next slider-btn" type="button">
                    <img src="/design/img/arrow-right-green.svg" alt="arrow">
                </button>
            </div>
        </div>

        <div class="home-slider__slider js_services-slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($services as $service) : ?>
                <div class="swiper-slide">
                    <div class="home-slider__item card">
                        <?php if($service->image) : ?>
                        <?php //if(false) : ?>
                        <div class="card__img">
                            <img src="<?= $service->image->path ?>" alt="<?= $service->name ?>">
                        </div>
                        <?php endif; ?>
                        <a class="card__name" href="<?= $service->page ? $service->page->getFullUri() : '/' ?>">
                            <?= $service->name ?>
                        </a>
                        <p class="card__text">
                            <?= $service->short_description ?>
                        </p>
                        <a class="card__more more-link" href="<?= $service->page ? $service->page->getFullUri() : '/' ?>">
                            <span class="more-link__text">подробнее</span>
                            <img class="more-link__icon" src="/design/img/arrow-more.svg" alt="arrow">
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="home-slider__btn-wrap">
            <a class="btn" href="<?= ($service->page && $service->page->parent) ? $service->page->parent->getFullUri() : '/' ?>">Все услуги</a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($questions = QuestionsAnswer::find()->orderBy(['sortOrder' => SORT_ASC])->limit(5)->all()) : ?>
<section class="faq section">
    <div class="container">
        <h2 class="faq__title title">Вопросы и ответы</h2>
        <div class="faq__wrap">
            <?php foreach($questions as $question) : ?>
            <div class="faq__item">
                <button class="faq__question js_accordion-control" type="button" aria-expanded="false">
                    <p class="faq__question-text">
                        <?= $question->question ?>
                    </p>
                    <span class="faq__question-icon"></span>
                </button>
                <article class="faq__answer js_accordion-content" aria-hidden="true">
                    <p>
                        <?= $question->answer ?>
                    </p>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="home-slider__btn-wrap" style="margin-bottom: 20px;">
            <?php
            $pageQuestions = \app\models\Page::findOne(8)
            ?>
            <a class="btn" href="<?= $page ? $pageQuestions->getFullUri() : '/' ?>">Все ответы на частые вопросы</a>
        </div>
        <div class="faq__info">
            <p class="faq__info-title">Не нашли ответ на свой вопрос?</p>
            <p class="faq__info-text">
                позвоните нам по телефону <a href="tel:+78129344554">+7 812 934-45-54</a>
            </p>
        </div>

    </div>
</section>
<?php endif; ?>

<section class="home-contacts">
    <div class="container">
        <div class="home-contacts__wrap">
            <div class="home-contacts__content">
                <div class="home-contacts__item">
                    <img class="home-contacts__item-icon" src="/design/img/mark.svg" alt="icon">
                    <div class="home-contacts__item-wrap">
                        <p class="home-contacts__item-head">Приём на изготовление осуществляется в нашем салоне<br> по адресу:
                        </p>
                        <p class="home-contacts__item-info">Выборгское шоссе 5/1, станция метро «Озерки»</p>
                    </div>
                </div>
                <div class="home-contacts__item">
                    <img class="home-contacts__item-icon" src="/design/img/clock.svg" alt="icon">
                    <div class="home-contacts__item-wrap">
                        <p class="home-contacts__item-head">График работы:</p>
                        <p class="home-contacts__item-info">Понедельник - Суббота 10:00-20:00</p>
                        <p class="home-contacts__item-info">Выходной - Воскресенье</p>
                        <p class="home-contacts__item-info">Перерыв 14:00-15:00</p>
                    </div>
                </div>
                <div class="home-contacts__item">
                    <img class="home-contacts__item-icon" src="/design/img/tel.svg" alt="icon">
                    <div class="home-contacts__item-wrap">
                        <p class="home-contacts__item-head">Контактные телефоны:</p>
                        <p class="contacts-tel">
                            <a class="contacts-tel__link link" href="tel:+79219344554">+7 (921) 934-4554</a>
                        </p>
                        <p class="contacts-tel">
                            <a class="contacts-tel__link link" href="tel:88002227002">8 (800) 222-7002</a>
                            звонок по России бесплатный!
                        </p>
                    </div>
                </div>
            </div>
            <div class="home-contacts__map map js-map-wrapper">
                <!--<div class="loading-spinner map__spinner js-map-loading-spinner"></div>-->
            </div>
        </div>
    </div>
</section>
