<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import FormInput from '@/components/burnout-ui/input/FormInput.vue';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import logo from '../../../img/logo.png';

interface Props {
    token: string;
    email: string;
}

const props = defineProps<Props>();

const { t } = useI18n();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center">

        <div class="mb-12 flex flex-col items-center gap-2">
            <img :src="logo" alt="BURNOUT Logo" class="h-32 w-32" />
            <h1 class="text-2xl font-bold">{{ t('forgot-password.reset-title') }}</h1>
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6 w-full max-w-80 px-10">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <FormInput id="email" :label="t('register.form.email')" type="email" v-model="form.email" :readonly="true"/>
                </div>

                <div class="grid gap-2">
                    <FormInput id="password" :label="t('register.form.password')" type="password" v-model="form.password" :required="false" />
                </div>

                <div class="grid gap-2">
                    <FormInput
                        v-model="form.password_confirmation"
                        id="password_confirmation"
                        :label="t('register.form.password_confirmation')"
                        type="password"
                        :required="false"
                    />
                    <div class="h-10">
                        <InputError :message="form.errors.email ? t('forgot-password.email-check.' + form.errors.email) : ''" />
                        <InputError :message="form.errors.password ? t('forgot-password.password-check.' + form.errors.password) : ''" />
                        <InputError :message="form.errors.password_confirmation ? t('forgot-password.password-check.' + form.errors.password_confirmation) : ''" />
                    </div>
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    {{ t('forgot-password.submit') }}
                </Button>
            </div>
        </form>
    </div>
</template>
