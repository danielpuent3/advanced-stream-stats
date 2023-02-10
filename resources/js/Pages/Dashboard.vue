<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- component -->
                    <div class="h-[15rem] flex flex-col md:flex-row bg-purple-900 gap-2">
                        <div class="flex flex-row m-auto bg-gradient-to-r from-purple-700 via-purple-800 to-purple-900 p-6 gap-8 rounded-lg border-2 border-purple-500">
                            <div class="my-auto">
                                <div class="text-lg text-purple-300">Streams</div>
                                <div class="text-4xl text-purple-100">19m</div>
                            </div>
                            <div class="text-purple-300 my-auto bg-gradient-to-l from-purple-700 via-purple-800 to-purple-900 rounded-full p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-row m-auto bg-gradient-to-r from-purple-700 via-purple-800 to-purple-900 p-6 gap-8 rounded-lg border-2 border-purple-500">
                            <div class="my-auto">
                                <div class="text-lg text-purple-300">Downloads</div>
                                <div class="text-4xl text-purple-100">62k</div>
                            </div>
                            <div class="text-purple-300 my-auto bg-gradient-to-l from-purple-700 via-purple-800 to-purple-900 rounded-full p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex flex-row m-auto bg-gradient-to-r from-purple-700 via-purple-800 to-purple-900 p-6 gap-8 rounded-lg border-2 border-purple-500">
                            <div class="my-auto">
                                <div class="text-lg text-purple-300">Unique Views</div>
                                <div class="text-4xl text-purple-100">292k</div>
                            </div>
                            <div class="text-purple-300 my-auto bg-gradient-to-l from-purple-700 via-purple-800 to-purple-900 rounded-full p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
