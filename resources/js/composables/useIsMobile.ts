import { computed, onMounted, onUnmounted, ref } from 'vue';

export function useIsMobile(breakpoint = 640) {
    const windowWidth = ref(window.innerWidth);

    const handleResize = () => {
        windowWidth.value = window.innerWidth;
    };

    onMounted(() => window.addEventListener('resize', handleResize));
    onUnmounted(() => window.removeEventListener('resize', handleResize));

    const isMobile = computed(() => windowWidth.value < breakpoint);

    return { isMobile };
}
