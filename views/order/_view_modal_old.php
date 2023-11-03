<div class="modal" id="order-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div id="select-orders-checkboxes">
                    <div style="padding: 10px 0; font-size:18px">
                        Выберите заказы
                    </div>
                    <?php if($orders) : ?>
                        <?php foreach($orders as $order) : ?>
                            <div>
                                <input id="checkbox-order-<?= $order->id ?>" data-id="<?= $order->id ?>" type="checkbox">
                                <label for="checkbox-order-<?= $order->id ?>"><?= $order->id ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-body">
                <button class="btn btn-success" id="btn-select-orders">Выбрать</button>
            </div>
        </div>
    </div>
</div>

