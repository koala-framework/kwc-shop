var onReady = require('kwf/commonjs/on-ready');
var $ = require('jQuery');

onReady.onRender('.kwcClass', function(el) {
    var form = el.find('form');
    el.find('.submit').click(function(e) {
        e.preventDefault();
        el.find('.kwcBem__process').show();
        form.hide();
        var config = el.data('options');
        $.post(config.confirmOrderUrl, config.params)
            .done(function (response) {
                if (response.success) {
                    var postData = {};
                    var formData = new FormData(form[0]);
                    formData.forEach(function(value, key) {
                        postData[key] = value;
                    });
                    $.post(config.initiatePaymentUrl, postData)
                        .always(function (response) {
                            if (response.success && response.redirectUrl) {
                                window.location = response.redirectUrl;
                            } else if (!response.success && response.errorMessage) {
                                el.find('.kwcBem__error').text(response.errorMessage).show();
                            }
                        });
                }
           });
    });
});
