(function () {
    var defaults = {
            interval: 7500,
            delay: 0,
            action: null
        };
        
        jQuery.fn.poller = function(o) {
            return this.each(function() {
                jQuery(this).data('poller', new $c(this, o));
            });
        };
        
        jQuery.poller = function ( element, options ) {
            this.e          = jQuery( element );
            this.options    = jQuery.extend( {}, defaults, this.e.data(), options || {} );
            this.timer      = null;
            this.init();
        };
        
        var $c = jQuery.poller;
            $c.fn = $c.prototype = {
            poller: '0.1.0'
        };
        
        $c.fn.extend = $c.extend = jQuery.extend;
        
        $c.fn.extend({
            init: function() {
                this.container = this.e;
                
                if (this.options.delay > 0) {
                    this.timer = window.setTimeout(function() { self.go(); }, self.options.delay);    
                } else {
                    this.go();
                }                
            },
            
            go: function() {
                var self = this;
                
                self.runner = window.setTimeout(function() { self.doAction(); }, self.options.interval);
            },
            
            stop: function() {
                var self = this;
                
                window.clearTimeout(self.runner);
            },            
            
            doAction: function() {
                var self = this;
                
                window.clearTimeout(self.runner);
                
                self.executeFunctionByName(self.options.action, window);                
                
                self.go();
            },
            
            executeFunctionByName: function(functionName, context /*, args */) {
                var args = Array.prototype.slice.call(arguments, 2);
                var namespaces = functionName.split(".");
                var func = namespaces.pop();
                for (var i = 0; i < namespaces.length; i++) {
                    context = context[namespaces[i]];
                }
                if (typeof context[func] == 'function') {
                    return context[func].apply(context, args);
                }
                return null;
            }            

        });
        
})(jQuery);