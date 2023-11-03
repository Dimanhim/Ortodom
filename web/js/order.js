jQuery(function($){
    $('a.print').on('click', function() {
        var self = this;
        $('input.print:checked').each(function (i, v) {
            window.open('/order/print' + '?id=' + self.dataset.id + '&type=' + v.value);
        })
    });
});
