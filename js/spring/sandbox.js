var SPRING = SPRING || {};

SPRING.Sandbox = function(core, module_selector){
    var _container  = '#' + module_selector,
        _$container = core.$(_container),
        _config     = {
            KEYPOINT_CONFIRM_ORDER : 7,
            lang : 'ru'
        };


    var _self = {
        $ : function(query){
            return _$container.find(query);
        },
        
        $wrap : function(el) {
            return core.$(el);
        },
        
        $self: function(){
            return _$container;
        },

        bind : function (element, type, fn) {
            core.dom.bind(_container + ' ' + element, type, fn);
        },
        
        unbind : function (element, type, fn) {
            core.dom.unbind(_container + ' ' + element, type, fn);
        },

        publish : function (evt) {
            if (core.type.isObj(evt) && evt.type) {
                core.triggerEvent(evt);
            }
        },
        
        subscribe : function (evts) {
            if (core.type.isObj(evts)) {
                core.registerEvents(evts, module_selector);
            }
        },
        
        unsubscribe : function (evts) {
            if (core.type.isArr(evts)) {
                core.removeEvents(evts, module_selector);
            }
        },

        request : function(url, data, onSuccess, onError) {
            core.ajax.request(url, data, onSuccess, onError);
        },

        tmpl : function(el) {
            return core.$(el).html();
        },

        type: core.type,


        Config: {
            get: function(prop, def) {
                if (_config.hasOwnProperty(prop)) return _config[prop];
                return (def !== undefined) ? def : undefined;
            }
        },

        Login : {
            authorize : function(data, onSuccess, onError) {
                _self.request('/admin/login/ajax_login', data, onSuccess, onError);
            }
        },
        Subscribe : {
            subscribe : function(data, onSuccess, onError) {
                _self.request('/index/ajax_send_subscribe', data, onSuccess, onError);
            },
            landingSubscribe : function(data, onSuccess, onError) {
                _self.request('/landing_subscribe', data, onSuccess, onError);
            }
        },
        Payment : {
            registration : function(data, onSuccess, onError) {
                _self.request('/ajax_payment_registration', data, onSuccess, onError);
            }
        },
        Mailer : {
            sendSpecMailer : function(data, onSuccess, onError) {
                _self.request('/admin/index_admin/ajax_send_spec_mailer', data, onSuccess, onError);
            },
            sendSubscribersMail : function(data, onSuccess, onError) {
                _self.request('/admin/articles_admin/ajax_send_article_to_subscribers', data, onSuccess, onError);
            }
        },
        Landing : {
            getLandingResourceMp3 : function(data, onSuccess, onError) {
                _self.request('/ajax_get_landing_mp3', data, onSuccess, onError);
            }
        },
        Contacts : {
            sendContactMessage : function(data, onSuccess, onError) {
                _self.request('/contact_form/send', data, onSuccess, onError);
            }
        },
        Status : {
            statusChange : function(data, onSuccess, onError) {
                _self.request('/admin/index_admin/ajax_change_status', data, onSuccess, onError);
            },
            statusIsTopChange : function(data, onSuccess, onError) {
                _self.request('/admin/index_admin/ajax_change_is_top', data, onSuccess, onError);
            }
        },
        ItemMove : {
            drop : function(data, onSuccess, onError) {
                _self.request(data.email, data, onSuccess, onError);
            }
        },
        Menu : {
            addOrUpdate : function(data, onSuccess, onError) {
                _self.request('/admin/index_admin/ajax_menu_edit', data, onSuccess, onError);
            },
            deleteMenuItem : function(menuId, onSuccess, onError) {
                _self.request('/admin/index_admin/ajax_menu_delete_item', {id : menuId}, onSuccess, onError);
            },
            changeStatusMenuItem : function(data, onSuccess, onError) {
                _self.request('/admin/index_admin/ajax_menu_change_status_item', data, onSuccess, onError);
            },
            changePositionMenuItem : function(data, onSuccess, onError) {
                _self.request('/admin/index_admin/ajax_menu_change_position_item', data, onSuccess, onError);
            }
        },
        SaleProducts : {
            addOrUpdate : function(data, onSuccess, onError) {
                _self.request('/admin/sale_admin/ajax_sale_products_letters_edit', data, onSuccess, onError);
            }
        },
        JSON:{
            toSbJSON : function(value){
                return core.json.stringify(value);
            },
            parseSbJSON : function(value){
                return core.json.parse(value);
            }
        },
        UI : {
            showMessage : function(params) {
                return core.UI.showOverlayMessage(params);
            },
            showError : function(m) {
                return core.UI.showOverlayMessage({title : 'Ошибка', message : m});
            },
            showDialog: function(params) {
                var options = core.extend(params, {
                    YesButtonLabel : 'Да'
                  , NoButtonLabel  : 'Нет'
                  , yes          : function(){}
                  , no           : function(){}
                  , message : ''
                });
                var html = '\n\
                    <div class="dialog-buttons">\n\
                        <a class="dialog-yes-button dialog-button" >' + options.YesButtonLabel + '</a>\n\
                        <a class="dialog-no-button dialog-button" >' + options.NoButtonLabel + '</a>\n\
                    </div>';
                options.footer = html;

                options.onClose  = function(){
                    _self.$wrap('.dialog-yes-button').unbind('click.dialog-yes-button');
                    _self.$wrap('.dialog-no-button').unbind('click.dialog-no-button');
                };

                var $container = _self.UI.showMessage(options);

                _self.$wrap('.dialog-yes-button').bind('click.dialog-yes-button', function(e){
                    e.preventDefault();
                    if (typeof options.yes === 'function') {
                        options.yes();
                    }
                    $container.overlay().close()
                });
                _self.$wrap('.dialog-no-button').bind('click.dialog-no-button', function(e){
                    e.preventDefault();
                    if (typeof options.no === 'function') {
                        options.no();
                    }
                    $container.overlay().close();
                });

                return $container;
            },
            showOverlay : function(params) {
                var options = core.extend(params, {
                    el : ''
                });

                return core.UI.showOverlay(options);
            }
        }

    };

    return _self;
};