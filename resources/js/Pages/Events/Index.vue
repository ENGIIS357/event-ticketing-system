<template>
  <div class="container mx-auto px-4 py-8" dir="rtl">
    <!-- رأس الصفحة -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">الفعاليات</h1>
      <button @click="router.visit('/events/create')"
              class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
        + إضافة فعالية جديدة
      </button>
    </div>

    <!-- حالة التحميل -->
    <div v-if="loading" class="text-center py-8">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto"></div>
      <p class="mt-2 text-gray-600">جاري تحميل الفعاليات...</p>
    </div>

    <!-- عرض الفعاليات -->
    <div v-else class="grid md:grid-cols-2 gap-6">
      <div v-for="event in events" :key="event.id"
           class="bg-white shadow-md rounded-lg border p-6 flex flex-col justify-between hover:shadow-xl transition-all">
        <div>
          <h3 class="text-xl font-semibold text-blue-600 mb-2 text-right">{{ event.title }}</h3>
          <p class="text-gray-600 mb-2 text-right">{{ event.description }}</p>
          <div class="text-sm text-gray-500 space-y-1 text-right">
            <p><strong>الموقع:</strong> {{ event.location }}</p>
            <p><strong>التاريخ:</strong> {{ formatDate(event.start_date) }} - {{ formatDate(event.end_date) }}</p>
            <p><strong>السعر:</strong> {{ event.price }} ر.س</p>
            <p><strong>التذاكر المتاحة:</strong> {{ event.available_tickets }}</p>
          </div>
        </div>

        <!-- أزرار التحكم تظهر فقط للمستخدم صاحب الفعالية -->
        <div v-if="currentUserId === event.user_id" class="mt-4 flex justify-between space-x-2 space-x-reverse">
          <button @click="viewEvent(event)"
                  class="flex items-center gap-1 bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
            عرض
          </button>
          <button @click="editEvent(event)"
                  class="flex items-center gap-1 bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
            تعديل
          </button>
          <button @click="deleteEvent(event.id)"
                  class="flex items-center gap-1 bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition">
            حذف
          </button>
        </div>
      </div>
    </div>

    <!-- نموذج التعديل (بنفس الصفحة) -->
    <div v-if="showForm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg w-full max-w-md overflow-auto shadow-lg">
        <div class="p-6">
          <h2 class="text-xl font-semibold mb-4">تعديل الفعالية</h2>
          <form @submit.prevent="submitEdit" class="space-y-4">
            <input type="hidden" v-model="form.id" />

            <div>
              <label class="block text-sm font-medium text-gray-700">اسم الفعالية *</label>
              <input v-model="form.title" type="text" required class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">الوصف *</label>
              <textarea v-model="form.description" rows="3" required class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200"></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">الموقع *</label>
              <input v-model="form.location" type="text" required class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">تاريخ البداية *</label>
                <input v-model="form.start_date" type="date" required class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">تاريخ النهاية *</label>
                <input v-model="form.end_date" type="date" required class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">السعر (ر.س) *</label>
                <input v-model="form.price" type="number" min="0" step="0.01" required class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">عدد التذاكر *</label>
                <input v-model="form.available_tickets" type="number" min="1" required class="w-full px-3 py-2 border rounded-md mt-1 focus:ring focus:ring-green-200">
              </div>
            </div>

            <div class="flex justify-end gap-2 pt-4">
              <button type="button" @click="closeForm()" class="px-4 py-2 text-gray-600 border rounded-md hover:bg-gray-100">إلغاء</button>
              <button type="submit" :disabled="saving" class="px-4 py-2 bg-green-600 text-white rounded-md disabled:opacity-50">
                {{ saving ? 'جاري الحفظ...' : 'تحديث' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

const events = ref([])
const loading = ref(true)
const lastError = ref('')
const showForm = ref(false)
const saving = ref(false)

// معرف المستخدم الحالي (تحل محل Authorization frontend)
const currentUserId = ref(null)

const form = reactive({
  id: null,
  title: '',
  description: '',
  location: '',
  start_date: '',
  end_date: '',
  price: 0,
  available_tickets: 1
})

const fetchEvents = async () => {
  loading.value = true
  try {
    const response = await axios.get('/api/v1/events')
    events.value = response.data.events
    // نفترض أن الـ backend يعيد info عن المستخدم الحالي
    currentUserId.value = response.data.current_user_id || 1
    lastError.value = ''
  } catch (error) {
    lastError.value = 'فشل تحميل الفعاليات: ' + error.message
  } finally {
    loading.value = false
  }
}

const editEvent = (event) => {
  Object.assign(form, {
    ...event,
    start_date: event.start_date ? event.start_date.split('T')[0] : '',
    end_date: event.end_date ? event.end_date.split('T')[0] : ''
  })
  showForm.value = true
}

const closeForm = () => {
  showForm.value = false
  Object.assign(form, { id: null, title: '', description: '', location: '', start_date: '', end_date: '', price: 0, available_tickets: 1 })
}

const submitEdit = async () => {
  saving.value = true
  try {
    const response = await axios.put(`/api/v1/events/${form.id}`, {
      title: form.title,
      description: form.description,
      location: form.location,
      start_date: form.start_date,
      end_date: form.end_date,
      price: form.price,
      available_tickets: form.available_tickets
    })
    events.value = events.value.map(e => e.id === form.id ? response.data.event : e)
    alert('تم تحديث الفعالية بنجاح!')
    closeForm()
  } catch (error) {
    console.error('خطأ في الإرسال:', error)
    lastError.value = error.response?.data?.message || error.message
    alert('فشل التحديث: ' + lastError.value)
  } finally {
    saving.value = false
  }
}

const deleteEvent = async (id) => {
  if (!confirm('هل أنت متأكد من حذف الفعالية؟')) return
  try {
    await axios.delete(`/api/v1/events/${id}`)
    events.value = events.value.filter(e => e.id !== id)
    alert('تم حذف الفعالية بنجاح')
  } catch (error) {
    lastError.value = 'فشل الحذف: ' + (error.response?.data?.message || error.message)
    alert('فشل حذف الفعالية: ' + lastError.value)
  }
}

const formatDate = (dateString) => dateString ? dateString.split('T')[0] : ''

onMounted(() => fetchEvents())
</script>
