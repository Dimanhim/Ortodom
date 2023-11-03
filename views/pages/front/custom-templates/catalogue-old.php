<?php

use app\models\Page;
use himiklab\thumbnail\EasyThumbnailImage;

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

<?php if($pages = Page::find()->where(['type' => Page::TYPE_PRODUCT])->andWhere(['not', ['parent_id' => 2]])->all()) : ?>
<section class="section section--pb-100">
    <div class="container">
        <div class="grid-card">
            <?php foreach($pages as $page) : ?>
            <?php
                $product = $page->dataSource;
                $brand = $product->brand;
            ?>
            <div class="grid-card__item card">
                <a class="card__img" href="#">
                    <!--<img src="<?//= $product->imagePath ?>" alt="<?//= $product->name ?>">-->
                    <?= $product->img ?>
                </a>
                <a class="card__name" href="#"><?= $product->name ?></a>
                <ul class="card__list">
                    <li class="card__list-item">Материал верха: <?= ($brand && $brand->material) ? $brand->material->name : '' ?></li>
                    <li class="card__list-item">Подкладка: <?= ($brand && $brand->lining) ? $brand->lining->name : '' ?></li>
                    <li class="card__list-item">Подошва: <?= ($brand && $brand->sole) ? $brand->sole->name : '' ?></li>
                </ul>
            </div>
            <?php endforeach; ?>
            <!--
            <div class="grid-card__item card">
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
            <div class="grid-card__item card">
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

            <div class="grid-card__item card">
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
            <div class="grid-card__item card">
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
            <div class="grid-card__item card">
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

            <div class="grid-card__item card">
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
            <div class="grid-card__item card">
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
            <div class="grid-card__item card">
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
            -->
        </div>
    </div>
</section>
<?php endif; ?>
