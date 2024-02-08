<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use app\models\Patient;
use app\components\Helpers;
use app\widgets\MenuWidget\MenuWidget;
use app\widgets\BreadCrumbs\BreadCrumbs;

AppAsset::register($this);

$page = $this->context->actionParams['page'];
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Html::encode($this->title); ?></title>

    <?php echo Html::csrfMetaTags(); ?>
    <meta name="description" content="Place the meta description text here.">
    <meta name="robots" content="index, follow">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/design/css/style.min.css">
    <link rel="stylesheet" href="/bvi/css/bvi.min.css">
    <link rel="stylesheet" href="/design/css/main.css?v=<?= mt_rand(1000,10000) ?>">
    <meta name="yandex-verification" content="b1c2672fc5e26b0b" />
</head>
<body>
<?php $this->beginBody(); ?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
    ym(96379265, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/96379265" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<header id="mainHeader" class="header">
    <div class="container">
        <div class="header__main">
            <a class="header__logo" href="/">
                <img src="/design/img/logo.png" alt="logo">
            </a>
            <div class="header__content">
                <a class="header__view link bvi-btn" href="#">
                    <img class="header__view-icon" src="/design/img/eye.svg" alt="icon">
                    Версия для слабовидящих
                </a>
                <div class="header__wrap">
                    <a class="header__tel link" href="tel:+78129344554">
                        <img class="header__tel-icon" src="/design/img/tel.svg" alt="icon">
                        +7 812 934-45-54
                    </a>
                    <a class="header__mail link" href="mailto:ortodom-spb@mail.ru">
                        <img class="header__mail-icon" src="/design/img/mail.svg" alt="icon">
                        ortodom-spb@mail.ru
                    </a>
                    <a class="header__btn btn online-record-link" href="#">Записаться на приём</a>
                </div>
            </div>
        </div>
        <div class="header__menu js_header-menu">
            <nav class="header__nav">
                <?= MenuWidget::widget(['menu_id' => 1]) ?>
            </nav>

            <div class="header__content--mob">
                <a class="header__view btn-no-mobile" href="#">
                    <img class="header__view-icon" src="/design/img/eye.svg" alt="icon">
                    Версия для слабовидящих
                </a>
                <div class="header__wrap">
                    <a class="header__tel" href="tel:+78129344554">
                        <img class="header__tel-icon" src="/design/img/tel.svg" alt="icon">
                        +7 812 934-45-54
                    </a>
                    <a class="header__mail" href="mailto:ortodom-spb@mail.ru">
                        <img class="header__mail-icon" src="/design/img/mail.svg" alt="icon">
                        ortodom-spb@mail.ru
                    </a>
                    <a class="header__btn btn online-record-link" href="#">Записаться на приём</a>
                </div>
            </div>
        </div>

    </div>
</header>

<main>
    <?= $page ? BreadCrumbs::widget(['page' => $page, 'showH1' => $page->showH1BreadCrumb(), 'show' => ($page->template != 'home')]) : '' ?>

    <?= $content ?>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer__wrap">
            <div class="footer__col">
                <a class="footer__logo" href="/">
                    <img src="/design/img/logo-white.png" alt="logo">
                </a>
                <p class="footer__text">© <?= date('Y') ?>, ООО «ОртоДом»<br>
                    Все права защищены.</p>
            </div>

            <div class="footer__info">
                <div class="footer__info-item">
                    <div class="footer__info-item-icon">
                        <img src="/design/img/tel-white.svg" alt="icon">
                    </div>
                    <div class="footer__info-item-wrap">
                        <p>
                            <a class="footer__info-link" href="tel:+79219344554">+7 (921) 934-4554</a>
                        </p>
                        <p>
                            <a class="footer__info-link" href="tel:88002227002">8 (800) 222-7002</a>
                            звонок по России бесплатный!
                        </p>
                    </div>
                </div>
                <div class="footer__info-item">
                    <div class="footer__info-item-icon">
                        <img src="/design/img/clock-white.svg" alt="icon">
                    </div>
                    <div class="footer__info-item-wrap">
                        <p>ПН-СБ 10:00 - 20:00 (перерыв 14:00 - 15:00)<br>
                            ВС - выходной</p>
                    </div>
                </div>
                <div class="footer__info-item">
                    <div class="footer__info-item-icon">
                        <img src="/design/img/mark-white.svg" alt="icon">
                    </div>
                    <div class="footer__info-item-wrap">
                        <p>Выборгское шоссе 5/1, станция метро «Озерки»</p>
                    </div>
                </div>
            </div>
            <?php $navLink = 'yandexmaps://maps.yandex.ru/?ll=30.318687%2C60.040898&um=constructor%3A9ca247fb4bd8e14266eb326e7d2ea2f519b64a18d9eedfe5c1014c525131b9c6&z=17' ?>
            <?php $mapLink = 'https://yandex.ru/maps/2/saint-petersburg/?ll=30.318687%2C60.041248&mode=usermaps&source=constructorLink&um=constructor%3A9ca247fb4bd8e14266eb326e7d2ea2f519b64a18d9eedfe5c1014c525131b9c6&z=17' ?>
            <?php $navLink2 = 'yandexnavi://build_route_on_map?lat_to=60.04098&lon_to=30.31892' ?>
            <a class="footer__map yandex_nav" href="<?= $navLink2 ?>" data-map="<?= $mapLink ?>" target="_blank">
                <img class="footer__map-img" src="/design/img/map.png" alt="map">
                <span class="footer__map-text">Найти на карте</span>
            </a>
            <p class="footer__text footer__text--mob">© 2020, ООО «ОртоДом»<br>
                Все права защищены.</p>
        </div>
    </div>
</footer>
<div id="modal-record"></div>
<?= $this->render('_front_record') ?>

<script src="/design/js/main.min.js"></script>
<script src="/bvi/js/bvi.min.js"></script>
<script src="/design/js/vendor/alpine.min.js"></script>
<?php $this->endBody(); ?>
<script src="/js/front/common.js?v=<?= mt_rand(1000,10000) ?>"></script>
<script>
    <?php if(Yii::$app->request->get('show-record')) : ?>
        $('#visitModal').modal('show')
    <?php endif; ?>
</script>
</body>
</html>
<?php $this->endPage(); ?>
