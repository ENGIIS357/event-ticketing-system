<template>
  <AppLayout title="إدارة التذاكر" description="عرض وإدارة جميع التذاكر">
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-blue-100 text-sm">إجمالي التذاكر</p>
                <p class="text-3xl font-bold">{{ ticketsData.stats.totalTickets }}</p>
              </div>
              <div class="text-3xl">🎫</div>
            </div>
          </div>

          <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-green-100 text-sm">تذاكر محجوزة</p>
                <p class="text-3xl font-bold">{{ ticketsData.stats.reservedTickets }}</p>
              </div>
              <div class="text-3xl">✅</div>
            </div>
          </div>

          <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-yellow-100 text-sm">تذاكر متاحة</p>
                <p class="text-3xl font-bold">{{ ticketsData.stats.availableTickets }}</p>
              </div>
              <div class="text-3xl">🟢</div>
            </div>
          </div>

          <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-purple-100 text-sm">إجمالي الإيرادات</p>
                <p class="text-3xl font-bold">{{ ticketsData.stats.totalRevenue }} ر.س</p>
              </div>
              <div class="text-3xl">💰</div>
            </div>
          </div>
        </div>

        <!-- جدول التذاكر -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">قائمة التذاكر</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-right">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">رقم التذكرة</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">الفعالية</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">المستخدم</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">النوع</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">السعر</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">الحالة</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                <tr v-for="ticket in ticketsData.tickets.data" :key="ticket.id" 
                    class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                  <td class="px-6 py-4">
                    <span class="font-mono text-sm bg-gray-100 dark:bg-gray-600 px-2 py-1 rounded">
                      {{ ticket.ticket_number || 'غير محدد' }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3 justify-end">
                      <div class="text-right">
                        <p class="font-medium text-gray-800 dark:text-white">{{ ticket.event.title }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <p class="font-medium text-gray-800 dark:text-white">
                      {{ ticket.user?.name || 'غير محدد' }}
                    </p>
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                      {{ ticket.type }}
                    </span>
                  </td>
                  <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">
                    {{ ticket.price }} ر.س
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                      {{ ticket.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- إذا ما فيه تذاكر -->
        <div v-if="ticketsData.tickets.data.length === 0" class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg mt-6">
          <div class="text-6xl mb-4">🎫</div>
          <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">لا توجد تذاكر</h3>
          <p class="text-gray-500 dark:text-gray-400 mb-6">لم يتم العثور على أي تذاكر في النظام</p>
        </div>

      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { ref, onMounted } from 'vue'

const ticketsData = ref({
  stats: { totalTickets: 0, reservedTickets: 0, availableTickets: 0, totalRevenue: 0 },
  tickets: { data: [] },
  events: []
})

// جلب البيانات من الـ API
const fetchTickets = async () => {
  try {
    const response = await fetch('/api/v1/tickets')
    const data = await response.json()
    
    if (data.success) {
      ticketsData.value = data
    }
  } catch (error) {
    console.error('Error fetching tickets:', error)
  }
}

onMounted(() => {
  fetchTickets()
})
</script>