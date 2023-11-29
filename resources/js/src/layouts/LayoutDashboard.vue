<script setup>
import { ref } from 'vue';

import DashboardHeader from './DashboardHeader.vue';
import PageLoader from './PageLoader.vue';
import SuspenseFallback from './SuspenseFallback.vue';

const asyncLoading = ref(false);
</script>

<template>
    <div class="w-full">
        <!-- header -->
        <header
            class="w-full bg-cc-10 h-20 min-h-[80px] sticky top-0 shadow-google z-10"
        >
            <DashboardHeader
                class="h-full container mx-auto flex-between max-w-[1172px] px-4 xl:px-0 gap-4 text-dark-color"
            />
        </header>

        <main class="h-[calc(100%-80px)] w-full relative">
            <PageLoader :loading="asyncLoading" />

            <div class="container mx-auto max-w-[1172px] px-4 lg:px-0 h-full">
                <RouterView v-slot="{ Component }">
                    <template v-if="Component">
                        <Suspense
                            @pending="asyncLoading = true"
                            @resolve="asyncLoading = false"
                        >
                            <component :is="Component"></component>
                            <template #fallback>
                                <SuspenseFallback />
                            </template>
                        </Suspense>
                    </template>
                </RouterView>
            </div>
        </main>
    </div>
</template>
