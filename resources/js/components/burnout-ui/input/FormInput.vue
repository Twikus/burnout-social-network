<script setup lang="ts">
import { useVModel } from '@vueuse/core';
import { Ref, ref, type HTMLAttributes } from 'vue';

const props = defineProps<{
    id: string;
    label: string;
    type?: string;
    required?: boolean;

    modelValue?: string;
    class?: HTMLAttributes['class'];
}>();

const emits = defineEmits<{
    (e: 'update:modelValue', payload: string): void;
}>();

const modelValue = useVModel(props, 'modelValue', emits, {
    passive: true,
});

const isPasswordVisible: Ref<boolean> = ref(false);
const isInputFocused: Ref<boolean> = ref(false);

// Functions to handle focus events
const handleFocus = () => {
    isInputFocused.value = true;
};

// Functions to handle blur events
const handleBlur = () => {
    isInputFocused.value = (modelValue.value ?? '').length > 0;
};

const switchPasswordDisplay = () => {
    isPasswordVisible.value = !isPasswordVisible.value;

    const input: HTMLInputElement = document.getElementById(props.id);

    if (isPasswordVisible.value) {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
};
</script>

<template>
    <label :for="props.id" class="relative w-full" :class="props.class">
        <small
            :class="[
                'absolute transition-all duration-200 ease-in-out dark:text-gray-300',
                isInputFocused
                    ? 'top-[2px] left-[8px] text-[10px]'
                    : 'top-1/2 left-[8px] -translate-y-1/2 transform text-sm',
            ]"
        >
            {{ props.label }}
        </small>
        <input
            :id="props.id"
            :type="props.type || 'text'"
            :required="props.required || false"
            autofocus
            :autocomplete="props.type"
            v-model="modelValue"
            @focus="handleFocus"
            @blur="handleBlur"
            class="mx-auto w-full rounded-sm border border-[rgb(85,85,85)] bg-[rgb(18,18,18)] p-2 pt-4 text-[12px] focus:outline-none dark:text-white"
        />
        <span
            v-if="props.type === 'password' && (modelValue ?? '').length > 0"
            @click="switchPasswordDisplay()"
            class="absolute top-1/2 right-3 -translate-y-1/2 transform cursor-pointer text-white"
        >
            <font-awesome-icon
                v-if="isPasswordVisible"
                :icon="['fas', 'eye']"
                class="h-4 w-4"
                style="color: white"
            />
            <font-awesome-icon
                v-else
                :icon="['fas', 'eye-slash']"
                class="h-4 w-4"
                style="color: white"
            />
        </span>
    </label>
</template>
