<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AdminDashboard from '@/Components/Events/AdminDashboard.vue';

// Chart.js registration (مش محتاج تعمل register مرة ثانية إذا مسويها في المكون)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">
                لوحة التحكم 🎪
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-white">
                        <p class="mb-4">مرحباً بك في نظام إدارة الفعاليات! ✅</p>
                        <!-- هنا نضيف المكون الجديد -->
                        <AdminDashboard />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>