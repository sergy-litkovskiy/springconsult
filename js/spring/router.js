;var SPRING = SPRING || {};

SPRING.Router = (function(core){
    var self = this;

    
    this.extend = function(params) {
        return core.$.extend({}, this, params);
    };

})(SPRING.Core);
