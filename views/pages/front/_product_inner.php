<section class="product section section--pb-100">
    <div class="container">
        <div class="product-content product__wrap section" x-data=" { currentTab: <?= $data->brand->getBeginColorId() ?> } ">
            <?= $this->render('_product_inner_ajax', [
                'data' => $data,
            ]) ?>
        </div>


        <div class="product__descr">
            <?php if($data->brand->description) : ?>
                <h2 class="product__descr-title">Описание</h2>
                <div class="product__descr-content cms-content">
                    <?= $data->brand->description ?>
                </div>
            <?php endif; ?>
            <a class="product__descr-back btn" href="/catalogue">
                <img class="product__descr-back-icon" src="/design/img/arrow-back.svg" alt="icon">
                Назад в каталог
            </a>
        </div>
    </div>

</section>
<?php
$countSimilarModels = 0;
?>
<?php if($data->brand && ($similarModels = $data->brand->similarModels())) : ?>
<section class="section section--pb-100">
    <div class="container">
        <div class="slider-head">
            <h2 class="slider-head__title title">Похожие модели</h2>
            <div class="slider-head__nav">
                <button class="slider-head__btn slider-head__prev js_similar-prev slider-btn" type="button">
                    <img src="/design/img/arrow-left-green.svg" alt="arrow">
                </button>
                <button class="slider-head__btn slider-head__next js_similar-next slider-btn" type="button">
                    <img src="/design/img/arrow-right-green.svg" alt="arrow">
                </button>
            </div>
        </div>

        <div class="js_similar-slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($similarModels as $similarProductBrands) : ?>
                    <?php if($similarProduct = $similarProductBrands->product) : ?>
                        <div class="swiper-slide">
                            <div class="card">
                                <a class="card__img" href="<?= $similarProduct->page->getFullUri() ?>"  target="_blank" data-id="<?= $similarProduct->id ?>">
                                    <?php if($similarProduct->img) : ?>
                                        <!--<img src="<?//= $similarProduct->image->path ?>" alt="catalog">-->
                                        <?= $similarProduct->img ?>
                                    <?php endif; ?>
                                </a>
                                <a class="card__name" href="<?= $similarProduct->page->getFullUri() ?>" target="_blank">
                                    <?= $similarProduct->name ?>
                                </a>
                                <ul class="card__list">
                                    <li class="card__list-item">Модель: М12345</li>
                                    <li class="card__list-item">Материал верха: кожа, замша</li>
                                    <li class="card__list-item">Подкладка: кожа / байка / мех</li>
                                    <li class="card__list-item">Подошва: ТЭП, ПУ, пористый материал</li>
                                </ul>
                            </div>
                        </div>
                    <?php $countSimilarModels++ ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?//= '('.$countSimilarModels.')' ?>
</section>
<?php endif; ?>
