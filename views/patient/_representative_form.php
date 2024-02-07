<?php

use yii\helpers\Url;

?>
<div class="representative-form">
    <div class="representatives-list">
        <div class="representative-card">
            <table class="table table-striped">
                <tr>
                    <th>ФИО</th>
                    <th>Паспортные данные</th>
                    <th>Удалить</th>
                </tr>
                <?php if($representatives = $model->representatives) : ?>
                    <?php foreach($representatives as $representative) : ?>
                        <tr class="representative-edit-link btn-add-representative" data-id="<?= $model->id ?>" data-representative="<?= $representative->id ?>">
                            <td>
                                <?= $representative->name ?>
                            </td>
                            <td>
                                <?= $representative->passport_data ?>
                            </td>
                            <td>
                                <a href="#" class="representative-delete" data-id="<?= $representative->id ?>" data-confirm="Вы уверены, что хотите удалить представителя?">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                <tr>
                    <td colspan="3">Представителей не найдено</td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-xs btn-primary btn-add-representative" data-id="<?= $model->id ?>">
            Добавить
            <span class="glyphicon glyphicon-plus"></span>
        </button>
    </div>

    <div id="representative-edit-form"></div>

</div>
