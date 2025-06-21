<script setup lang="ts">
import GoogleAuth from '@/components/auth/GoogleAuth.vue';
import InputError from '@/components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { Ref, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t, locale } = useI18n();

const currentLocale: Ref<string> = ref(locale.value);

const form = useForm({
    email: '',
    password: '',
    remember: true,
});

// Function to change the locale
const changeLocale = (newLocale: string) => {
    if (newLocale !== currentLocale.value) {
        locale.value = newLocale;
        currentLocale.value = newLocale;
    }
};

const isEmailFocused: Ref<boolean> = ref(false);
const isPasswordFocused: Ref<boolean> = ref(false);

// Functions to handle focus events
const handleFocus = (type: string) => {
    if( type === 'email') {
        isEmailFocused.value = true;
    }

    if ( type === 'password') {
        isPasswordFocused.value = true;
    }
};

// Functions to handle blur events
const handleBlur = (type: string) => {
    if (type === 'email') {
        isEmailFocused.value = form.email.length > 0;
    }

    if (type === 'password') {
        isPasswordFocused.value = form.password.length > 0;
    }
};

// Submit the form for login
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
	<Head>
		<link rel="preconnect" href="https://rsms.me/" />
		<link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
	</Head>
    <div class="flex flex-col min-h-screen bg-[#FDFDFC] text-[#1b1b18] dark:bg-[#0a0a0a]">
		<!-- <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
			<nav class="flex items-center justify-end gap-4">
				<Link
					v-if="$page.props.auth.user"
					:href="route('home')"
					class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
				>
					Accueil
				</Link>
				<template v-else>
					<Link
						:href="route('login')"
						class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
					>
						{{ t('auth.login') }}
					</Link>
					<Link
						:href="route('register')"
						class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
					>
						{{ t('auth.register') }}
					</Link>
				</template>
			</nav>
		</header> -->

        <main class="h-full flex-grow w-full grid grid-cols-1 md:w-1/2 md:mx-auto">
            <div class="h-full flex flex-col items-center justify-center">
                <div class="h-max w-full">
                    <img src="../../img/logo.png" alt="logo" class="w-32 mx-auto mt-10" />
                    <!-- login form -->
                    <form
                        @submit.prevent="submit"
                        class="flex flex-col w-full items-center px-10"
                    >
                        <label for="email-form" class="relative w-full mt-10">
                            <small
                                :class="[
                                    'absolute transition-all duration-200 ease-in-out dark:text-gray-300',
                                    isEmailFocused
                                        ? 'text-[10px] top-[2px] left-[8px]'
                                        : 'text-sm top-1/2 left-[8px] transform -translate-y-1/2'
                                ]"
                            >
                                {{ t('home.form.email') }}
                            </small>
                            <input
                                id="email-form"
                                type="email"
                                required
                                autofocus
                                autocomplete="email"
                                :tabindex="1"
                                v-model="form.email"
                                @focus="handleFocus('email')"
                                @blur="handleBlur('email')"
                                class="w-full text-[12px] mx-auto p-2 pt-4 bg-[rgb(18,18,18)] border border-[rgb(85,85,85)] rounded-sm dark:text-white focus:outline-none"
                            />
                        </label>
                        <InputError :message="form.errors.email ? t( 'home.form.' + form.errors.email) : ''" />

                        <label for="password-form" class="relative w-full mt-2">
                            <small
                                :class="[
                                    'absolute transition-all duration-200 ease-in-out dark:text-gray-300',
                                    isPasswordFocused
                                        ? 'text-[10px] top-[2px] left-[8px]'
                                        : 'text-sm top-1/2 left-[8px] transform -translate-y-1/2'
                                ]"
                            >
                                {{ t('home.form.password') }}
                            </small>
                            <input
                                id="password-form"
                                type="password"
                                required
                                :tabindex="2"
                                autocomplete="current-password"
                                v-model="form.password"
                                @focus="handleFocus('password')"
                                @blur="handleBlur('password')"
                                class="w-full text-[12px] mx-auto p-2 pt-4 bg-[rgb(18,18,18)] border border-[rgb(85,85,85)] rounded-sm dark:text-white focus:outline-none"
                            />
                        </label>
                        <InputError :message="form.errors.password ? t( 'home.form.' + form.errors.password) : ''" />

                        <button
                            type="submit"
                            class="mt-8 w-full bg-[#ED4220] text-white py-2 flex justify-center items-center rounded-sm active:bg-[#ff5d27] transition-colors duration-200"
                        >
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin mr-4" />
                            <span>{{ t('home.form.submit') }}</span>
                        </button>
                    </form>

                    <div class="flex items-center justify-center my-10">
                        <span class="w-30 border border-white"></span>
                        <p class="text-center text-sm text-white mx-4" >
                            {{ t('home.form.or').toUpperCase() }}
                        </p>
                        <span class="w-30 border border-white"></span>
                    </div>

                    <div>
                        <a :href="route('auth.google.redirect')" class="flex items-center justify-center mt-4">
                            <GoogleAuth class="w-full" />
                        </a>
                    </div>

                </div>
            </div>
        </main>


        <!-- Footer -->
        <footer class="w-full text-center text-sm text-neutral-500 py-6 border-t border-neutral-800">
            <p>© 2024 Burnout. {{ t('home.footer.all-rights') }}</p>
            <div class="space-x-4 mt-2">
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
