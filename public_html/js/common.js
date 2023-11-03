$('.btn-delete').on('click', function(e) {
    e.preventDefault();
    if(confirm('Вы уверены, что хотите удалить файл?')) {
        var self = $(this);
        var id = self.data('id');
        $.get('/order/delete-scan?id=' + id, function(res) {
            console.log(res);
            if(res) {
                $('.scan-file').fadeOut();
            }
        });
    }
});
//$('#visitModal').modal('show');
$(".select-time").inputmask({"mask": "99:99"});
$(".phone-mask").inputmask({"mask": "+7-999-999-99-99"});
if($("body").is(".date-picker")) {
    $(".date-picker").datepicker({
        todayHighlight: true,
        clearBtn: true,
    });
}
$('.date-time-widget').inputmask({"mask": "99.99.9999"});

$('body').on('change', '.change-visit-week ', function(e) {
    e.preventDefault();
    console.log('date change')
    let form = $(this).closest('form').submit();
});

$('body').on('change', '#order-issued', function(e) {
    e.preventDefault();
    if($(this).val().length) {
        $('.sms-yandex-review').addClass('showed');
        $('.field-order-sms_yandex_review').addClass('has-error');
    }
});
/**
 * сортирует изображения
 * */
if($('.image-preview-container-o').length) {
    $('.image-preview-container-o').sortable({
        stop(ev, ui) {
            let sort = [];
            $('.image-preview-container-o .image-preview-o').each(function(index, element){
                sort.push($(element).attr('data-id'));
            });
            console.log('sort', sort)
            $.ajax({
                url: '/directory/shoes-brand/save-image-sort',
                method: 'post',
                data: {ids: JSON.stringify(sort)},
                success(response) {
                    if(response.result) {
                        console.log('success');
                    }
                },
                error(e) {
                    console.log('error', e)
                }
            });
        }
    });
}



$('body').on('click', '.td-avalible', function(e) {
    /*
    e.preventDefault();
    var time = $(this).data('time');
    var time_val = $(this).data('time-val');
    var date = $(this).data('date');
    var date_val = $(this).data('date-val');
    $('#time-value').html(time);
    $('#visit-visit_time').val(time_val);
    $('#date-value').html(date);
    $('#visit-visit_date').val(date_val);
    $('#visitModal').modal('show');
    getSelectTime();
*/
    e.preventDefault();
    var time = $(this).data('time');
    var date = $(this).data('date');
    var url, record;

    if($(this).hasClass('td-record-avalible')) {
        url = '/record/show-modal';
        record = true;
    }
    else {
        url = '/visit/show-modal';
        record = false;
    }
    $.get(url, {date: date, time: time}, function(res) {
        $('#show-modal-container').html(res);
        $('#show-modal').modal('show');
        $(".date-picker").datepicker({
            language: "ru-RU",
            changeMonth: true,
            changeYear: true,
            format: "dd.mm.yyyy",

        }).on('changeDate', function(e) {
            getSelectTime(false, record);
        });
        $(".phone-mask").inputmask({"mask": "+7-999-999-99-99"});
        $('#time-value').html(time);
        $('#date-value').html(date);
        $('#visit-visit_date').val(date);
        $('.chosen').chosen();
        getSelectTime(time, record);
    });
});
$('body').on('click', '.td-disabled', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var time = $(this).data('time');
    $.get('/visit/show-modal?id=' + id, function(res) {
        $('#show-modal-container').html(res);
        $('#show-modal').modal('show');
        $(".date-picker").datepicker({
            language: "ru-RU",
            changeMonth: true,
            changeYear: true,
            format: "dd.mm.yyyy",
        }).on('changeDate', function(e) {
            getSelectTime();
        });
        getSelectTime(time);

        $('#visit-name').removeAttr('readonly');
        $('#visit-phone').removeAttr('readonly');
        $('#visit-address').removeAttr('readonly');
        $('#visit-birthday').removeAttr('readonly');
        $('#visit-passport_data').removeAttr('readonly');
    });
});
/*$('body').on('submit', '#form-visit-modal', function(e) {
    e.preventDefault();
    var form = $(this);
    var data = form.serialize();
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: data,
        success: function (res) {
            $('p.error').html(res).fadeIn();
            return false;
        },
        error: function () {
            alert('Error!');
        }
    });
});*/
$('body').on('change', '#visit-patient_id', function(e) {
    e.preventDefault();
    var id = $(this).val();
    $.get('/visit/change-patient', {id: id}, function(json) {
        var data = JSON.parse(json);
        console.log(data);
        $('#visit-name').val(data.name);
        $('#visit-phone').val(data.phone);
        $('#visit-address').val(data.address);
        $('#visit-birthday').val(data.birthday);
        $('#visit-passport_data').val(data.passport);
    });

});
$('body').on('click', '#visit-create-client', function(e) {
    e.preventDefault();
    $(this).remove();
    $('.field-visit-patient_id').remove();
    $('#visit-name').removeAttr('readonly').val('');
    $('#visit-phone').removeAttr('readonly').val('');
    $('#visit-address').removeAttr('readonly').val('');
    $('#visit-birthday').removeAttr('readonly').val('');
    $('#visit-passport_data').removeAttr('readonly').val('');
    $(".phone-mask").inputmask({"mask": "+7-999-999-99-99"});
    $(".select-time").inputmask({"mask": "99:99"});
    $(".date-picker").datepicker({
        language: "ru-RU",
        changeMonth: true,
        changeYear: true,
        format: "dd.mm.yyyy",
    });
});
function getSelectTime(time = false, record = false) {
    var date = $('#visit-visit_date').val();
    var url;
    if(record) {
        url = '/record/select-time';
    }
    else {
        url = '/visit/select-time';
    }
    $.get(url, {date: date, time: time}, function(res) {
        $('#visit-visit_time').html(res);
    });
}


//$(document).ready(function() {
    $(".buttonPrint").printPage({attr: "href", message : 'Подождите, идет подготовка к печати'});
//});
// строка статус в карточке заказа
$(document).ready(function() {
    var row = $('.status-row');
    var value = row.data('value');
    if((value == 1) || (value == 4) || (value == 5)) {
        row.parents('tr').remove();
    }

    let menuItemsTree = $('#menu-items-tree');
    if (menuItemsTree.length) {
        menuItemsTree.jstree({
            'core': {
                'data': {
                    'url': '/menu-api/get-tree-children',
                    'data': function (node) {
                        return {
                            menuId: menuItemsTree.data('menu_id'),
                        }
                    },
                },
                'dblclick_toggle': false,
                'check_callback': true,
            },
            'plugins': ['wholerow', 'dnd', 'actions'],
        }).on('move_node.jstree', function (e, data) {
            onMoveMenuItem();
            // console.log(data);
            console.log();
            // pagesTree.jstree(true).toggle_node(data.node);
        });

        menuItemsTree.jstree(true).add_action('all', {
            'id': 'action-remove',
            'class': 'glyphicon glyphicon-remove pull-right',
            'callback': function(node_id, node, action_id, action_el) {
                if (confirm('Вы уверены?')) {
                    removeMenuItem(node.id);
                }
            }
        });
        menuItemsTree.jstree(true).add_action('all', {
            'id': 'action-edit',
            'class': 'glyphicon glyphicon-pencil pull-right',
            'callback': function(node_id, node, action_id, action_el) {
                location.href = '/menu-items/update?id=' + node.id;
            }
        });
    }

    function removeMenuItem(id) {
        $.post(`/menu-api/remove-menu-item?id=${id}`, function(res) {
            menuItemsTree.jstree('refresh');
        });
    }

    /**
     *
     */
    function onMoveMenuItem() {
        let data = [];
        let items = menuItemsTree.jstree(true).get_json('#', {flat:true});
        for (let key in items) {
            let item = items[key];
            data.push({
                'id': item.id,
                'position': key,
                'parent_id': item.parent === '#' ? 0 : item.parent,
            });
        }
        console.log(data);
        $.post('/menu-api/move-items', {data: data}, function(res) {
            console.log(res);
        });
    }

    $(document).on('beforeSubmit', '#menu-item-form', function () {
        let form = $(this);
        $.post(form.attr('action'), form.serialize(), function(res) {
            menuItemsTree.jstree('refresh');
        });
        return false;
    });

    $('body').on('change', '#product-brand_id', function(e) {
        e.preventDefault();
        var name = $(this).find('option:selected').text();
        $.get('/order/get-group', {id: $(this).val()}, function(json) {
            $('#page-parent_id option').prop('selected', false).trigger("chosen:updated");
            $(".page-name").val(name);
            $('#page-h1').val(name);
            $('#page-title').val(name);
            $('#page-alias').val(slugify(name));
            if(json.result) {
                $('#page-parent_id option[value=' + json.parent_id + ']').prop('selected', true).trigger("chosen:updated");
            }
        });
    });

    if (!$('#page-alias').val()) {
        $(".page-name").keyup(function() {
            $('#page-alias').val(slugify($(this).val()));
        });
    }

    if (!$('#page-h1').val()) {
        $(".page-name").keyup(function() {
            $('#page-h1').val($(this).val());
        });
    }

    if (!$('#page-name').val()) {
        $(".page-name").keyup(function() {
            $('#page-name').val($(this).val());
        });
    }

    if (!$('#page-title').val()) {
        $(".page-name").keyup(function() {
            $('#page-title').val($(this).val());
        });
    }
});

// пакетно изменить статус
$('body').on('change', '#ordersearch-changestatusform, #journalsearch-changestatusform', function(e) {
    e.preventDefault();
    if(!confirm('Вы действительно хотите пакетно изменить статусы?')) return false;
    var url = window.location;
    var ids = [];
    var status = $(this).val();
    $('.row-item').each(function(index, element) {
        var checkbox = $(element).find('.order-checkbox input');
        if(checkbox.is(':checked')) {
            var id = $(element).find('.order-id').text();
            ids.push(Number(id));
        }
    });
    var json = `{"status": ${status}, "ids": [`;
    for(let i = 0; i < ids.length; i++) {
        json += ids[i] + ',';
    }
    json = json.substr(0, (json.length - 1));
    json += ']}';
    $.get('/order/change-status-packet', {json: json}, function(res) {
        if(res) {
            window.location = url;
        }
    });
});

// пакетно изменить цвет
$('body').on('change', '#journalsearch-changecolorform', function(e) {
    e.preventDefault();
    if(!confirm('Вы действительно хотите пакетно изменить цвета?')) return false;
    var url = window.location;
    var ids = [];
    var color = $(this).val();
    $('.row-item').each(function(index, element) {
        var checkbox = $(element).find('.order-checkbox input');
        if(checkbox.is(':checked')) {
            var id = $(element).find('.order-id').text();
            ids.push(Number(id));
        }
    });
    var json = `{"color": ${color}, "ids": [`;
    for(let i = 0; i < ids.length; i++) {
        json += ids[i] + ',';
    }
    json = json.substr(0, (json.length - 1));
    json += ']}';
    $.get('/order/change-color-packet', {json: json}, function(res) {
        if(res) {
            window.location = url;
        }
    });
});

// закрасить строку цветом
$('body').on('change', '#journalsearch-highlightline', function(e) {
    e.preventDefault();
    if(!confirm('Вы действительно хотите закрасить цветом строки?')) return false;
    var val = $(this).val();
    var color = $(this).find('option[value=' + val + ']').text();
    $('.row-item').each(function(index, element) {
       var el = $(element);
       var checkbox =  el.find('.order-checkbox input[type=checkbox]');
       if(checkbox.is(':checked')) {
           $(this).attr('style', '').attr('style', color);
       }
    });
});

// JOURNAL
$('body').on('change', '.outfit', function(e) {
    e.preventDefault();
    var btn = $('.outfit-btn');
    btn.fadeIn();
    var type = $(this).attr('data-type');
    btn.attr('data-type', type);
});
/*$('body').on('click', '#outfit-btn', function(e) {
    e.preventDefault();
    var ids = [];
    var type = $(this).attr('data-type');
    $('.row-item').each(function(index, element) {
        var checkbox = $(element).find('.order-checkbox input');
        if(checkbox.is(':checked')) {
            var id = $(element).find('.order-id').text();
            ids.push(Number(id));
        }
    });
    var json = `{"type": ${type}, "ids": [`;
    for(let i = 0; i < ids.length; i++) {
        json += ids[i] + ',';
    }
    json = json.substr(0, (json.length - 1));
    json += ']}';
    var url = `/order/print-outfit?json=${json}`;
    window.location = url;
});*/
$('body').on('click', '#outfit-btn', function(e) {
    e.preventDefault();
    var status_id = $('#journalsearch-status_id').val();
    if(!status_id) return false;
    var location = window.location.search;
    if(status_id == 2 || status_id == 9 || status_id == 7 || status_id == 10) {
        //var url = `/order/print-outfit?status_id=${status_id}&location=${location}`;
        var url = `/order/print-outfit${location}`;
        window.location = url;
    }
    return false;
});
// END JOURNAL

$('a.delete-image').click(function() {
    if(!confirm('Вы действительно хотите удалить изображение?')) return false;
    let item = $(this);
    $.get(item.attr('href'), function(data) {
        item.parents('div.photo-list-item').remove();
    });
    return false;
});

$('body').on('click', '.view-modal-select-id', function(e) {
    e.preventDefault();
    $('#order-modal').modal('show');
    $('#order-modal #ordersearch-id').focus();
});

$('body').on('click', '.online-record-link', function(e) {
    e.preventDefault();
    /*$.ajax({
        url: 'https://crm.ortodom-spb.ru/api/show-modal',
        type: 'GET',
        data: {},
        success: function (res) {
            if(res.result == 1 && res.html != null) {
                $('#modal-record').html(res.html)
                $('#visitModal').modal('show')
            }

            console.log(res)
        },
        error: function () {
            console.log('Error!');
        }
    });*/
    $('#visitModal').modal('show')
});

function checkAllCheckboxes(unset) {
    $('.row-item').each(function(index, element) {
        var el = $(element);
        var checkbox = $(element).find('.order-checkbox input');
        if(unset) {
            $('#checkbox-select-orders').prop('checked', false);
            checkbox.prop('checked', false);
        }
        else {
            $('#checkbox-select-orders').prop('checked', true);
            checkbox.prop('checked', true);
        }
    });
}
$('body').on('click', '#print-barcodes-to-order', function(e) {
    e.preventDefault();
    var count = $('#select-values-barcode').val();
    var id = $(this).data('id');
    window.open('/order/print-barcodes-to-order' + '?id=' + id + '&count=' + count);
});
$('body').on('change', '#checkbox-select-orders', function(e) {
    e.preventDefault();
    var self = $(this);
    if(self.is(':checked')) checkAllCheckboxes();
    else checkAllCheckboxes(true);
    return false;
});
$('body').on('click', '#print-barcodes', function(e) {
    e.preventDefault();
    var url = window.location;
    var ids = [];
    var status = $(this).val();
    $('.row-item').each(function(index, element) {
        var checkbox = $(element).find('.order-checkbox input');
        if(checkbox.is(':checked')) {
            var id = $(element).find('.order-id').text();
            ids.push(Number(id));
        }
    });
    var json = `{"ids": [`;
    for(let i = 0; i < ids.length; i++) {
        json += ids[i] + ',';
    }
    json = json.substr(0, (json.length - 1));
    json += ']}';
    window.open('/order/print-barcode' + '?data=' + json);
});

$('body').on('click', '#print-order-to-send', function(e) {
    e.preventDefault();
    var ids = [];
    $('.row-item').each(function(index, element) {
        var checkbox = $(element).find('.order-checkbox input');
        if(checkbox.is(':checked')) {
            var id = $(element).find('.order-id').text();
            ids.push(Number(id));
        }
    });
    var json = `{"ids": [`;
    for(let i = 0; i < ids.length; i++) {
        json += ids[i] + ',';
    }
    json = json.substr(0, (json.length - 1));
    json += ']}';
    window.open('/order/print-order-to-send' + '?data=' + json);
});

$(document).ready(function() {
    $("#form-order").on("keypress", function(e) {
        var text = $('#ordersearch-id').val();
        if (e.keyCode == 13) {
            $('#ordersearch-id').val(text + ',');
            return false;
        }
    });
    $('.chosen').chosen();
});

/*
$(document).ready(function() {
    var self = $('.search-status');
    var val = self.val();
    $.get('/order/change-status-color?id=' + val, function(res) {
        self.attr('style', res);
    });
});
*/
//$('#patientsearch-birthday').datepicker();

/*
*
* КОНФИГУРАТОР
*
*/
$('body').on('change', '#config-material_id', function(e) {
    e.preventDefault();
    $.get('/config/change-color', {material_id: $(this).val()}, function(data) {
        $('#config-color').html(data);
    });
});
$('body').on('change', '#order-material_id', function(e) {
    e.preventDefault();
    $.get('/config/change-color', {material_id: $(this).val()}, function(data) {
        $('#order-color_id').html(data);
    });
});
$('body').on('click', '.table-order-arrow a.arrow-select', function(e) {
    e.preventDefault();
    console.log('click');
    var tr = $(this).parents('tr');

    var left_select = tr.find('.table-order-left select');
    var right_select = tr.find('.table-order-right select');

    var left_val = left_select.val();
    var right_val = right_select.val();

    var left_text, right_text;
    if(left_val) {
        left_text = tr.find('.table-order-left select option[value=' + left_val + ']').text();
    }
    if(right_val) {
        right_text = tr.find('.table-order-right select option[value=' + right_val + ']').text();
    }

    if($(this).hasClass('arrow-right')) {
        right_select.find('option').each(function(index, element) {
            var el = $(element);
            if(el.text() == left_text) {
                var id = el.attr('value');
                right_select.val(id);
            }
        });
    }
    else {
        left_select.find('option').each(function(index, element) {
            var el = $(element);
            if(el.text() == right_text) {
                var id = el.attr('value');
                left_select.val(id);
            }
        });
    }
});
$('body').on('click', '.table-order-arrow a.arrow-input', function(e) {
    e.preventDefault();
    var td = $(this).parents('tr');
    var textarea_left = td.find('.table-order-left input');
    var textarea_right = td.find('.table-order-right input');
    if($(this).hasClass('arrow-right')) {
        textarea_right.val(textarea_left.val());
    }
    else if($(this).hasClass('arrow-left')) {
        textarea_left.val(textarea_right.val());
    }
});
/*$('body').on('change', '#config-shoes_id', function(e) {
    e.preventDefault();
    $.get('/config/get-models', {shoes_id: $(this).val()}, function(data) {
        $('#config-brand_id').html(data);
    });
});
$('body').on('change', '#order-shoes_id', function(e) {
    e.preventDefault();
    $.get('/config/get-models', {shoes_id: $(this).val()}, function(data) {
        $('#order-brand_id').html(data);
    });
});*/
$('body').on('change', '#shoesbrand-material_id', function(e) {
    e.preventDefault();
    let val = $(this).val();
    let id = $('#form-shoes-brand').attr('data-id');
    $.post('/directory/shoes-brand/colors-form', {id: id, material_ids: val}, function(res) {
        if(res.result && res.html) {
            $('#brand-colors').html(res.html);
        }
    });
});

$('body').on('click', '.add-visit-user', function(e) {
    e.preventDefault();
    let time = $(this).attr('data-time');
    $.ajax({
        url: '/visit/change-cell',
        type: 'POST',
        data: {time: time},
        success: function (res) {
            console.log(res)
            if(res.result == 1) {
                $('.visit-user-table').replaceWith(res.html)
            }
        },
        error: function () {
            console.log('Error!');
        }
    });
});

if($(window).width() > 991) {
    let yandex_nav = $('.yandex_nav');
    let map = yandex_nav.attr('data-map');
    yandex_nav.attr('href', map);
}






