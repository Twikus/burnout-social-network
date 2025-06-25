<script setup lang="ts">
import FormInput from '@/components/burnout-ui/input/FormInput.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import logo from '../../../img/logo.png';

defineProps<{
    status?: string;
}>();

const { t } = useI18n();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center">
        <div class="mb-12 flex flex-col items-center gap-2">
            <img :src="logo" alt="BURNOUT Logo" class="h-32 w-32" />
            <h1 class="text-2xl font-bold">{{ t('forgot-password.title') }}</h1>
        </div>

        <div class="space-y-6">
            <form @submit.prevent="submit">
                <div class="grid gap-2">
                    <FormInput
                        id="email"
                        :label="t('forgot-password.email')"
                        type="email"
                        name="email"
                        :required="true"
                        autocomplete="off"
                        v-model="form.email"
                        autofocus
                    />
                    <InputError :message="t(form.errors.email ? t('forgot-password.email-check.' + form.errors.email) : '')" />
                    <div v-if="status" class="mb-4 w-[250px] text-center text-sm font-medium text-green-600">
                        {{ t('forgot-password.' + status) }}
                    </div>
                </div>

                <div class="my-6 flex items-center justify-start">
                    <button
                        type="submit"
                        class="mt-8 flex w-[275px] items-center justify-center rounded-sm bg-[#ED4220] px-4 py-2 text-white transition-colors duration-200 active:bg-[#ff5d27]"
                    >
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        <span v-else>{{ t('forgot-password.send-link') }}</span>
                    </button>
                </div>
            </form>

            <div class="space-x-1 text-center text-sm text-muted-foreground">
                <span>{{ t('forgot-password.go-back') }}</span>
                <TextLink :href="route('lp')">{{ t('auth.login').toLowerCase() }}</TextLink>
            </div>
        </div>
    </div>
</template>
