<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Components
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { useI18n } from 'vue-i18n';
import FormInput from './burnout-ui/input/FormInput.vue';

const passwordInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    password: '',
});

const { t } = useI18n();

const deleteUser = (e: Event) => {
    e.preventDefault();

    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <div class="space-y-6">
        <HeadingSmall :title="t('profile.delete-account.title')" :description="t('profile.delete-account.description')" />
        <div class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
            <div class="relative space-y-0.5 text-red-600 dark:text-red-100">
                <p class="font-medium">{{ t('profile.delete-account.warning') }}</p>
                <p class="text-sm">{{ t('profile.delete-account.before-delete') }}</p>
            </div>
            <Dialog>
                <DialogTrigger as-child>
                    <Button variant="destructive">{{ t('profile.delete-account.title') }}</Button>
                </DialogTrigger>
                <DialogContent>
                    <form class="space-y-6" @submit="deleteUser">
                        <DialogHeader class="space-y-3">
                            <DialogTitle>{{ t('profile.delete-account.confirm.title') }}</DialogTitle>
                            <DialogDescription>
                                {{ t('profile.delete-account.confirm.description') }}
                            </DialogDescription>
                        </DialogHeader>

                        <div class="grid gap-2">
                            <FormInput
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="password"
                                :label="t('profile.delete-account.confirm.password')"
                                @update:model-value="form.password = $event"
                            />
                            <InputError v-if="form.errors.password" class="mt-2" :message="form.errors.password" />
                        </div>

                        <DialogFooter class="gap-2">
                            <DialogClose as-child>
                                <Button class="cursor-pointer" variant="secondary" @click="closeModal">{{ t('profile.delete-account.confirm.cancel') }}</Button>
                            </DialogClose>

                            <Button type="submit" class="cursor-pointer" variant="destructive" :disabled="form.processing">{{ t('profile.delete-account.title') }}</Button>
                        </DialogFooter>
                    </form>
                </DialogContent>
            </Dialog>
        </div>
    </div>
</template>
