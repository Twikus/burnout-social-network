<script setup lang="ts">
import GoogleAuth from '@/components/auth/GoogleAuth.vue';
import FormInput from '@/components/burnout-ui/input/FormInput.vue';
import InputError from '@/components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { Ref, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import logo from '../../img/logo.png';

const { t, locale } = useI18n();

const currentLocale: Ref<string> = ref(locale.value);

console.log('Current locale:', currentLocale.value);

const form = useForm({
    email: '',
    password: '',
    remember: true,
});

const isSameError = () => {
    if (!form.errors) {
        return;
    }

    const errorValues = Object.values(form.errors || {});
    return new Set(errorValues).size > 1;
};

// Function to change the locale
const changeLocale = (newLocale: string) => {
    if (newLocale !== currentLocale.value) {
        locale.value = newLocale;
        currentLocale.value = newLocale;
    }
};

// Submit the form for login
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head>
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a]">
        <main class="grid h-full w-full flex-grow grid-cols-1 md:mx-auto md:w-1/2">
            <div class="flex h-full flex-col items-center justify-center">
                <div class="h-max w-full">
                    <img :src="logo" alt="logo" class="mx-auto mt-10 w-32" />
                    <!-- login form -->
                    <form @submit.prevent="submit" class="flex w-full flex-col items-center px-10">
                        <FormInput
                            class="mt-10"
                            id="email-form"
                            :label="t('register.form.email')"
                            type="email"
                            :required="true"
                            v-model="form.email"
                            @update:model-value="form.email = $event"
                        />

                        <FormInput
                            class="mt-4"
                            id="password-form"
                            :label="t('register.form.password')"
                            type="password"
                            :required="true"
                            v-model="form.password"
                            @update:model-value="form.password = $event"
                        />

                        <template v-if="isSameError()">
                            <InputError v-for="(error, index) in form.errors" :key="index" :message="t('home.form.' + error)" />
                        </template>

                        <InputError v-else :message="form.errors.email ? t('home.form.' + form.errors.email) : ''" />

                        <button
                            type="submit"
                            class="mt-8 flex w-full items-center justify-center rounded-sm bg-[#ED4220] py-2 text-white transition-colors duration-200 active:bg-[#ff5d27]"
                        >
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            <span v-else>{{ t('home.form.submit') }}</span>
                        </button>
                        <!-- Forgotten password -->
                        <Link :href="route('password.request')" class="ml mt-2 text-xs text-white hover:underline">{{
                            t('home.form.forgot-password')
                        }}</Link>
                    </form>

                    <div class="my-10 flex items-center justify-center px-10">
                        <span class="w-full border border-white opacity-50"></span>
                        <p class="mx-4 text-center text-sm text-white">
                            {{ t('home.form.or').toUpperCase() }}
                        </p>
                        <span class="w-full border border-white opacity-50"></span>
                    </div>

                    <div>
                        <a :href="route('auth.google.redirect')" class="mt-4 flex items-center justify-center">
                            <GoogleAuth class="w-full" />
                        </a>
                    </div>

                    <div class="mt-6 flex flex-col items-center justify-center">
                        <p class="text-white">
                            {{ t('home.form.need-account') }}
                        </p>
                        <Link :href="route('register')" class="text-[#ED4220] hover:underline">{{
                            t('home.form.signup')
                        }}</Link>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full border-t border-neutral-800 py-6 text-center text-sm text-neutral-500">
            <p>© 2024 Burnout. {{ t('home.footer.all-rights') }}</p>
            <div class="mt-2 space-x-4">
                <select
                    :value="currentLocale"
                    @change="changeLocale(($event.target && ($event.target as HTMLSelectElement).value) || '')"
                    class="bg-transparent px-2 py-1 focus:outline-none"
                    aria-label="Language selection"
                >
                    <option value="fr">Français</option>
                    <option value="en">English</option>
                </select>
                <a href="#" class="hover:underline">{{ t('home.footer.terms') }}</a>
                <a href="#" class="hover:underline">{{ t('home.footer.privacy') }}</a>
            </div>
        </footer>
    </div>
</template>
