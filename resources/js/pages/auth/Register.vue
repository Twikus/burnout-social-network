<script setup lang="ts">
import FormInput from '@/components/burnout-ui/input/FormInput.vue';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { useI18n } from 'vue-i18n';
import logo from '../../../img/logo.png';

const { t } = useI18n();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center">

        <div class="mb-12 flex flex-col items-center gap-2">
            <img :src="logo" alt="BURNOUT Logo" class="h-32 w-32" />
            <h1 class="text-2xl font-bold">{{ t('auth.create-account') }}</h1>
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <FormInput v-model="form.name" id="name" :label="t('register.form.name')" :required="true" @update:model-value="form.name = $event" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <FormInput v-model="form.email" id="email" :label="t('register.form.email')" type="email" :required="true" @update:model-value="form.email = $event" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <FormInput v-model="form.password" id="password" :label="t('register.form.password')" type="password" :required="true" @update:model-value="form.password = $event" />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <FormInput
                        v-model="form.password_confirmation"
                        id="password_confirmation"
                        :label="t('register.form.password_confirmation')"
                        type="password"
                        :required="true"
                        @update:model-value="form.password_confirmation = $event"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="5" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    {{ t('register.form.submit') }}
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                {{ t('register.already-account') }}
                <TextLink :href="route('lp')" class="underline underline-offset-4" :tabindex="6">{{
                    t('auth.login')
                }}</TextLink>
            </div>
        </form>
    </div>
</template>
