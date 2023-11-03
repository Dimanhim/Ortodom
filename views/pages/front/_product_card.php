<?php foreach($products as $product) : ?>
    <?php $productPage = $product->page; ?>
    <div class="grid-card__item card card--services">
        <p class="card__img">
            <a href="<?= $productPage->getFullUri() ?>">
                <?//= EasyThumbnailImage::thumbnailImg(Yii::getAlias('@webroot').$productData->image->path, 320, 210, EasyThumbnailImage::THUMBNAIL_OUTBOUND) ?>
                <?= $product->img ?>
            </a>
        </p>
        <a class="card__name" href="<?= $productPage->getFullUri() ?>"><?= $product->name ?></a>
        <p class="card__text">
            <?= $product->short_description ?>
        </p>
        <a class="card__more more-link" href="<?= $productPage->getFullUri() ?>">
            <span class="more-link__text">подробнее</span>
            <img class="more-link__icon" src="/design/img/arrow-more.svg" alt="arrow">
        </a>
    </div>
<?php endforeach; ?>
