<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

defineProps({
    subscription: Object
});

const confirmingCancelSubscription = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmCancelSubscription = () => {
    confirmingCancelSubscription.value = true;

    nextTick(() => passwordInput.value.focus());
};

const cancelSubscription = () => {
    form.post(route('profile.cancelSubscription'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingCancelSubscription.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Cancel Subscription</h2>

            <div v-if="subscription.ends_at === null">
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    If you cancel your subscription will remain active until the end of the current billing cycle ({{ subscription.next_billing_at }})
                </p>
            </div>
            <div v-else>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Your subscription has been canceled. You can enjoy full access until {{ subscription.ends_at }}
                </p>
            </div>
        </header>

        <div v-if="subscription.ends_at === null">
            <DangerButton @click="confirmCancelSubscription">Cancel Subscription</DangerButton>
        </div>

        <Modal :show="confirmingCancelSubscription" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Are you sure you want to cancel your subscription?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Please enter your password to confirm you would like to cancel your account.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="cancelSubscription"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="cancelSubscription"
                    >
                        Cancel Subscription
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
