<script setup>
import { computed } from 'vue';
import useUserStore from '../../store/useUserStore';
import FourZero1 from '../ui/401.vue';

const props = defineProps({
    permissions: {
        type: Array,
        default: () => [],
    },
});

const userStore = useUserStore();

const isAuthorized = computed(() => {
    if (!props.permissions.length) return true;
    return (userStore.user?.permissions || []).some((permission) =>
        props.permissions.includes(permission?.name),
    );
});
</script>

<template>
    <template v-if="isAuthorized">
        <slot></slot>
    </template>

    <FourZero1
        v-else
        :permissions="permissions"
    />
</template>
