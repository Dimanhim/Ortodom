<section class="breadcrumbs">
    <div class="breadcrumbs__wrap">
        <div class="container">
            <ul class="breadcrumbs__list">
                <li class="breadcrumbs__item">
                    <a href="/" class="breadcrumbs__link">Главная</a>
                </li>
                <?php if($breadCrumbItems) : ?>
                    <?php foreach($breadCrumbItems as $item) : ?>
                        <?php if($item['last'] == 1) : ?>
                            <li class="breadcrumbs__item breadcrumbs__item--current">
                                <?= $item['name'] ?>
                            </li>
                        <?php else : ?>
                            <li class="breadcrumbs__item">
                                <a href="<?= $item['url'] ?>" class="breadcrumbs__link">
                                    <?= $item['name'] ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <?php if($showH1) : ?>
    <div class="container">
        <h1 class="title title--main"><?= $page->h1 ?></h1>
    </div>
    <?php endif; ?>

</section>
