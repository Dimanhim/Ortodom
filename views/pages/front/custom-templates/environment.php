<section class="environment-info page-info section">
    <div class="page-info__wrap">
        <div class="container">
            <div class="page-info__inner">
                <?php if($data->anons_1 || $data->anons_2) : ?>
                    <div class="page-info__item">
                        <div class="environment-info__item">
                            <?= $data->anons_1 ?>
                        </div>
                        <div class="environment-info__item">
                            <?= $data->anons_2 ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?= $data->short_description ?>
            </div>
        </div>
    </div>
</section>

<?= $data->content ?>
