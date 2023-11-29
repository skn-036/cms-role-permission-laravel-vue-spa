import { ref, watch } from 'vue';
const useSlider = (sliderName = '', options = {}) => {
    const defaultOptions = {
        initialSliderValue: false,
        disableWindowScrollOnActive: true,
    };
    options = { ...defaultOptions, options };

    const slider = ref(options.initialSliderValue);
    const sliderData = ref(null);

    const showSlider = (name, data = null) => {
        slider.value = name;
        sliderData.value = data;
    };
    const hideSlider = () => {
        slider.value = typeof slider.value === 'boolean' ? false : null;
        sliderData.value = null;
    };

    const updateSliderData = (items, itemKey = 'id') => {
        if (!sliderData.value || !items || !items.length) return;

        const item = items.value.find(
            (item) => item[itemKey] == sliderData.value[itemKey],
        );
        if (item) sliderData.value = item;
    };

    if (options.disableWindowScrollOnActive) {
        watch(
            () => slider.value,
            () => {
                if (slider.value)
                    document.body.classList.add('overflow-hidden');
                else document.body.classList.remove('overflow-hidden');
            },
        );
    }
    return {
        slider,
        sliderData,
        sliderName,
        showSlider,
        hideSlider,
        updateSliderData,
    };
};

export default useSlider;
