<?php

use app\models\Page;

?>
<section class="accessories section section--pb-100">
    <div class="container">
        <div class="accessories__wrap">
            <?php if($pages = Page::findAll(['type' => Page::TYPE_ARTICLE, 'parent_id' => 4])) : ?>
                <?php foreach($pages as $page) : ?>
                <?php $data = $page->dataSource ?>
                    <div class="accessories__item">
                        <?php if($data && ($image = $data->image)) : ?>
                        <div class="accessories__item-img">
                            <img src="<?= $image->path ?>" alt="photo">
                        </div>
                        <?php endif; ?>
                        <div class="accessories__item-info">
                            <h2 class="accessories__item-title"><?= $page->name ?></h2>
                            <?= $data->anons_1 ?>
                            <a class="more-link" href="<?= $page->getFullUri() ?>">
                                <span class="more-link__text">подробнее</span>
                                <img class="more-link__icon" src="/design/img/arrow-more.svg" alt="arrow">
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="extra">
            <p class="extra__text">Подпишитесь на нашу рассылку, чтобы быть в курсе последних новостей нашей компании</p>
            <form class="extra__form">
                <input class="extra__form-input" type="email" name="mail" placeholder="Ваш E-mail">
                <button class="extra__form-btn btn" type="submit">Подписаться</button>
            </form>
        </div>
    </div>
</section>
