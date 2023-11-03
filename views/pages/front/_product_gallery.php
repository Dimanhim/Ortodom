<div class="gallery-color-item">
    <?php if($data->brand && $data->brand->full_color_ids) : ?>
        <?php
        foreach($data->brand->full_color_ids as $colorId) :
            $color = $data->brand->getColor($colorId);
            if($brandColorImages = $data->brand->getColorImages($colorId)) :
                ?>
                <div class="product__gallery-content" :class="$el.dataset.index == currentTab && 'active'" data-index="<?= $colorId ?>">
                    <div class="swiper product__slider">
                        <div class="swiper-wrapper">
                            <?php foreach($brandColorImages as $brandColorImage) : ?>
                                <div class="swiper-slide">
                                    <a class="product__slide js-glightbox-image" href="<?= $brandColorImage->path ?>" data-gallery="gallery<?= $colorId ?>">
                                        <img class="product__slide-img" src="<?= $brandColorImage->path ?>" alt="photo">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="swiper product__thumbs">
                        <div class="swiper-wrapper">
                            <?php foreach($brandColorImages as $brandColorImage) : ?>
                                <div class="swiper-slide">
                                    <div class="product__thumb">
                                        <img src="<?= $brandColorImage->path ?>" alt="photo">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="product__slider-btn product__slider-prev" type="button">
                            <img src="/design/img/arrow-top.svg" alt="arrow">
                        </button>
                        <button class="product__slider-btn product__slider-next" type="button">
                            <img src="/design/img/arrow-bottom.svg" alt="arrow">
                        </button>
                    </div>

                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>



