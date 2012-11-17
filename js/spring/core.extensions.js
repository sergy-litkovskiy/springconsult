
SPRING.Core.registerExtension('ajax', function(core){
    return {
        request : function(url, data, onSuccess, onError){
            core.$.ajax({
                type : 'POST',
                url : url,
                data : data,
                success : function(json) {
                    if (json.success === true) {
                        if (typeof onSuccess === "function") onSuccess(json.data, json.message);
                    } else {
                        if (typeof onError === "function") onError(json.message, json.data);
                    }
                },
                dataType : 'json'
            });
        }
    }
});


SPRING.Core.registerExtension('dom', function(core){
    return {
        bind : function (element, evt, fn) {
            if (element && evt) {
                if (typeof evt === 'function') {
                    fn = evt;
                    evt = 'click';
                }
                core.$(element).bind(evt, fn);
            } else {
                core.log(1, "Binding " + evt + " on " + element + " element : FAILED : unproper params");
            }
        },
        unbind : function (element, evt, fn) {
            if (element && evt) {
                if (typeof evt === 'function') {
                    fn = evt;
                    evt = 'click';
                }
                jQuery(element).unbind(evt, fn);
            } else {
                core.log(1, "Unbinding " + evt + " on " + element + " element : FAILED : unproper params");
            }
        }
    }
});



SPRING.Core.registerExtension('json', function(core){
    return {
        stringify : function(v) {
            return JSON.stringify(v);
        },
        parse : function(v) {
            return JSON.parse(v);
        }
    }
});



SPRING.Core.registerExtension('storage', function(core){
    return {
        set : function(key, value) {
            localStorage.setItem(key, core.json.stringify(value));
        },
        get : function(key) {
            return {
                "success" : true,
                "message" : "",
                "data"    : core.json.parse(localStorage.getItem(key))
            }
        },
        clear : function(key) {
            this.set(key, null);
        }
    }
}, ['json']);



SPRING.Core.registerExtension('template', function(core){
    return {
        toHtml : function(tmpl, data) {
            if (!tmpl) return "";
            return Mustache.to_html(tmpl, data);
        }
    }
});



SPRING.Core.registerExtension('UI', function(core){

    //default parameters
    var defaults = {
        overlayContainer: '#overlay_message_container',
        overlayContainerId: 'overlay_message_container',
        overlayOptions: {
            width: '400px',
            mask: '#222',
            top: 'center',
            modal: true,
            closeOnEsc: 'true',
            onClose: function() {}
        },
        title: '',
        message: '',
        footer: ''
    };


    var _getOverlayContainer = function(params, defaults, messageTemplate) {
        var options = {},
            $overlayContainer;

        //set parameters
        if ( typeof params === 'object') {
            options = $.extend(true, {}, defaults, params);
        } else if (typeof params === 'string') {
            options = $.extend({}, defaults);
            options.message = params;
        } else return false;

        $(options.overlayContainer).remove();

        $('<div>').attr('id',options.overlayContainerId).addClass('message_overlay').html(messageTemplate).appendTo('body').hide();
        $(options.overlayContainer).overlay(options.overlayOptions);
        $overlayContainer = $(options.overlayContainer);

        //set message title and body and show overlay
        $overlayContainer
            .find('.message_title').html(options.title).end()
            .find('.message_body').html(options.message).end()
            .find('.message_footer').html(options.footer).end()
            .css({width : options.width})
            .overlay().load();

        return $overlayContainer;
    };


    return {
        showOverlay : function(params){
          
            var messageTemplate = $(params.el).html(),
                el = 'overlay-box-container';

            params = $.extend(true, {
                overlayContainer : '#' + el,
                overlayContainerId : el,
                overlayOptions: {
                    top: '10%'
                }
            }, params);


            return _getOverlayContainer(params, defaults, messageTemplate);
        },
        showOverlayMessage : function(params) {
            var messageTemplate ='<div class="message_header"><h1 class="message_title"></h1><div class="close"></div></div><div class="message_body"></div><div class="message_footer"></div>';
            return _getOverlayContainer(params, defaults, messageTemplate);
        }
    };
});

SPRING.Core.registerExtension('BoBase', function(core){
    var _tryMakeParamsObj = function(fields){
        var propName,
            i,
            fieldsObj = {},
            fieldsType = core.getType(fields);

        switch(fieldsType) {
            case 'array':
                for (i in fields) {
                    propName = fields[i];
                    fieldsObj[propName] = null;
                }
                return fieldsObj;
                break;
            case 'object':
                return fields;
                break;
            default:
                throw new TypeError('Invalid BO fields type [' + fieldsType + '], expected type: Array, Object');
                break;
        }
    };


    var _makeBoConstructor = function(obj) {
        return function(params) {
            var instance = {},
                _params = params || {};
            for (var i in obj) {
                if (obj.hasOwnProperty(i)) {
                    instance[i] = obj[i];
                    if (_params.hasOwnProperty(i)) {
                        instance[i] = _params[i];
                    }
                }
            }
            return instance;
        }
    };


    return {
        extend: function(fields){
            var fieldsObj = _tryMakeParamsObj(fields),
                _obj      = core.extend(fieldsObj, {});
            return _makeBoConstructor(_obj);
        }
    };
});


SPRING.Core.registerExtension('type', function(core){
    return {
        isArr : function (arr) {
            return core.$.isArray(arr);
        }
      , isObj : function (obj) {
            return core.$.isPlainObject(obj);
        }
      , isNum : function(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }
    };
});
//console.dir(SPRING.Core);
