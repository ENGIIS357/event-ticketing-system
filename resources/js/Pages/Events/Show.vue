<template>
  <Head title="عرض الفعالية" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center text-right">
        <div>
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ event.title }}</h2>
          <p class="text-gray-600 dark:text-gray-300 mt-1">تفاصيل الفعالية</p>
        </div>
        <button @click="$inertia.visit('/events')" 
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
          رجوع للفعاليات
        </button>
      </div>
    </template>

    <div class="py-6 max-w-4xl mx-auto text-right">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- شريط الحالة -->
        <div :class="`h-2 ${new Date(event.start_date) > new Date() ? 'bg-green-500' : 'bg-gray-400'}`"></div>

        <div class="p-8 space-y-6">
          <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">الوصف</h3>
            <p class="text-gray-600 dark:text-gray-300">{{ event.description || 'لا يوجد وصف' }}</p>
          </div>

          <div class="grid grid-cols-2 gap-4 text-gray-600 dark:text-gray-300">
            <div class="flex items-center gap-2 justify-end">
              <span>{{ event.location || 'غير محدد' }}</span>
              <span>📍</span>
            </div>
            <div class="flex items-center gap-2 justify-end">
              <span>{{ formatDate(event.start_date) }}</span>
              <span>📅</span>
            </div>
            <div class="flex items-center gap-2 justify-end">
              <span>{{ event.end_date ? formatDate(event.end_date) : 'غير محدد' }}</span>
              <span>📆</span>
            </div>
            <div class="flex items-center gap-2 justify-end">
              <span>{{ event.price || 0 }} ر.س</span>
              <span>💰</span>
            </div>
            <div class="flex items-center gap-2 justify-end">
              <span>{{ event.available_tickets || 0 }} تذكرة</span>
              <span>🎫</span>
            </div>
            <div class="flex items-center gap-2 justify-end">
              <span>{{ event.user.name }}</span>
              <span>👤</span>
            </div>
          </div>

          <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-600">
            <button @click="$inertia.visit(`/events/${event.id}/edit`)" 
                    class="flex-1 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
              تعديل ✏️
            </button>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = usePage().props
const event = props.event || {}

const formatDate = (dateString) => {
  if (!dateString) return 'غير محدد'
  return new Date(dateString).toLocaleDateString('ar-SA', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}
</script>

<style scoped>
/* تحسين النصوص المقطوعة */
</style>
