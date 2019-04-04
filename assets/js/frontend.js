// auth form
window.jQuery(function ($) {
    var config = window.wc_checkout_flow_frontend_script_data;
    var $form = $('.wc-checkout-flow-auth-form');
    var _ = wc_checkout_flow_helpers($form);

    if (0 === $form.length) return;

    $('body').append('<div class="wc-checkout-flow-loader"><div class="wc-checkout-flow-spinner"></div></div>');

    var $loader = $('.wc-checkout-flow-loader');

    $form.on('submit', function (evt) {
        //$form = $(this);
        evt.preventDefault();

        if ($form.hasClass('loading')) {
            return;
        }

        var data = $form.serializeArray();
        var action = $form.find('#wc_checkout_flow_action').val();

        data.push({name: 'action', value: config.prefix + 'ajax_' + action});
        $form.addClass('loading');
        $loader.addClass('show');

        _.log('checking email');

        var req = _.do_request(
            'post',
            config.ajax_url,
            data
        );

        req.always(function (req) {
            $form.removeClass('loading');
            $loader.removeClass('show');
        });

        req.done(function (res) {
            if (res.success) {
                res.$form = $form;
                _handle_response(res, action);
            }
        });

        req.fail(function (req) {
            var res = req.responseJSON;

            if (res) {
                _.add_message(res.data.message, 'error');
            } else {
                _.add_message('Tivemos um erro no servidor. Por favor, tente novamente ou entre em contato conosco.', 'error');
            }
        });
    });

    $form.on('click', '.lost-password-link', function (evt) {
        evt.preventDefault();

        var $parent = $form.parent();
        var message = _.get_template('message_lost_password');
        var email = $form.find('.wc-checkout-flow-form-email input').val();

        $parent.empty();
        message = message.replace('{EMAIL}', '<strong>' + email + '</strong>');
        $parent.append(_.create_message(message, 'info'));

        _.do_request(
            'post',
            config.ajax_url,
            {
                email: $form.find('.wc-checkout-flow-form-email #email').val(),
                action: config.prefix + 'ajax_recover_password'
            }
        );
    });

    function _handle_response(res, action) {
        if ('check_email' == action) {
            var $form = res.$form;

            if (res.data.user_created) {
                if (config.skip_messages === 'yes') {
                    location.reload();
                } else {
                    // mostra uma mensagem notificando que o cliente foi cadastrado e redireciona após alguns segundos
                    var $parent = $form.parent();

                    $parent.empty();
                    $parent.append(_.create_message(res.data.message, 'success'));

                    _.log('reload in 5 seconds');
                    setTimeout(function () {
                        location.reload();
                    }, 5000);
                }
            } else {
                // mostra o campo de senha e o link para recuperar senha
                var password_input = _.get_template('password_input');
                var $username_field = $form.find('.wc-checkout-flow-form-email');

                $username_field.find('input').prop('readonly', true);
                $(password_input).insertAfter($username_field);

                $form.find('#wc_checkout_flow_action').val('login');
                _.add_message(res.data.message);
                _.log('email found');
            }
        } else if ('login' == action) {
            if (config.skip_messages === 'yes') {
                location.reload();
            } else {
                // mostra uma mensagem notificando que o cliente foi cadastrado e redireciona após alguns segundos
                var $form = res.$form;
                var $parent = $form.parent();

                $parent.empty();
                $parent.append(_.create_message(res.data.message, 'success'));

                _.log('reload in 5 seconds');
                setTimeout(function () {
                    location.reload();
                }, 5000);
            }
        }
    }
});

// reset password form
window.jQuery(function ($) {
    var config = window.wc_checkout_flow_frontend_script_data;
    var $form = $('.wc-checkout-flow-reset-password-form');
    var _ = wc_checkout_flow_helpers($form);

    if (0 === $form.length) return;

    var $loader = $('.wc-checkout-flow-loader');

    $form.on('submit', function (evt) {
        evt.preventDefault();

        if ($form.hasClass('loading')) {
            return;
        }

        var data = $form.serializeArray();
        data.push({name: 'action', value: config.prefix + 'ajax_reset_password'});

        $form.addClass('loading');
        $loader.addClass('show');

        var req = _.do_request(
            'post',
            config.ajax_url,
            data,
        );

        req.always(function () {
            $form.removeClass('loading');
            $loader.removeClass('show');
        });

        req.done(function (res) {
            if (config.skip_messages === 'yes') {
                location.reload();
            } else {
                var $parent = $form.parent();

                $parent.empty();
                $parent.append(_.create_message(res.data.message, 'success'));
                _.log('password changed');

                _.log('reload in 5 seconds');
                setTimeout(function () {
                    location.reload();
                }, 5000);
            }
        });

        req.fail(function (req) {
            var res = req.responseJSON;

            if (res) {
                _.add_message(res.data.message, 'error');
            } else {
                _.add_message('Tivemos um erro no servidor. Por favor, tente novamente ou entre em contato conosco.', 'error');
            }
        })
    });
});

// helpers
function wc_checkout_flow_helpers($form) {
    var helpers = {};
    var config = window.wc_checkout_flow_frontend_script_data;
    var $message_wrapper = $form.parent().find('.wc-checkout-flow-messages');

    helpers.log = function () {
        if (config.debug) console.log.apply(console, arguments)
    };

    helpers.create_message = function (message, type) {
        type = type || 'info'; // or success or error

        if ('success' == type) type = 'message';

        $el = jQuery('<div/>');

        $el.addClass('woocommerce-' + type);
        $el.html(message);

        return $el;
    };

    helpers.do_request = function (method, url, data, args) {
        args = args || {};

        args.data = data;
        args.type = method;
        args.url = url;

        var req = jQuery.ajax(args);

        helpers.log('requesting ' + url);
        helpers.log('request data', '=', data);

        if (config.debug) {
            req.always(function (req) {
                helpers.log('request response', '=', req);
            });
        }

        return req;
    };

    helpers.add_message = function (message, type, clear) {
        clear = clear || true;

        if (clear) $message_wrapper.empty();

        $message_wrapper.append(helpers.create_message(message, type));
    };

    helpers.get_template = function (name) {
        return jQuery('#template_wc_checkout_flow_' + name).html();
    };

    return helpers;
}
