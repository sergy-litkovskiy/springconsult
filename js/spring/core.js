;var SPRING = SPRING || {};

SPRING.Core = (function(app){
    var _moduleRegistry = {},
        _extensions     = [],
        _debug          = false;

    return {
        $ : jQuery,
        registerModule : function (moduleID, creator) {
            var temp;
            if (typeof moduleID === 'string' && typeof creator === 'function') {
                temp = creator(new app.Sandbox(this, moduleID));
                if (temp && temp.init && typeof temp.init === 'function' && temp.destroy && typeof temp.destroy === 'function') {
                    temp = null;
                    _moduleRegistry[moduleID] = {
                        create : creator,
                        instance : null
                    };
                } else {
                    this.log(1, "Module '" + moduleID + "' Registration : FAILED : instance has no init or destory functions");
                }
            } else {
                this.log(1, "Module '" + moduleID + "' Registration : FAILED : one or more arguments are of incorrect type");
            }
        },
        start : function (moduleID) {
            var mod = _moduleRegistry[moduleID];
            if (mod) {
                mod.instance = mod.create(new app.Sandbox(this, moduleID));
                mod.instance.init();
                this.log(1, "Module '" + moduleID + "' start : SUCCESS");
            }
        },
        startAll : function () {
            var self = this;
            this.$(function(){
                var moduleID;
                for (moduleID in _moduleRegistry) {
                    if (_moduleRegistry.hasOwnProperty(moduleID)) {
                        self.start(moduleID);
                    }
                }
                self.triggerEvent({
                    type : 'app-start',
                    data : null
                });
            });
        },
        stop : function (moduleID) {
            var mod = _moduleRegistry[moduleID];
            if (mod.instance) {
                mod.instance.destroy();
                mod.instance = null;
            } else {
                this.log(1, "Stop Module '" + moduleID + "': FAILED : module does not exist or has not been started");
            }
        },
        stopAll : function () {
            var moduleID;
            for (moduleID in _moduleRegistry) {
                if (_moduleRegistry.hasOwnProperty(moduleID)) {
                    this.stop(moduleID);
                }
            }
        },
        registerExtension : function(name, ext, dependencies) {
            if (dependencies && ({}).toString.call(dependencies) === '[object Array]') {
                for (var dep in dependencies) {
                    if (!_extensions[dependencies[dep]]) {
                        this.log(1, "Register extension '" + name + "' : FAILED : dependency '" + dependencies[dep] + "' not found");
                        return;
                    }
                }
            }
            if (typeof name === "string" && typeof ext === "function") {
                _extensions[name] = ext;
                this[name] = ext(this);
            } else {
                this.log(1, "Register extension '" + name + "' : FAILED : unproper type");
            }
        },
        registerEvents : function (evts, moduleID) {
            if (this.type.isObj(evts) && moduleID) {
                if (_moduleRegistry[moduleID]) {
                    _moduleRegistry[moduleID].events = evts;
                } else {
                    this.log(1, "Register module '" + moduleID + "'events : FAILED : module not found");
                }
            } else {
                this.log(1, "Register module '" + moduleID + "' events : FAILED : unproper event object type or mot set module");
            }
        },
        triggerEvent : function (evt) {
            for (var mod in _moduleRegistry) {
                if (_moduleRegistry.hasOwnProperty(mod)){
                    mod = _moduleRegistry[mod];
                    if (mod.events && mod.events[evt.type]) {
                        mod.events[evt.type](evt.data);
                    }
                }
            }
        },
        removeEvents : function (evts, moduleID) {
            var i, mod;
            if (this.type.isArr(evts) && moduleID && (mod = _moduleRegistry[moduleID]) && mod.events) {
                for (i in evts) {
                    if (mod.events.hasOwnProperty(i)){
                        delete mod.events[i];
                    }
                }
            }
        },
        extend : function(params, obj){
            var obj = obj || {},
                i,
                toStr = Object.prototype.toString,
                astr = "[object Array]";

            if (typeof params === "object"){
                for (i in params) {
                    if (params.hasOwnProperty(i)) {
                        if (typeof params[i] === "object" && params[i] !== null) {
                            obj[i] = (toStr.call(params[i]) === astr) ? [] : {};
                        } else {
                            obj[i] = params[i];
                        }
                    }
                }
            }
            return obj;
        },
        getType: function(obj){
            if (obj === null) return "null";
            if (obj === undefined) return "undefined";
            return Object.prototype.toString.call(obj).slice(8, -1).toLowerCase();
        },
        debug : function (on) {
            _debug  = on ? true : false;
        },
        log : function (severity, message) {
            if (_debug) {
                console[ (severity === 1) ? 'log' : (severity === 2) ? 'warn' : 'error'](message);
            } else {
                //@TODO: send to the server
            }
        }
    };
})(SPRING);
