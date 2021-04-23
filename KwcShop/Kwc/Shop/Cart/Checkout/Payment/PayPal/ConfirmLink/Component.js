var onReady = require('kwf/commonjs/on-ready');
var $ = require('jQuery');

onReady.onRender('.kwcClass', function(el) {
    var form = el.find('form');
    form.one('submit', function(e) {
        e.preventDefault();
        el.find('.kwcBem__process').show();
        form.hide();
        var config = el.data('options');
        $.post(config.controllerUrl, config.params)
            .done(function (response) {
                form.submit();
            });
    });
});

