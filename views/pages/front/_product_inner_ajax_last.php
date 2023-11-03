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
                <span class="product__parameter-list-item-name">Материал верха:</span> выберите материал верха <?//= $data->brand->material ? $data->brand->material->name : '' ?>
            </li>
            <li class="product__parameter-list-item">
                <?php if($materialList) : ?>
                    <style>
                        .radio-item {
                            min-width: <?= 100 / count($materialList) ?>%;
                        }
                    </style>
                <div class="radio-list color-radio-list">
                    <?php $i = 0; foreach($materialList as $materialItem) : ?>
                    <div class="radio-item">
                        <input id="radio-item-<?= $materialItem->id ?>" name="radio-item" type="radio" value="<?= $materialItem->id ?>"<?php if($i == 0) echo ' checked' ?>>
                        <label for="radio-item-<?= $materialItem->id ?>">
                            <?= $materialItem->name ?>
                        </label>
                    </div>
                    <?php $i++; endforeach; ?>
                </div>
                <?php endif; ?>
            </li>
            <?php if($colorMaterialIds = $data->brand->color_ids) : ?>
                <li class="product__parameter-list-item">
                    <!--
                    <span class="product__parameter-list-item-name">Цвет:</span>
                    -->
                    <?php $c = 0; foreach($colorMaterialIds as $materialId => $colorIds) : ?>
                    <ul class="product__parameter-colors product-colors-container<?php //if($c == 0) echo ' active' ?>" data-material-id="<?= $materialId ?>">
                        <?php
                        $j = 0;
                        foreach($colorIds as $colorId) :
                            $color = $data->brand->getColor($colorId);
                            ?>

                            <li class="product__parameter-colors-item js_product-color<?php if($j == 0) echo ' active'  ?>" <?php if(false/*$j == 0 && $c == 0*/) { ?>x-data=" currentTab = <?= $colorId ?> " <?php } ?> :class="$el.dataset.index == currentTab && 'active'" style="background: <?= $color->color ?>" x-on:click="currentTab = $el.dataset.index" data-index="<?= $colorId ?>">

                            </li>
                        <?php $j++; endforeach; ?>
                    </ul>
                    <?php $c++; endforeach; ?>
                </li>
            <?php endif; ?>
        </ul>
    <?php else : ?>
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
    <?php endif; ?>
</div>
<style>

</style>
<script>

</script>
