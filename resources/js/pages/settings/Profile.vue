<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { type User } from '@/types';
import { useI18n } from 'vue-i18n';
import FormInput from '@/components/burnout-ui/input/FormInput.vue';
import { ref } from 'vue';
import defaultAvatar from '../../../img/default-avatar.jpg';

interface Props {
    mustVerifyEmail: boolean;
    status?: string;
}

defineProps<Props>();

const { t } = useI18n();

const page = usePage();
const user = page.props.auth.user as User;

const avatarIsHovered = ref(false);

const avatarForm = useForm({
    avatar_url: null as File | null,
});

const form = useForm({
    name: user.name,
    email: user.email,
});

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};

const uploadAvatar = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        avatarForm.avatar_url = target.files[0];

        // Envoyer immédiatement après sélection
        // Log ce qui est envoyé
        avatarForm.post(route('profile.avatar.update'), {
            forceFormData: true, // Important pour les uploads de fichiers
            onSuccess: () => {
                // update user avatar URL in the form for display in real time
                if (avatarForm.avatar_url) {
                    user.avatar_url = URL.createObjectURL(avatarForm.avatar_url);
                }
            },
            onError: (errors) => {
                console.error('Upload errors:', errors);
            }
        });
    }
};

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <div class="my-2 mx-4">
        <font-awesome-icon @click="goBack" icon="fa-solid fa-arrow-left" class="text-xl my-4 mx-2" />
            <div class="flex flex-col space-y-6">
                <HeadingSmall :title="t('profile.title')" :description="t('profile.description')" />

                <form @submit.prevent="submit" class="space-y-6 mt-4 mb-10">
                    <!-- Avatar Upload -->
                    <div class="relative flex items-center gap-4">
                        <span
                            v-if="avatarIsHovered"
                            class="absolute top-0 left-0 h-16 w-16 rounded-full bg-black/60">
                            <font-awesome-icon icon="fa-solid fa-camera" class="h-4 w-4 text-white absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
                        </span>
                        <img
                            :src="user.avatar_url ?? defaultAvatar"
                            alt="User Avatar"
                            class="h-16 w-16 rounded-full object-cover cursor-pointer"
                        />
                        <input
                            type="file"
                            accept="image/*"
                            class="absolute inset-0 opacity-0 cursor-pointer h-16 w-16 rounded-full z-50"
                            @change="uploadAvatar"
                            @mouseenter="avatarIsHovered = true"
                            @mouseleave="avatarIsHovered = false"
                        />
                    </div>

                    <div class="grid gap-2">
                        <FormInput
                            id="name"
                            v-model="form.name"
                            required
                            autocomplete="name"
                            :label="t('profile.name')"
                            @update:model-value="form.name = $event"
                        />
                        <InputError v-if="form.errors.name" class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <FormInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            autocomplete="email"
                            :label="t('profile.email')"
                            @update:model-value="form.email = $event"
                        />
                        <InputError v-if="form.errors.email" class="mt-2" :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-muted-foreground">
                            {{ t('profile.verify-email') }}
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                            >
                                {{ t('profile.resend-verification-link') }}
                            </Link>
                        </p>

                        <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                            {{ t('profile.verification-link-sent') }}
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        <span class="h-4">
                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">{{ t('profile.saved') }}</p>
                            </Transition>
                        </span>
                        <Button :disabled="form.processing" class="w-[250px]">{{ t('profile.save') }}</Button>
                    </div>
                </form>
            </div>
            <DeleteUser />
    </div>
</template>
