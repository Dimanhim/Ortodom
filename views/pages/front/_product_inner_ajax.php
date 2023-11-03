<?php
$materialList = $data->brand->materialList;
?>
<div class="product__gallery">

    <?php
        if($data->brand && $materialList) {
            echo $this->render('_product_gallery', [
                'data' => $data,
            ]);
        }
    ?>
</div>
<div class="product__parameter">
    <h1 class="product__title title"><?= $data->name ?></h1>
    <?php if($data->brand) : ?>
        <ul class="product__parameter-list">
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Вид обуви:</span> <?= $data->brand->shoes ? $data->brand->shoes->name : '' ?>
            </li>
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Возрастная группа:</span> <?= $data->brand->ageGroup ? $data->brand->ageGroupNames : '' ?>
            </li>

            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Материал подкладки:</span> <?= $data->brand->lining ? $data->brand->liningNames : '' ?>
            </li>
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Материал подошвы:</span> <?= $data->brand->sole ? $data->brand->soleNames : '' ?>
            </li>


            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Материал верха: </span> выберите материал верха
                <div class="product__parameter-choice color-radio-list">
                    <?php $i = 0; foreach($materialList as $materialItem) : ?>
                        <label class="product__parameter-choice-item">
                            <input class="visually-hidden" type="radio" x-on:change="if(!currentTab) currentTab = <?= $data->brand->getBeginMaterialColorId($materialItem->id) ?>" name="product-material" <?php if($i == 0) echo ' checked' ?> value="<?= $materialItem->id ?>">
                            <span class="product__parameter-choice-item-el" ></span>
                            <p><?= $materialItem->name ?></p>
                        </label>
                    <?php $i++; endforeach; ?>
                </div>
            </li>
            <?php if($colorMaterialIds = $data->brand->color_ids) : ?>
                <li class="product__parameter-list-item">
                    <span class="product__parameter-list-item-name">Цвет:</span>
                    <?php $c = 0; foreach($colorMaterialIds as $materialId => $colorIds) : ?>
                    <ul class="product__parameter-colors product-colors-container" data-material-id="<?= $materialId ?>">
                        <?php
                        $j = 0;
                        foreach($colorIds as $colorId) :
                            $color = $data->brand->getColor($colorId);
                            ?>
                        <?php if($data->brand->getColorImages($colorId)) : ?>
                        <!--
                            <li class="product__parameter-colors-item product__parameter-colors-item--white js_product-color" style="background: <?= $color->color  ?>" :class="$el.dataset.index == currentTab && 'active'" x-on:click="currentTab = $el.dataset.index" data-index="<?= $colorId ?>">
                            </li>
                            -->
                            <li class="product__parameter-colors-item product__parameter-colors-item--white js_product-color" style="background: <?= $color->color  ?>" x-on:click="currentTab = $el.dataset.index" :class="$el.dataset.index == parseInt(currentTab) && 'active'"  data-index="<?= $colorId ?>">
                            </li>
                        <?php endif; ?>
                        <?php $j++; endforeach; ?>
                    </ul>
                    <?php $c++; endforeach; ?>
                </li>
            <?php endif; ?>
        </ul>
    <?php else : ?>
    <!--
        <ul class="product__parameter-list">
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Вид обуви:</span> -
            </li>
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Возрастная группа:</span> -
            </li>
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Материал верха:</span> -
            </li>
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Материал подкладки:</span> -
            </li>
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Материал подошвы:</span> -
            </li>
            <li class="product__parameter-list-item">
                <span class="product__parameter-list-item-name">Цвет:</span>
                <ul class="product__parameter-colors">
                    <li class="product__parameter-colors-item product__parameter-colors-item--white js_product-color" :class="$el.dataset.index == currentTab && 'active'" x-on:click="currentTab = $el.dataset.index" data-index="1">
                    </li>
                    <li class="product__parameter-colors-item product__parameter-colors-item--brown js_product-color" :class="$el.dataset.index == currentTab && 'active'" x-on:click="currentTab = $el.dataset.index" data-index="2">
                    </li>
                    <li class="product__parameter-colors-item product__parameter-colors-item--blue-dark js_product-color" :class="$el.dataset.index == currentTab && 'active'" x-on:click="currentTab = $el.dataset.index" data-index="3">
                    </li>
                    <li class="product__parameter-colors-item product__parameter-colors-item--blue-white js_product-color" :class="$el.dataset.index == currentTab && 'active'" x-on:click="currentTab = $el.dataset.index" data-index="4">
                    </li>
                </ul>
            </li>
        </ul>
    -->
    <?php endif; ?>
</div>
<style>

</style>
<script>

</script>
