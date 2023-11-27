<?php

use app\models\Visit;

?>
<?php if(\Yii::$app->user->isGuest) : ?>
    <td
        class="<?= $cell_values['class'] ?>"
        data-id="<?= $cell_values['id'] ?>"
        data-time="<?= $time ?>"
        data-time-val="<?= $calendar->getSecondsInTime($value) ?>"
        data-date="<?= $date['date_format'] ?>"
        data-date-val="<?= $date['timestamp'] ?>"
    >
        <?= $cell_values['content'] ?>
    </td>
<?php else : ?>




    <td
        class="<?= $cell_values['class'] ?>"
        data-id="<?= $cell_values['id'] ?>"
        data-time="<?= $time ?>"
        data-time-val="<?= $calendar->getSecondsInTime($value) ?>"
        data-date="<?= $date['date_format'] ?>"
        data-date-val="<?= $date['timestamp'] ?>"
    >
        <div class="cell-content-container">
            <div class="cell-content-checkbox">
                <?php if($cell_values['status'] == Visit::STATUS_CELL_AVALIABLE): ?>
                <input type="checkbox" class="reserved-checkbox" name="reserved_checkbox" data-date="<?= $date['timestamp'] ?>" data-time="<?= $time ?>">
                <?php endif; ?>
            </div>
            <?= $cell_values['content'] ?>
        </div>
    </td>




<?php endif; ?>
