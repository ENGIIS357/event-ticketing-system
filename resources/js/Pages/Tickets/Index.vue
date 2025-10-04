<template>
  <AppLayout title="إدارة التذاكر" description="عرض وإدارة جميع التذاكر">
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- حالة التحميل -->
        <div v-if="loading" class="flex justify-center items-center py-12">
          <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-3"></div>
            <p class="text-gray-600 dark:text-gray-300">جاري تحميل التذاكر...</p>
          </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div v-else>
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
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">تاريخ الحجز</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                  <tr v-for="ticket in ticketsData.tickets.data" :key="ticket.id" 
                      class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-6 py-4">
                      <span class="font-mono text-sm bg-gray-100 dark:bg-gray-600 px-2 py-1 rounded">
                        {{ ticket.ticket_number }}
                      </span>
                    </td>
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-3 justify-end">
                        <div class="text-right">
                          <p class="font-medium text-gray-800 dark:text-white">
                            {{ ticket.event.title }}
                          </p>
                          <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ ticket.event.date }}
                          </p>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <p class="font-medium text-gray-800 dark:text-white">
                        {{ ticket.user.name }}
                      </p>
                      <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ ticket.user.email }}
                      </p>
                    </td>
                    <td class="px-6 py-4">
                      <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                        {{ getTypeText(ticket.type) }}
                      </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">
                      {{ ticket.price }} ر.س
                    </td>
                    <td class="px-6 py-4">
                      <span :class="`px-3 py-1 rounded-full text-xs font-medium ${
                        getStatusClass(ticket.status)
                      }`">
                        {{ getStatusText(ticket.status) }}
                      </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                      {{ ticket.booking_date }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>

      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/Applayout.vue'
import { ref, onMounted } from 'vue'

const loading = ref(true)
const ticketsData = ref({
  stats: { 
    totalTickets: 156, 
    reservedTickets: 89, 
    availableTickets: 67, 
    totalRevenue: 45800 
  },
  tickets: { 
    data: [
      {
        id: 1,
        ticket_number: "TKT-2024-001",
        event: {
          title: "مهرجان الرياض للثقافة",
          date: "2024-03-15"
        },
        user: {
          name: "أحمد محمد",
          email: "ahmed@example.com"
        },
        type: "vip",
        price: 350,
        status: "confirmed",
        booking_date: "2024-02-20"
      },
      {
        id: 2,
        ticket_number: "TKT-2024-002",
        event: {
          title: "حفلة نجوم الطرب",
          date: "2024-03-20"
        },
        user: {
          name: "فاطمة علي",
          email: "fatima@example.com"
        },
        type: "regular",
        price: 150,
        status: "reserved",
        booking_date: "2024-02-18"
      },
      {
        id: 3,
        ticket_number: "TKT-2024-003",
        event: {
          title: "معرض التقنية 2024",
          date: "2024-04-05"
        },
        user: {
          name: "خالد عبدالله",
          email: "khaled@example.com"
        },
        type: "premium",
        price: 500,
        status: "available",
        booking_date: "2024-02-25"
      },
      {
        id: 4,
        ticket_number: "TKT-2024-004",
        event: {
          title: "مؤتمر ريادة الأعمال",
          date: "2024-03-10"
        },
        user: {
          name: "سارة أحمد",
          email: "sara@example.com"
        },
        type: "regular",
        price: 200,
        status: "cancelled",
        booking_date: "2024-02-15"
      },
      {
        id: 5,
        ticket_number: "TKT-2024-005",
        event: {
          title: "مهرجان الرياض للثقافة",
          date: "2024-03-15"
        },
        user: {
          name: "محمد حسن",
          email: "mohammed@example.com"
        },
        type: "vip",
        price: 350,
        status: "pending",
        booking_date: "2024-02-22"
      },
      {
        id: 6,
        ticket_number: "TKT-2024-006",
        event: {
          title: "حفلة نجوم الطرب",
          date: "2024-03-20"
        },
        user: {
          name: "لينا فارس",
          email: "lina@example.com"
        },
        type: "regular",
        price: 150,
        status: "confirmed",
        booking_date: "2024-02-19"
      },
      {
        id: 7,
        ticket_number: "TKT-2024-007",
        event: {
          title: "معرض الكتاب الدولي",
          date: "2024-04-01"
        },
        user: {
          name: "يوسف كمال",
          email: "yousef@example.com"
        },
        type: "premium",
        price: 280,
        status: "reserved",
        booking_date: "2024-02-24"
      },
      {
        id: 8,
        ticket_number: "TKT-2024-008",
        event: {
          title: "مؤتمر ريادة الأعمال",
          date: "2024-03-10"
        },
        user: {
          name: "نورة سعد",
          email: "nora@example.com"
        },
        type: "regular",
        price: 200,
        status: "confirmed",
        booking_date: "2024-02-16"
      }
    ]
  }
})

// دوال المساعدة
const getTypeText = (type) => {
  const types = {
    'regular': 'عادي',
    'vip': 'VIP',
    'premium': 'مميز'
  }
  return types[type] || type
}

const getStatusText = (status) => {
  const statuses = {
    'available': 'متاحة',
    'reserved': 'محجوزة',
    'confirmed': 'مؤكدة',
    'cancelled': 'ملغاة',
    'pending': 'قيد الانتظار'
  }
  return statuses[status] || status
}

const getStatusClass = (status) => {
  const classes = {
    'available': 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
    'reserved': 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
    'confirmed': 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
    'cancelled': 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
    'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'
  }
  return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300'
}

// محاكاة جلب البيانات من API
const fetchTickets = async () => {
  try {
    loading.value = true
    // محاكاة انتظار الشبكة
    await new Promise(resolve => setTimeout(resolve, 1000))
  } catch (error) {
    console.error('Error fetching tickets:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchTickets()
})
</script>