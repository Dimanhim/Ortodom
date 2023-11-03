$(document).ready(function() {
    /*$('body').on('click', '.header__logo', function(e) {
        e.preventDefault();
        $.get('front/product-content', {page_id: 59}, function(res) {
            $('.product-content').html(res);
        })
    });*/

    $('body').on('change', '.color-radio-list input[type="radio"]', function(e) {
        e.preventDefault();
        setCurrentColorTab();
    });

    function setCurrentColorTab() {
        let material_id = $('.color-radio-list input[type="radio"]:checked').val();
        $('.product-colors-container').css('display', 'none');
        $('.product-colors-container[data-material-id="' + material_id + '"]').css('display', 'flex');
    }
    setCurrentColorTab();
    new isvek.Bvi({
        target: '.bvi-btn',
        fontSize: 24,
        speech: false,
        //theme: 'black'
    });
})
