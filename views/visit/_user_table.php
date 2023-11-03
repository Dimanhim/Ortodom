<table class="table table-bordered table-striped visit-user-table">
    <tr>
        <th>Пн</th>
        <th>Вт</th>
        <th>Ср</th>
        <th>Чт</th>
        <th>Пт</th>
        <th>Сб</th>
        <th>Вс</th>
    </tr>
    <?php if($tableValues) : ?>
        <?php foreach($tableValues as $tableValue) : ?>
            <tr>
                <?php foreach($tableValue as $tableRow) : ?>
                    <?php
                        $classTd = $tableRow['class'];
                    ?>
                    <td class="<?= $classTd ?>">
                        <?php if($tableRow['disabled']) : ?>
                            <?= $tableRow['date_format'] ?>
                        <?php else: ?>
                            <a href="#" class="enabled-cell add-visit-user" data-time="<?= $tableRow['timestamp'] ?>">
                                <?= $tableRow['date_format'] ?>
                            </a>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
