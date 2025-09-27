<template>
  <Head :title="'تعديل الفعالية - ' + event.title" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center text-right">
        <div>
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white">تعديل الفعالية</h2>
          <p class="text-gray-600 dark:text-gray-300 mt-1">قم بتعديل بيانات الفعالية</p>
        </div>
        <button @click="$inertia.visit('/events')" 
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
          رجوع للفعاليات
        </button>
      </div>
    </template>

    <div class="py-6 max-w-4xl mx-auto text-right">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-8 space-y-6">
          <form @submit.prevent="updateEvent" class="space-y-4">

            <!-- اسم الفعالية -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">اسم الفعالية *</label>
              <input v-model="form.title" type="text" required
                     class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                            focus:ring-2 focus:ring-green-500 focus:border-transparent
                            dark:bg-gray-700 dark:text-white text-right" dir="rtl">
            </div>

            <!-- الوصف -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">الوصف *</label>
              <textarea v-model="form.description" rows="4" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                               focus:ring-2 focus:ring-green-500 focus:border-transparent
                               dark:bg-gray-700 dark:text-white text-right" dir="rtl"></textarea>
            </div>

            <!-- الموقع -->
            <div>
              <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">الموقع *</label>
              <input v-model="form.location" type="text" required
                     class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                            focus:ring-2 focus:ring-green-500 focus:border-transparent
                            dark:bg-gray-700 dark:text-white text-right" dir="rtl">
            </div>

            <!-- التواريخ -->
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">تاريخ البداية *</label>
                <input v-model="form.start_date" type="date" required
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                              focus:ring-2 focus:ring-green-500 focus:border-transparent
                              dark:bg-gray-700 dark:text-white text-center" dir="rtl">
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">تاريخ النهاية *</label>
                <input v-model="form.end_date" type="date" required
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                              focus:ring-2 focus:ring-green-500 focus:border-transparent
                              dark:bg-gray-700 dark:text-white text-center" dir="rtl">
              </div>
            </div>

            <!-- السعر والتذاكر -->
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">السعر (ر.س) *</label>
                <input v-model.number="form.price" type="number" min="0" step="0.01" required
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                              focus:ring-2 focus:ring-green-500 focus:border-transparent
                              dark:bg-gray-700 dark:text-white text-right" dir="rtl">
              </div>
              <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">عدد التذاكر *</label>
                <input v.model.number="form.available_tickets" type="number" min="1" required
                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                              focus:ring-2 focus:ring-green-500 focus:border-transparent
                              dark:bg-gray-700 dark:text-white text-right" dir="rtl">
              </div>
            </div>

            <!-- رسالة الحالة -->
            <div v-if="message" :class="messageClass" class="p-4 rounded-md text-center font-medium">
              {{ message }}
            </div>

            <!-- أزرار الإجراءات -->
            <div class="flex justify-start gap-3 pt-4">
              <button type="submit" 
                      class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium">
                💾 حفظ التغييرات
              </button>
              <button type="button" @click="$inertia.visit('/events')" 
                      class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                إلغاء
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { reactive, ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = usePage().props
const event = props.event || {}
const currentUserId = props.auth.user.id

// التحقق من المالك
if (!event.id || event.user.id !== currentUserId) {
  router.visit('/events')
}

// نموذج التعديل
const form = reactive({
  id: event.id, // ⭐ مهم
  title: event.title || '',
  description: event.description || '',
  location: event.location || '',
  start_date: event.start_date ? event.start_date.substr(0,10) : '',
  end_date: event.end_date ? event.end_date.substr(0,10) : '',
  price: event.price || 0,
  available_tickets: event.available_tickets || 1,
})

// رسالة الحالة
const message = ref('')
const messageClass = ref('')

// دالة الحفظ المعدلة
const updateEvent = async () => {
  try {
    await router.put(route('events.update', event.id), form, {
      preserveScroll: true,
      onSuccess: () => {
        message.value = 'تم تعديل الفعالية بنجاح!'
        messageClass.value = 'bg-green-100 text-green-800 border border-green-200'
      },
      onError: (errors) => {
        message.value = 'حدث خطأ أثناء التعديل. يرجى التحقق من البيانات.'
        messageClass.value = 'bg-red-100 text-red-800 border border-red-200'
        console.error('Update errors:', errors)
      },
    })
  } catch (error) {
    console.error('Request error:', error)
    message.value = 'حدث خطأ في الشبكة. يرجى المحاولة مرة أخرى.'
    messageClass.value = 'bg-red-100 text-red-800 border border-red-200'
  }
}
</script>