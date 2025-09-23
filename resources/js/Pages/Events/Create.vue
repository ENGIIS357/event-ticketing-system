<template>
  <div class="container mx-auto px-4 py-8" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">إضافة فعالية جديدة</h1>

    <form @submit.prevent="submitEvent" class="space-y-4 max-w-lg bg-white p-6 rounded-lg shadow-md">
      <!-- اسم الفعالية -->
      <div>
        <label class="block text-sm font-medium text-gray-700">اسم الفعالية *</label>
        <input v-model="form.title" type="text" required
               class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
      </div>

      <!-- الوصف -->
      <div>
        <label class="block text-sm font-medium text-gray-700">الوصف *</label>
        <textarea v-model="form.description" rows="3" required
                  class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200"></textarea>
      </div>

      <!-- الموقع -->
      <div>
        <label class="block text-sm font-medium text-gray-700">الموقع *</label>
        <input v-model="form.location" type="text" required
               class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
      </div>

      <!-- التواريخ -->
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">تاريخ البداية *</label>
          <input v-model="form.start_date" type="date" required
                 class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">تاريخ النهاية *</label>
          <input v-model="form.end_date" type="date" required
                 class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
        </div>
      </div>

      <!-- السعر وعدد التذاكر -->
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">السعر (ر.س) *</label>
          <input v-model.number="form.price" type="number" min="0" step="0.01" required
                 class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">عدد التذاكر *</label>
          <input v-model.number="form.available_tickets" type="number" min="1" required
                 class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
        </div>
      </div>

      <!-- أزرار الإرسال -->
      <div class="flex justify-end gap-2 pt-4">
        <button type="button" @click="router.visit('/events')"
                class="px-4 py-2 text-gray-600 border rounded-md hover:bg-gray-100">
          إلغاء
        </button>
        <button type="submit" :disabled="saving"
                class="px-4 py-2 bg-green-600 text-white rounded-md disabled:opacity-50">
          {{ saving ? 'جاري الحفظ...' : 'حفظ' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

const saving = ref(false)

const form = reactive({
  title: '',
  description: '',
  location: '',
  start_date: '',
  end_date: '',
  price: 0,
  available_tickets: 1
})

const submitEvent = async () => {
  saving.value = true

  // --- Validation محلي ---
  if (!form.title || !form.description || !form.location) {
    alert('❌ يرجى ملء جميع الحقول النصية')
    saving.value = false
    return
  }

  if (!form.start_date || !form.end_date) {
    alert('❌ يرجى تحديد التواريخ')
    saving.value = false
    return
  }

  if (new Date(form.end_date) < new Date(form.start_date)) {
    alert('❌ تاريخ النهاية يجب أن يكون بعد تاريخ البداية')
    saving.value = false
    return
  }

  if (form.price < 0 || form.available_tickets < 1) {
    alert('❌ تأكد من أن السعر وعدد التذاكر صحيح')
    saving.value = false
    return
  }

  try {
    // --- إرسال البيانات ---
    const payload = {
      title: form.title.trim(),
      description: form.description.trim(),
      location: form.location.trim(),
      start_date: form.start_date,
      end_date: form.end_date,
      price: parseFloat(form.price),
      available_tickets: parseInt(form.available_tickets),
    }

    console.log('🚀 إرسال البيانات:', payload)

    await axios.post('/api/v1/events', payload, {
      headers: { 'Accept': 'application/json' }
    })

    alert('✅ تم إضافة الفعالية بنجاح!')
    router.visit('/events')
  } catch (error) {
    console.error('خطأ في الإرسال:', error)
    if (error.response?.data?.errors) {
      const messages = Object.values(error.response.data.errors).flat().join(', ')
      alert('❌ فشل إضافة الفعالية: ' + messages)
    } else {
      alert('❌ فشل إضافة الفعالية')
    }
  } finally {
    saving.value = false
  }
}
</script>
