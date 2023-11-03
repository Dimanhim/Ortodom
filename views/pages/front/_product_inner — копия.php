<section class="product section section--pb-100">
    <div class="container">
        <div class="product__wrap section">
            <div class="product__gallery">
                <div class="swiper product__slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a class="product__slide js-glightbox-image" href="img/catalog-1.jpg">
                                <img class="product__slide-img" src="/design/img/catalog-1.jpg" alt="photo">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a class="product__slide js-glightbox-image" href="img/catalog-1.jpg">
                                <img class="product__slide-img" src="/design/img/catalog-2.jpg" alt="photo">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a class="product__slide js-glightbox-image" href="img/catalog-1.jpg">
                                <img class="product__slide-img" src="/design/img/catalog-3.jpg" alt="photo">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a class="product__slide js-glightbox-image" href="img/catalog-1.jpg">
                                <img class="product__slide-img" src="/design/img/catalog-1.jpg" alt="photo">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a class="product__slide js-glightbox-image" href="img/catalog-1.jpg">
                                <img class="product__slide-img" src="/design/img/catalog-2.jpg" alt="photo">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="swiper product__thumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="product__thumb">
                                <img src="/design/img/catalog-1.jpg" alt="photo">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="product__thumb">
                                <img src="/design/img/catalog-2.jpg" alt="photo">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="product__thumb">
                                <img src="/design/img/catalog-3.jpg" alt="photo">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="product__thumb">
                                <img src="/design/img/catalog-1.jpg" alt="photo">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="product__thumb">
                                <img src="/design/img/catalog-2.jpg" alt="photo">
                            </div>
                        </div>
                    </div>
                    <button class="product__slider-btn product__slider-prev" type="button">
                        <img src="/design/img/arrow-top.svg" alt="arrow">
                    </button>
                    <button class="product__slider-btn product__slider-next" type="button">
                        <img src="/design/img/arrow-bottom.svg" alt="arrow">
                    </button>
                </div>
            </div>
            <div class="product__parameter">
                <h1 class="product__title title"><?= $data->name ?></h1>
                <?php if($data->brand) : ?>
                    <ul class="product__parameter-list">
                        <li class="product__parameter-list-item">
                            <span class="product__parameter-list-item-name">Вид обуви:</span> <?= $data->brand->shoes ? $data->brand->shoes->name : '' ?>
                        </li>
                        <li class="product__parameter-list-item">
                            <span class="product__parameter-list-item-name">Возрастная группа:</span> <?= $data->brand->ageGroup ? $data->brand->ageGroup->name : '' ?>
                        </li>
                        <li class="product__parameter-list-item">
                            <span class="product__parameter-list-item-name">Материал верха:</span> <?= $data->brand->material ? $data->brand->material->name : '' ?>
                        </li>
                        <li class="product__parameter-list-item">
                            <span class="product__parameter-list-item-name">Материал подкладки:</span> <?= $data->brand->lining ? $data->brand->lining->name : '' ?>
                        </li>
                        <li class="product__parameter-list-item">
                            <span class="product__parameter-list-item-name">Материал подошвы:</span> <?= $data->brand->sole ? $data->brand->sole->name : '' ?>
                        </li>
                        <li class="product__parameter-list-item">
                            <span class="product__parameter-list-item-name">Цвет:</span>
                            <ul class="product__parameter-colors">
                                <li class="product__parameter-colors-item product__parameter-colors-item--white"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--black"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--brown"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--red"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--blue-dark"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--blue"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--blue-white"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--grey-dark"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--grey"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--yellow"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--white"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--black"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--brown"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--red"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--blue-dark"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--blue"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--blue-white"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--grey-dark"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--grey"></li>
                                <li class="product__parameter-colors-item product__parameter-colors-item--yellow"></li>
                            </ul>
                        </li>
                    </ul>
                <?php else : ?>
                <ul class="product__parameter-list">
                    <li class="product__parameter-list-item">
                        <span class="product__parameter-list-item-name">Вид обуви:</span> <?= $data->getRelationName('shoes') ?>
                    </li>
                    <li class="product__parameter-list-item">
                        <span class="product__parameter-list-item-name">Возрастная группа:</span> <?= $data->getAgeGroupName() ?>
                    </li>
                    <li class="product__parameter-list-item">
                        <span class="product__parameter-list-item-name">Материал верха:</span> <?= $data->getRelationName('modelMaterial') ?>
                    </li>
                    <li class="product__parameter-list-item">
                        <span class="product__parameter-list-item-name">Материал подкладки:</span> <?= $data->getRelationName('modelLining') ?>
                    </li>
                    <li class="product__parameter-list-item">
                        <span class="product__parameter-list-item-name">Материал подошвы:</span> <?= $data->getRelationName('modelSole') ?>
                    </li>
                    <li class="product__parameter-list-item">
                        <span class="product__parameter-list-item-name">Цвет:</span>
                        <ul class="product__parameter-colors">
                            <li class="product__parameter-colors-item product__parameter-colors-item--white"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--black"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--brown"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--red"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--blue-dark"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--blue"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--blue-white"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--grey-dark"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--grey"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--yellow"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--white"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--black"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--brown"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--red"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--blue-dark"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--blue"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--blue-white"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--grey-dark"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--grey"></li>
                            <li class="product__parameter-colors-item product__parameter-colors-item--yellow"></li>
                        </ul>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>

        <div class="product__descr">
            <h2 class="product__descr-title">Описание</h2>
            <div class="product__descr-content cms-content">
                <?= $data->content ?>
            </div>
            <a class="product__descr-back btn" href="/catalogue">
                <img class="product__descr-back-icon" src="/design/img/arrow-back.svg" alt="icon">
                Назад в каталог
            </a>
        </div>
    </div>

</section>

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
                <div class="swiper-slide">
                    <div class="card">
                        <a class="card__img" href="#">
                            <img src="/design/img/catalog-1.jpg" alt="catalog">
                        </a>
                        <a class="card__name" href="#">туфли демисезонные</a>
                        <ul class="card__list">
                            <li class="card__list-item">Модель: М12345</li>
                            <li class="card__list-item">Материал верха: кожа, замша</li>
                            <li class="card__list-item">Подкладка: кожа / байка / мех</li>
                            <li class="card__list-item">Подошва: ТЭП, ПУ, пористый материал</li>
                        </ul>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card">
                        <a class="card__img" href="#">
                            <img src="/design/img/catalog-2.jpg" alt="catalog">
                        </a>
                        <a class="card__name" href="#">кеды</a>
                        <ul class="card__list">
                            <li class="card__list-item">Модель: М12345</li>
                            <li class="card__list-item">Материал верха: кожа, замша</li>
                            <li class="card__list-item">Подкладка: кожа / байка / мех</li>
                            <li class="card__list-item">Подошва: ТЭП, ПУ, пористый материал</li>
                        </ul>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card">
                        <a class="card__img" href="#">
                            <img src="/design/img/catalog-3.jpg" alt="catalog">
                        </a>
                        <a class="card__name" href="#">Туфли летние</a>
                        <ul class="card__list">
                            <li class="card__list-item">Модель: М12345</li>
                            <li class="card__list-item">Материал верха: кожа, замша</li>
                            <li class="card__list-item">Подкладка: кожа / байка / мех</li>
                            <li class="card__list-item">Подошва: ТЭП, ПУ, пористый материал</li>
                        </ul>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card">
                        <a class="card__img" href="#">
                            <img src="/design/img/catalog-3.jpg" alt="catalog">
                        </a>
                        <a class="card__name" href="#">Туфли летние</a>
                        <ul class="card__list">
                            <li class="card__list-item">Модель: М12345</li>
                            <li class="card__list-item">Материал верха: кожа, замша</li>
                            <li class="card__list-item">Подкладка: кожа / байка / мех</li>
                            <li class="card__list-item">Подошва: ТЭП, ПУ, пористый материал</li>
                        </ul>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card">
                        <a class="card__img" href="#">
                            <img src="/design/img/catalog-3.jpg" alt="catalog">
                        </a>
                        <a class="card__name" href="#">Туфли летние</a>
                        <ul class="card__list">
                            <li class="card__list-item">Модель: М12345</li>
                            <li class="card__list-item">Материал верха: кожа, замша</li>
                            <li class="card__list-item">Подкладка: кожа / байка / мех</li>
                            <li class="card__list-item">Подошва: ТЭП, ПУ, пористый материал</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
