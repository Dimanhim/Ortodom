<?php if($data->anons_1 || $data->anons_2) : ?>
<section class="page-info section">
    <div class="page-info__wrap">
        <div class="container">
            <div class="page-info__inner">
                <div class="page-info__text page-info__item">
                    <p>
                        <?= $data->anons_1 ?>
                    </p>
                </div>
                <div class="page-info__text page-info__item">
                    <p>
                        <?= $data->anons_2 ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="service section section--pb-100">
    <div class="container">

        <?= $data->content ?>

        <!--
        <div class="extra">
            <p class="extra__text">А хотите, наш специалист сам приедет к вам домой и проведет все необходимые замеры?</p>
            <a class="extra__btn btn" href="#">Вызвать специалиста</a>
        </div>
        -->
    </div>
</section>
