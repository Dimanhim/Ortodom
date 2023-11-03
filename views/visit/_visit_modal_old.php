<?php
use app\components\Calendar;
?>
<div class="modal" id="show-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="form">
                    <div style="padding: 10px 0; font-size:18px">
                        Запись на прием <b><?= date('d.m.Y', $model->visit_date) ?> в <?= Calendar::getTimeAsString($model->visit_time) ?></b>
                    </div>
                    <table class="table table-bordered table-stripped">
                        <tr>
                            <td>
                                Имя:
                            </td>
                            <td>
                                <?= $model->name ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Номер телефона:
                            </td>
                            <td>
                                <?= $model->phone ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
