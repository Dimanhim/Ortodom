jQuery(function($){
    $('a.print').on('click', function() {
        var json = '{"type": [';
        var self = this;
        $('input.print:checked').each(function (i, v) {
            json += v.value + ',';
        });
        json = json.substr(0, (json.length - 1));
        json += ']}';
        var ids = [];
        var ids_json;
        var id = self.dataset.id;
        if(id != 'all') {
            ids.push(id);
        }
        else if(id == 'all' && $('.order-checkbox input').length) {
            $('.order-checkbox input').each(function(index, element) {
                var el = $(element);
                if(el.is(':checked')) {
                    var order_id = el.closest('tr.row-item').attr('data-key');
                    ids.push(order_id);
                }
            })
        }
        if(ids.length) {
            ids_json = {"ids": ids};
        }

        if(ids.length)
        window.open('/order/print' + '?id=' + JSON.stringify(ids_json) + '&data=' + json);
    });
});

/*jQuery(function($){
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
});*/
//window.open('/order/print' + '?id=' + self.dataset.id + '&type=' + v.value);
