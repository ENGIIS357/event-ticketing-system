<template>
  <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
      <!-- العنوان والأزرار -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">قائمة الفعاليات</h2>
        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
          إضافة فعالية جديدة
        </button>
      </div>

      <!-- حالة التحميل -->
      <div v-if="loading" class="text-center py-8">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto"></div>
        <p class="mt-2 text-gray-600">جاري تحميل الفعاليات...</p>
      </div>

      <!-- حالة الخطأ -->
      <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ error }}
      </div>

      <!-- عرض الفعاليات -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="event in events" :key="event.id" 
             class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
          
          <!-- صورة الفعالية -->
          <img v-if="event.image" :src="event.image" :alt="event.title" class="w-full h-48 object-cover">
          <div v-else class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <span class="text-gray-500">لا توجد صورة</span>
          </div>
          
          <!-- محتوى البطاقة -->
          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ event.title }}</h3>
            <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">📍 {{ event.location }}</p>
            <p class="text-gray-500 dark:text-gray-400 text-xs">
              🕒 {{ formatDate(event.start_date) }} - {{ formatDate(event.end_date) }}
            </p>
            <p class="text-green-600 font-bold mt-2">{{ event.price }} ر.س</p>
            <p class="text-blue-600 text-sm">🎫 {{ event.available_tickets }} تذكرة متاحة</p>
            <p class="text-gray-400 text-xs mt-2">👤 منظم الفعالية: {{ event.user.name }}</p>

            <!-- أزرار التحكم -->
            <div class="mt-4 flex space-x-2">
              <button class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                عرض
              </button>
              <button class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">
                تعديل
              </button>
              <button class="flex-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                حذف
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'EventList',
  data() {
    return {
      events: [],
      loading: true,
      error: null
    };
  },
  mounted() {
    this.fetchEvents();
  },
  methods: {
    async fetchEvents() {
      try {
        this.loading = true;
        const response = await axios.get('/api/v1/events');
        this.events = response.data.events;
      } catch (error) {
        console.error('Error fetching events:', error);
        this.error = 'فشل في تحميل الفعاليات. يرجى المحاولة مرة أخرى.';
      } finally {
        this.loading = false;
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('ar-SA', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    }
  }
};
</script>