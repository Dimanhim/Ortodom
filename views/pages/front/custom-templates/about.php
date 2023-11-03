<?php

use app\modules\directory\models\Partner;
use app\modules\directory\models\Review;

?>

<section class="about-main section section--pb-100">
    <div class="container">
        <?= $data->content ?>
    </div>
</section>

<?php if($partners = Partner::find()->orderBy(['created_at' => SORT_DESC])->all()) : ?>
<section class="about-partners section section--pb-100">
    <div class="container">
        <h2 class="title">Наши партнёры</h2>
        <div class="about-partners__wrap">
            <?php foreach($partners as $partner) : ?>
            <div class="about-partners__item">
                <div class="about-partners__img">
                    <?php if($partner->image) : ?>
                    <img src="<?= $partner->image->path ?>" alt="<?= $partner->name ?>">
                    <?php endif; ?>
                </div>
                <p class="about-partners__name">
                    <?= $partner->name ?>
                </p>
                <p class="about-partners__info">
                    <?= $partner->description ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if($reviews = Review::find()->orderBy(['created_at' => SORT_DESC])->all()) : ?>
<section class="about-reviews section section--pb-100">
    <div class="container">
        <div class="slider-head">
            <h2 class="slider-head__title title">Отзывы наших клиентов</h2>
            <div class="slider-head__nav">
                <button class="slider-head__btn slider-head__prev js_reviews-prev slider-btn" type="button">
                    <img src="/design/img/arrow-left-green.svg" alt="arrow">
                </button>
                <button class="slider-head__btn slider-head__next js_reviews-next slider-btn" type="button">
                    <img src="/design/img/arrow-right-green.svg" alt="arrow">
                </button>
            </div>
        </div>
        <div class="about-reviews__slider js_reviews-slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($reviews as $review) : ?>
                <div class="swiper-slide">
                    <div class="about-reviews__slide">
                        <div class="about-reviews__slide-message">
                            <p>
                                <?= $review->content ?>
                            </p>
                        </div>
                        <div class="about-reviews__slide-user">
                            <span class="about-reviews__slide-avatar"></span>
                            <p class="about-reviews__slide-name">
                                <?= $review->name ?>
                            </p>
                            <p class="about-reviews__slide-city">
                                <?= $review->city ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div style="margin: 20px auto; text-align: center;">
            <a class="btn" href="https://yandex.ru/maps/org/ortodom/204069446950/reviews/" target="_blank">Оставить отзыв</a>
        </div>
    </div>
</section>
<?php endif; ?>
