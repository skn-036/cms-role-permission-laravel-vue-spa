import { ref, computed, provide, onMounted, onBeforeUnmount } from 'vue';

const useTheme = () => {
    const theme = ref('light');
    const windowWidth = ref(1600);
    const isDarkMode = computed(() => Boolean(theme.value === 'dark'));

    if (
        localStorage.theme === 'dark' ||
        (!('theme' in localStorage) &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        document.documentElement.classList.add('dark');
        theme.value = 'dark';
    } else {
        document.documentElement.classList.remove('dark');
        theme.value = 'light';
    }

    const setWindowWidth = () => {
        windowWidth.value = document.body.clientWidth;
    };

    onMounted(() => {
        setWindowWidth();
    });

    window.addEventListener('resize', setWindowWidth, false);

    onBeforeUnmount(() => {
        window.removeEventListener('resize', setWindowWidth, false);
    });

    const updateDarkMode = (darkMode) => {
        if (darkMode) {
            theme.value = 'dark';
            localStorage.setItem('theme', 'dark');
            document.documentElement.classList.add('dark');
        } else {
            theme.value = 'light';
            localStorage.setItem('theme', 'light');
            document.documentElement.classList.remove('dark');
        }
    };

    provide('theme', { isDarkMode, updateDarkMode, windowWidth });
};

export default useTheme;
