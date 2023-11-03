<?php

use app\models\Page;
use app\models\Product;

$categoriesShoes = Page::find()->where(['type' => Page::TYPE_PRODUCT, 'parent_id' => Product::PRODUCT_CATALOG_ID])->all();
?>
<?php if($items = $menu->items) : ?>
<nav class="header__nav">
    <ul class="header__nav-list">
        <?php foreach($items as $item) : ?>
            <?php if($item->id == 1) : ?>
            <li class="header__nav-item header__nav-item-submenu js_nav-burger-parent">
                <button class="header__nav-burger js_nav-burger"><img src="/design/img/catalog-burger.svg" alt="icon"></button>
                <a class="header__nav-link link" href="<?= $item->page ? $item->page->getFullUri() : '#' ?>">
                    <?= $item->name ?>
                </a>
                <?php if($categoriesShoes) : ?>
                <ul class="header__nav-submenu">
                    <?php foreach($categoriesShoes as $categoriesShoe) : ?>
                    <li class="header__nav-submenu-item">
                        <a class="header__nav-submenu-link link" href="<?= $categoriesShoe->getFullUri() ?>">
                            <?= $categoriesShoe->name ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </li>
            <?php else : ?>
            <li class="header__nav-item">
                <a class="header__nav-link link" href="<?= $item->page ? $item->page->getFullUri() : '#' ?>">
                    <?= $item->name ?>
                </a>
            </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>
<?php endif; ?>
