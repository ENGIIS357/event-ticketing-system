<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
      <h1 class="text-3xl font-bold text-center mb-8">صفحة اختبار النموذج</h1>
      
      <div class="bg-white p-6 rounded-lg shadow-md">
        <button 
          @click="showForm = !showForm"
          class="bg-blue-500 text-white px-4 py-2 rounded mb-4"
        >
          {{ showForm ? 'إخفاء النموذج' : 'إظهار النموذج' }}
        </button>

        <div v-if="showForm" class="mt-4 p-4 border border-gray-300 rounded">
          <h2 class="text-xl font-semibold mb-4">نموذج اختباري بسيط</h2>
          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <label class="block text-gray-700">اسم الفعالية</label>
              <input 
                v-model="formData.title" 
                type="text" 
                class="w-full px-3 py-2 border border-gray-300 rounded"
                placeholder="ادخل اسم الفعالية"
              >
            </div>
            <div class="mb-4">
              <label class="block text-gray-700">الوصف</label>
              <textarea 
                v-model="formData.description" 
                class="w-full px-3 py-2 border border-gray-300 rounded"
                rows="3"
                placeholder="ادخل وصف الفعالية"
              ></textarea>
            </div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
              حفظ
            </button>
          </form>
        </div>

        <div class="mt-8">
          <h3 class="text-xl font-semibold mb-4">حالة التطبيق:</h3>
          <pre class="bg-gray-200 p-4 rounded">{{ { showForm, formData } }}</pre>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const showForm = ref(false)
const formData = reactive({
  title: '',
  description: ''
})

const submitForm = () => {
  alert('تم حفظ البيانات: ' + JSON.stringify(formData))
  formData.title = ''
  formData.description = ''
  showForm.value = false
}
</script>