<template>
  <Head title="إدارة التذاكر" />
  
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="text-right">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white">إدارة التذاكر</h2>
          <p class="text-gray-600 dark:text-gray-300 mt-1">إدارة تذاكر الفعاليات</p>
        </div>
        <button class="flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors">
          إنشاء تذكرة
          <span>+</span>
        </button>
      </div>
    </template>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 text-right">
          <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border">
            <div class="text-2xl font-bold text-blue-600">{{ tickets.length }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">إجمالي التذاكر</div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border">
            <div class="text-2xl font-bold text-green-600">{{ soldTickets }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">تذاكر مباعة</div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border">
            <div class="text-2xl font-bold text-yellow-600">{{ availableTickets }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">تذاكر متاحة</div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border">
            <div class="text-2xl font-bold text-purple-600">{{ totalRevenue }} ر.س</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">إجمالي الإيرادات</div>
          </div>
        </div>

        <!-- التذاكر -->
        <div class="grid gap-6">
          <div v-for="ticket in tickets" :key="ticket.id" 
               class="bg-white dark:bg-gray-800 rounded-lg shadow border hover:shadow-lg transition-all">
            <div class="p-6">
              <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">{{ ticket.event_name }}</h3>
                <span :class="`px-3 py-1 rounded-full text-xs font-medium ${
                  ticket.status === 'available' 
                    ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' 
                    : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300'
                }`">
                  {{ ticket.status === 'available' ? 'متاح' : 'مباع' }}
                </span>
              </div>

              <div class="grid grid-cols-2 gap-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                <div class="flex items-center gap-2 justify-end">
                  <span>{{ ticket.type }}</span>
                  <span>🎫</span>
                </div>
                <div class="flex items-center gap-2 justify-end">
                  <span>{{ ticket.price }} ر.س</span>
                  <span>💰</span>
                </div>
                <div class="flex items-center gap-2 justify-end">
                  <span>{{ ticket.quantity }} تذكرة</span>
                  <span>📦</span>
                </div>
                <div class="flex items-center gap-2 justify-end">
                  <span>{{ formatDate(ticket.created_at) }}</span>
                  <span>📅</span>
                </div>
              </div>

              <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-600">
                <button class="flex-1 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition-colors">
                  تعديل
                </button>
                <button class="flex-1 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition-colors">
                  حذف
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- رسالة إذا لم يكن هناك تذاكر -->
        <div v-if="tickets.length === 0" class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow mt-6">
          <div class="text-6xl mb-4">🎫</div>
          <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">لا توجد تذاكر</h3>
          <p class="text-gray-500 dark:text-gray-400 mb-6">قم بإنشاء تذاكر للفعاليات</p>
          <button class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors">
            إنشاء تذكرة أولى
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { ref, onMounted, computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const tickets = ref([])
const loading = ref(true)

const soldTickets = computed(() => tickets.value.filter(t => t.status === 'sold').length)
const availableTickets = computed(() => tickets.value.filter(t => t.status === 'available').length)
const totalRevenue = computed(() => tickets.value.reduce((sum, t) => sum + (t.price * t.quantity), 0))

const fetchTickets = async () => {
  try {
    // بيانات تجريبية - سيتم استبدالها ب API حقيقي
    tickets.value = [
      {
        id: 1,
        event_name: 'حفل موسيقي',
        type: 'عادي',
        price: 150,
        quantity: 100,
        status: 'available',
        created_at: new Date().toISOString()
      },
      {
        id: 2,
        event_name: 'ندوة تقنية',
        type: 'VIP',
        price: 300,
        quantity: 50,
        status: 'sold',
        created_at: new Date().toISOString()
      }
    ]
  } catch (error) {
    console.error('Error fetching tickets:', error)
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('ar-SA')
}

onMounted(() => {
  fetchTickets()
})
</script>