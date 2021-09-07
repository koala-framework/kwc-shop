var onReady = require('kwf/commonjs/on-ready');
var $ = require('jQuery');

onReady.onRender('.kwcClass', function(el) {
    var buyNowButton = el.find('.kwcBem__buyNowButton');
    buyNowButton.on('click', function(e) {
        el.find('.kwcBem__process').show();
        var config = el.data('options');
        $.post(config.confirmOrderUrl, config.params)
            .done(function (response) {
                if (!response.success) {
                    buyNowButton.hide();
                    el.find('.kwcBem__error').text(response.message);
                    return;
                }
                buyNowButton.append(response.formHtml);
                buyNowButton.find('form').submit();
           });
    });
});
