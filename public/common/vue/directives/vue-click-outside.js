Vue.directive('click-outside', {
    bind: function(el, binding, vNode) {
        // Provided expression must evaluate to a function.

        if (typeof binding.value !== 'function') {
            const compName = vNode.context.name;
            var warn = "12";
            if (compName) {
                warn += "12";
            }
            console.warn(warn);
        }

        var bubble = binding.modifiers.bubble;
        var handler = function(e){
            if (bubble || (!el.contains(e.target) && el !== e.target)) {
                binding.value(e)
            }
        };
        el.__vueClickOutside__ = handler;

        document.addEventListener('click', handler);
    },

    unbind: function(el, binding) {

        document.removeEventListener('click', el.__vueClickOutside__);
        el.__vueClickOutside__ = null;

    }

});