<script setup>
import { ref, computed } from 'vue';
import emitter from 'tiny-emitter/instance';
import useUtils from '../../composables/useUtils';

const { isObject, isEmptyObject } = useUtils();

const show = ref(false);
const initialModalData = computed(() => ({
    message: 'Are you sure to delete?',
    actionButton: {
        class: 'bg-red-500 active:bg-red-500 hover:bg-red-600 shadow-google',
        text: 'Proceed',
    },
    returnButton: {
        class: 'bg-green-500 active:bg-green-500 hover:bg-green-600 shadow-google',
        text: 'Go back',
    },
}));
const setModalData = (data) => {
    if (!data || !isObject(data) || isEmptyObject(data))
        return initialModalData.value;
    const { message, actionButton, returnButton } = data;

    const mergedData = {
        ...initialModalData.value,
        message: message ? message : initialModalData.value.message,
        actionButton: actionButton
            ? actionButton
            : initialModalData.value.actionButton,
        returnButton: returnButton
            ? returnButton
            : initialModalData.value.returnButton,
    };

    return mergedData;
};
const modalData = ref(initialModalData.value);

const onButtonClick = (callback, confirmed) => {
    show.value = false;
    callback(confirmed);
};

emitter.on('show-confirm-modal', (data, callback) => {
    show.value = true;
    modalData.value = setModalData(data);

    setTimeout(() => {
        const actionButton = document.querySelector('#action-button');
        const returnButton = document.querySelector('#return-button');
        const cancelButton = document.querySelector('#cancel-button');
        const overlay = document.querySelector('#confirm-modal-overlay');

        if (actionButton)
            actionButton.addEventListener('click', () => {
                onButtonClick(callback, true);
                actionButton.removeEventListener('click', () => {
                    onButtonClick(callback, true);
                });
            });
        if (returnButton)
            returnButton.addEventListener('click', () => {
                onButtonClick(callback, false);
                returnButton.removeEventListener('click', () => {
                    onButtonClick(callback, false);
                });
            });

        if (returnButton)
            cancelButton.addEventListener('click', () => {
                onButtonClick(callback, null);
                cancelButton.removeEventListener('click', () => {
                    onButtonClick(callback, null);
                });
            });
        if (overlay)
            overlay.addEventListener('click', () => {
                onButtonClick(callback, null);
                overlay.removeEventListener('click', () => {
                    onButtonClick(callback, null);
                });
            });
    }, 100);
});
</script>

<template>
    <Teleport to="body">
        <!-- overlay -->
        <div
            v-if="show"
            id="confirm-modal-overlay"
            class="w-screen h-screen fixed bg-gray-200 z-[313] top-0 left-0 opacity-20"
        ></div>

        <!-- modal -->
        <Transition
            enter-from-class="scale-75 opacity-0"
            leave-to-class="scale-75 opacity-0"
            enter-active-class="transition ease-out duration-300"
            leave-active-class="transition ease-out duration-300"
        >
            <div
                v-if="show"
                class="confirm-modal rounded-sm bg-white dark:bg-gray-800 border border-[#e6e6e6] dark:border-gray-700 shadow-google fixed top-20 w-11/12 md:w-3/4 lg:w-3/5 xl:w-2/5 left-[4%] md:left-[12.5%] lg:left-[20%] xl:left-[30%] z-[314]"
            >
                <div
                    class="px-4 py-3 font-bold border-b border-[#e6e6e6] dark:border-gray-700"
                >
                    <div class="flex-between">
                        <div class="font-bold text-lg">
                            {{ modalData.message }}
                        </div>
                        <slot name="close">
                            <span
                                id="cancel-button"
                                class="text-xl cursor-pointer"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    width="24"
                                    height="24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="css-i6dzq1"
                                >
                                    <line
                                        x1="18"
                                        y1="6"
                                        x2="6"
                                        y2="18"
                                    ></line>
                                    <line
                                        x1="6"
                                        y1="6"
                                        x2="18"
                                        y2="18"
                                    ></line>
                                </svg>
                            </span>
                        </slot>
                    </div>
                </div>
                <div class="px-4 py-3 w-full flex-end">
                    <div class="flex-start gap-2">
                        <button
                            id="return-button"
                            class="px-4 py-2 rounded-sm text-white text-sm font-bold"
                            :class="[modalData.returnButton.class]"
                        >
                            {{ modalData.returnButton.text }}
                        </button>
                        <button
                            id="action-button"
                            class="px-4 py-2 rounded-sm text-white text-sm font-bold"
                            :class="[modalData.actionButton.class]"
                        >
                            {{ modalData.actionButton.text }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
