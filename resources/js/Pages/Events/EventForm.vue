<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg w-full max-w-md mx-auto shadow-xl">
      <div class="p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold">
            {{ event ? 'تعديل الفعالية' : 'إضافة فعالية جديدة' }}
          </h2>
          <button 
            @click="$emit('close')"
            class="text-gray-500 hover:text-gray-700"
          >
            ✕
          </button>
        </div>

        <form @submit.prevent="submitForm" class="space-y-4">
          <!-- حقول النموذج -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">اسم الفعالية</label>
            <input
              v-model="form.title"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="أدخل اسم الفعالية"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">الوصف</label>
            <textarea
              v-model="form.description"
              rows="3"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="أدخل وصف الفعالية"
            ></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ البداية</label>
              <input
                v-model="form.start_date"
                type="datetime-local"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ النهاية</label>
              <input
                v-model="form.end_date"
                type="datetime-local"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">الموقع</label>
            <input
              v-model="form.location"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="أدخل موقع الفعالية"
            >
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">السعر (ر.س)</label>
              <input
                v-model="form.price"
                type="number"
                min="0"
                step="0.01"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">عدد التذاكر</label>
              <input
                v-model="form.available_tickets"
                type="number"
                min="1"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
            </div>
          </div>

          <div class="flex justify-end space-x-2 space-x-reverse mt-6">
            <button
              type="button"
              @click="$emit('close')"
              class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-md"
            >
              إلغاء
            </button>
            <button
              type="submit"
              :disabled="loading"
              class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 disabled:opacity-50"
            >
              {{ loading ? 'جاري الحفظ...' : 'حفظ' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
  event: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['close', 'saved'])

const loading = ref(false)
const form = reactive({
  title: '',
  description: '',
  start_date: '',
  end_date: '',
  location: '',
  price: 0,
  available_tickets: 1
})

// إذا كان هناك حدث للتعديل، املأ النموذج ببياناته
watch(() => props.event, (newEvent) => {
  if (newEvent) {
    Object.assign(form, {
      title: newEvent.title,
      description: newEvent.description,
      start_date: newEvent.start_date.replace(' ', 'T'),
      end_date: newEvent.end_date.replace(' ', 'T'),
      location: newEvent.location,
      price: newEvent.price,
      available_tickets: newEvent.available_tickets
    })
  }
}, { immediate: true })

// إرسال النموذج
const submitForm = async () => {
  loading.value = true
  try {
    let response
    if (props.event) {
      // تحديث الفعالية الموجودة
      response = await axios.put(`/api/v1/events/${props.event.id}`, form)
    } else {
      // إنشاء فعالية جديدة
      response = await axios.post('/api/v1/events', form)
    }
    
    emit('saved', response.data.event)
    alert('تم حفظ الفعالية بنجاح')
  } catch (error) {
    console.error('Failed to save event:', error)
    alert('فشل حفظ الفعالية')
  } finally {
    loading.value = false
  }
}
</script>