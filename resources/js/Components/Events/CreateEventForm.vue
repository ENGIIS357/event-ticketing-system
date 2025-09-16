<template>
  <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
      <!-- العنوان -->
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">إضافة فعالية جديدة</h2>

      <!-- نموذج الإضافة -->
      <form @submit.prevent="submitForm" class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        
        <!-- عنوان الفعالية -->
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="title">
            عنوان الفعالية *
          </label>
          <input
            v-model="form.title"
            id="title"
            type="text"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
          >
        </div>

        <!-- وصف الفعالية -->
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="description">
            الوصف *
          </label>
          <textarea
            v-model="form.description"
            id="description"
            rows="4"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
          ></textarea>
        </div>

        <!-- الموقع -->
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="location">
            الموقع *
          </label>
          <input
            v-model="form.location"
            id="location"
            type="text"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
          >
        </div>

        <!-- التاريخ والوقت -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="start_date">
              تاريخ البدء *
            </label>
            <input
              v-model="form.start_date"
              id="start_date"
              type="datetime-local"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
          </div>
          <div>
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="end_date">
              تاريخ الانتهاء *
            </label>
            <input
              v-model="form.end_date"
              id="end_date"
              type="datetime-local"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
          </div>
        </div>

        <!-- السعر والتذاكر -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="price">
              السعر (ر.س) *
            </label>
            <input
              v-model="form.price"
              id="price"
              type="number"
              step="0.01"
              min="0"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
          </div>
          <div>
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="available_tickets">
              عدد التذاكر المتاحة *
            </label>
            <input
              v-model="form.available_tickets"
              id="available_tickets"
              type="number"
              min="1"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
          </div>
        </div>

        <!-- صورة الفعالية -->
        <div class="mb-6">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="image">
            صورة الفعالية (اختياري)
          </label>
          <input
            @change="handleImageUpload"
            id="image"
            type="file"
            accept="image/*"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          >
        </div>

        <!-- أزرار -->
        <div class="flex items-center justify-between">
          <button
            type="button"
            @click="$emit('cancel')"
            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          >
            إلغاء
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline disabled:opacity-50"
          >
            {{ loading ? 'جاري الإضافة...' : 'إضافة الفعالية' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'CreateEventForm',
  emits: ['cancel', 'created'],
  data() {
    return {
      loading: false,
      form: {
        title: '',
        description: '',
        location: '',
        start_date: '',
        end_date: '',
        price: 0,
        available_tickets: 1,
        image: null
      }
    };
  },
  methods: {
    handleImageUpload(event) {
      this.form.image = event.target.files[0];
    },
    async submitForm() {
      this.loading = true;
      
      try {
        const formData = new FormData();
        Object.keys(this.form).forEach(key => {
          if (this.form[key] !== null) {
            formData.append(key, this.form[key]);
          }
        });

        const response = await axios.post('/api/v1/events', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        this.$emit('created', response.data.event);
        this.resetForm();
        
      } catch (error) {
        console.error('Error creating event:', error);
        alert('فشل في إضافة الفعالية. يرجى المحاولة مرة أخرى.');
      } finally {
        this.loading = false;
      }
    },
    resetForm() {
      this.form = {
        title: '',
        description: '',
        location: '',
        start_date: '',
        end_date: '',
        price: 0,
        available_tickets: 1,
        image: null
      };
    }
  }
};
</script>