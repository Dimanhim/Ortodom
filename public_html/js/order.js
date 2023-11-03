jQuery(function($){
    $('a.print').on('click', function() {
        var json = '{"type": [';
        var self = this;
        $('input.print:checked').each(function (i, v) {
            json += v.value + ',';
        });
        json = json.substr(0, (json.length - 1));
        json += ']}';
        window.open('/order/print' + '?id=' + self.dataset.id + '&data=' + json);
    });
});
//window.open('/order/print' + '?id=' + self.dataset.id + '&type=' + v.value);
