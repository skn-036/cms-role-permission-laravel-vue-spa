export default {
    mounted: function (el, { value, arg, modifiers }) {
        if (!el) return;
        if (arg === 'mounted' || value) {
            el.focus();
        }
        if (arg === 'select' || modifiers.select) {
            setTimeout(() => {
                if (document.activeElement === el) el.select();
            }, 50);
        }
    },
    updated: function (el, { value, oldValue, arg, modifiers }) {
        if (!el) return;
        if (modifiers.once && arg === 'mounted') return;
        if (value && value !== oldValue) {
            el.focus();
            if (arg === 'select' || modifiers.select) {
                setTimeout(() => {
                    if (document.activeElement === el) el.select();
                }, 50);
            }
        }
    },
};
