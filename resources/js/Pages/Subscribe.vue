<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import dropin from 'braintree-web-drop-in';
import $ from 'jquery';


import {Head, useForm, usePage} from "@inertiajs/vue3";

const props = defineProps({
    clientToken: String,
});

const form = useForm({
    plan: 'monthly',
    nonce: '',
});

dropin.create({
    authorization: props.clientToken,
    container: '#dropin-container',
    paypal: {
        flow: 'vault',
    }
}, function (createErr, instance) {
    $('#checkout-button').click(function (e) {
        e.preventDefault();
        instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
            form.nonce = payload.nonce
            axios.post(route('api.subscriptions.checkout'), form)
                .then(function (response) {
                    window.location.href = route('dashboard')
                })
        });
    });
});


</script>

<style>@import url('https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css')</style>
<style>
/*
module.exports = {
    plugins: [require('@tailwindcss/forms'),]
};
*/
.form-radio {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
    display: inline-block;
    vertical-align: middle;
    background-origin: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    flex-shrink: 0;
    border-radius: 100%;
    border-width: 2px;
}

.form-radio:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
    border-color: transparent;
    background-color: currentColor;
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
}

@media not print {
    .form-radio::-ms-check {
        border-width: 1px;
        color: transparent;
        background: inherit;
        border-color: inherit;
        border-radius: inherit;
    }
}

.form-radio:focus {
    outline: none;
}

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23a0aec0'%3e%3cpath d='M15.3 9.3a1 1 0 0 1 1.4 1.4l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 1.4-1.4l3.3 3.29 3.3-3.3z'/%3e%3c/svg%3e");
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
    background-repeat: no-repeat;
    padding-top: 0.5rem;
    padding-right: 2.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    background-position: right 0.5rem center;
    background-size: 1.5em 1.5em;
}

.form-select::-ms-expand {
    color: #a0aec0;
    border: none;
}

@media not print {
    .form-select::-ms-expand {
        display: none;
    }
}

@media print and (-ms-high-contrast: active), print and (-ms-high-contrast: none) {
    .form-select {
        padding-right: 0.75rem;
    }
}
</style>

<template>
    <Head title="Subscribe"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Subscribe</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


                <div class="min-w-screen min-h-screen bg-gray-50 py-5">
                    <div class="px-5">
                        <div class="mb-2">
                            <h1 class="text-3xl md:text-5xl font-bold text-gray-600">Checkout</h1>
                        </div>
                    </div>

                    <div class="w-full bg-white border-t border-b border-gray-200 px-5 py-10 text-gray-800">
                        <div class="flex flex-row min-h-screen justify-center items-center">
                            <div class="-mx-3 md:flex items-start">
                                <form>
                                    <div class="px-3">
                                        <div
                                            class="w-full mx-auto text-gray-800 font-light mb-6 border-b border-gray-200 pb-6">
                                            <div class="w-full flex items-center">
                                                <div
                                                    class="overflow-hidden rounded-lg w-16 h-16 bg-gray-50 border border-gray-200">
                                                    <img
                                                        src="https://images.pexels.com/photos/6770610/pexels-photo-6770610.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                                                        alt="">
                                                </div>
                                                <div class="flex-grow pl-3">
                                                    <h6 class="font-semibold uppercase text-gray-600">Advanced Stream
                                                        Stats</h6>
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-600 text-xl">$<span
                                                        v-if="form.plan === 'monthly'">10</span><span
                                                        v-else-if="form.plan === 'yearly'">100</span></span><span
                                                    class="font-semibold text-gray-600 text-sm">.00<span
                                                    v-if="form.plan === 'monthly'"> / month</span><span
                                                    v-else-if="form.plan === 'yearly'"> / year</span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                                            <div class="mb-5">
                                                <label for="plan" class="flex items-center cursor-pointer">
                                                    <input type="radio" v-model="form.plan"
                                                           class="form-radio h-5 w-5 text-indigo-500" value="monthly"
                                                           name="plan" id="plan" checked>
                                                    <span class="h-6 ml-3">
                                                        Monthly
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="mb-5">
                                                <label for="plan" class="flex items-center cursor-pointer">
                                                    <input type="radio" v-model="form.plan"
                                                           class="form-radio h-5 w-5 text-indigo-500" value="yearly"
                                                           name="plan" id="plan">
                                                    <span class="h-6 ml-3">
                                                        Yearly
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div
                                            class="w-full mx-auto rounded-lg bg-white border border-gray-200 p-3 text-gray-800 font-light mb-6">
                                            <div class="w-full flex mb-3 items-center">
                                                <div class="w-32">
                                                    <span class="text-gray-600 font-semibold">Contact</span>
                                                </div>
                                                <div class="flex-grow pl-3">
                                                    <span>Scott Windon</span>
                                                </div>
                                            </div>
                                            <div class="w-full flex items-center">
                                                <div class="w-32">
                                                    <span class="text-gray-600 font-semibold">Billing Address</span>
                                                </div>
                                                <div class="flex-grow pl-3">
                                                    <span>123 George Street, Sydney, NSW 2000 Australia</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="w-full mx-auto rounded-lg bg-white border border-gray-200 text-gray-800 font-light mb-6">

                                        </div>
                                        <div id="dropin-wrapper" class="w-full p-3">
                                            <div id="checkout-message"></div>
                                            <div id="dropin-container"></div>
                                        </div>

                                        <div>
                                            <button id ="checkout-button"
                                                class="block w-full max-w-xs mx-auto bg-indigo-500 hover:bg-indigo-700 focus:bg-indigo-700 text-white rounded-lg px-3 py-2 font-semibold">
                                                <i class="mdi mdi-lock-outline mr-1"></i> PAY NOW
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="text-center text-gray-400 text-sm">
                            <a href="https://www.buymeacoffee.com/scottwindon" target="_blank"
                               class="focus:outline-none underline text-gray-400"><i class="mdi mdi-beer-outline"></i>Buy
                                the creator of this UI a beer</a> and help support open-resource
                        </div>
                    </div>
                </div>

                <!-- BUY ME A BEER AND HELP SUPPORT OPEN-SOURCE RESOURCES -->
                <div class="flex items-end justify-end fixed bottom-0 right-0 mb-4 mr-4 z-10">
                    <div>
                        <a title="Buy this guy a beer" href="https://www.buymeacoffee.com/scottwindon" target="_blank"
                           class="block w-16 h-16 rounded-full transition-all shadow hover:shadow-lg transform hover:scale-110 hover:rotate-12">
                            <img class="object-cover object-center w-full h-full rounded-full"
                                 src="https://i.pinimg.com/originals/60/fd/e8/60fde811b6be57094e0abc69d9c2622a.jpg"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
