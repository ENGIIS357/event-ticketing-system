<template>
  <div :class="darkMode ? 'dark' : ''" class="flex h-screen transition-colors duration-300" dir="rtl">

    <!-- Sidebar Desktop -->
    <aside class="bg-gray-800 dark:bg-gray-900 text-white w-64 p-4 hidden md:flex flex-col">
      <h2 class="text-xl font-bold mb-6">إدارة الفعاليات 🎟️</h2>
      <nav class="flex flex-col gap-4 flex-1">
        <button @click="navigateTo('/dashboard')" class="flex items-center gap-2 hover:bg-gray-700 p-2 rounded justify-end">
          لوحة التحكم <span>📊</span>
        </button>
        <button @click="navigateTo('/events')" class="flex items-center gap-2 hover:bg-gray-700 p-2 rounded justify-end">
          الفعاليات <span>🎪</span>
        </button>
        <button @click="navigateTo('/tickets')" class="flex items-center gap-2 hover:bg-gray-700 p-2 rounded justify-end">
          التذاكر <span>🎫</span>
        </button>
        <button @click="navigateTo('/users')" class="flex items-center gap-2 hover:bg-gray-700 p-2 rounded justify-end">
          المستخدمين <span>👥</span>
        </button>
      </nav>
      <button @click="toggleDarkMode" class="mt-auto bg-gray-700 dark:bg-gray-800 hover:bg-gray-600 p-2 rounded flex justify-center">
        <span>{{ darkMode ? '☀️' : '🌙' }}</span>
      </button>
    </aside>

    <!-- Topbar Mobile -->
    <div class="md:hidden fixed top-0 right-0 w-full flex justify-between items-center bg-gray-800 dark:bg-gray-900 p-3 z-50">
      <button @click="mobileMenu = !mobileMenu" class="text-white">☰</button>
      <button @click="toggleDarkMode" class="text-white">
        {{ darkMode ? '☀️' : '🌙' }}
      </button>
    </div>

    <!-- Sidebar Mobile -->
    <transition name="slide">
      <aside v-if="mobileMenu" class="md:hidden fixed top-0 right-0 h-full w-20 bg-gray-800 dark:bg-gray-900 text-white p-2 z-40 flex flex-col items-center">
        <nav class="flex flex-col gap-6 mt-20 flex-1">
          <a @click="navigateTo('/dashboard')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700 cursor-pointer">
            <span class="text-2xl">📊</span>
            <span class="tooltip">لوحة التحكم</span>
          </a>
          <a @click="navigateTo('/events')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700 cursor-pointer">
            <span class="text-2xl">🎪</span>
            <span class="tooltip">الفعاليات</span>
          </a>
          <a @click="navigateTo('/tickets')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700 cursor-pointer">
            <span class="text-2xl">🎫</span>
            <span class="tooltip">التذاكر</span>
          </a>
          <a @click="navigateTo('/users')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700 cursor-pointer">
            <span class="text-2xl">👥</span>
            <span class="tooltip">المستخدمين</span>
          </a>
        </nav>
        <button @click="toggleDarkMode" class="p-2 rounded hover:bg-gray-700 flex justify-center mt-auto">
          <span>{{ darkMode ? '☀️' : '🌙' }}</span>
        </button>
      </aside>
    </transition>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto bg-gray-100 dark:bg-gray-800 transition-colors duration-300 mt-12 md:mt-0">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 text-right">
        <div class="stat-card bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md text-center">
          <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ stats.totalEvents }}</div>
          <div class="text-gray-600 dark:text-gray-300">إجمالي الفعاليات</div>
        </div>
        <div class="stat-card bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md text-center">
          <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ stats.activeEvents }}</div>
          <div class="text-gray-600 dark:text-gray-300">فعاليات نشطة</div>
        </div>
        <div class="stat-card bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md text-center">
          <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ stats.averagePrice }} ر.س</div>
          <div class="text-gray-600 dark:text-gray-300">متوسط الأسعار</div>
        </div>
      </div>

      <!-- Pie Chart -->
      <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white text-right">توزيع الفعاليات</h3>
        <div class="w-full h-96">
          <canvas id="eventsChart" class="w-full h-full"></canvas>
        </div>
      </div>

      <!-- Recent Events Table -->
      <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md mt-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white text-right">أحدث الفعاليات</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-right">
            <thead>
              <tr class="bg-gray-50 dark:bg-gray-600">
                <th class="px-4 py-3 text-gray-600 dark:text-gray-300">اسم الفعالية</th>
                <th class="px-4 py-3 text-gray-600 dark:text-gray-300">التاريخ</th>
                <th class="px-4 py-3 text-gray-600 dark:text-gray-300">المكان</th>
                <th class="px-4 py-3 text-gray-600 dark:text-gray-300">السعر</th>
                <th class="px-4 py-3 text-gray-600 dark:text-gray-300">الحالة</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="event in recentEvents" :key="event.id" class="border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-4 py-3 text-gray-800 dark:text-gray-200">{{ event.title }}</td>
                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ formatDate(event.start_date) }}</td>
                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ event.location }}</td>
                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ event.price }} ر.س</td>
                <td class="px-4 py-3">
                  <span :class="`px-2 py-1 rounded-full text-xs ${
                    new Date(event.start_date) > new Date() 
                      ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' 
                      : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300'
                  }`">
                    {{ new Date(event.start_date) > new Date() ? 'قادمة' : 'منتهية' }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import { router } from '@inertiajs/vue3' // ✅ استيراد router من Inertia
import { Chart } from 'chart.js/auto'

const darkMode = ref(false)
const mobileMenu = ref(false)
const stats = ref({ 
  totalEvents: 0, 
  activeEvents: 0, 
  averagePrice: 0 
})
const recentEvents = ref([])
const chartInstance = ref(null)

// ✅ دالة التنقل باستخدام Inertia router
const navigateTo = (path) => {
  router.visit(path)
  mobileMenu.value = false // إغلاق القائمة على الجوال بعد التنقل
}

const toggleDarkMode = () => {
  darkMode.value = !darkMode.value
  localStorage.setItem('darkMode', darkMode.value)
  if (chartInstance.value) {
    renderChart(recentEvents.value)
  }
}

const fetchStats = async () => {
  try {
    const response = await fetch('/api/v1/events')
    const data = await response.json()
    const events = data.events || data || []

    // الإحصائيات
    stats.value.totalEvents = events.length
    stats.value.activeEvents = events.filter(e => new Date(e.start_date) > new Date()).length
    stats.value.averagePrice = events.length > 0 
      ? Math.round(events.reduce((sum, e) => sum + (e.price || 0), 0) / events.length) 
      : 0

    // أحدث الفعاليات
    recentEvents.value = events.slice(0, 5)

    await nextTick()
    renderChart(events)
  } catch (error) {
    console.error('Error fetching stats:', error)
  }
}

const renderChart = (events) => {
  const ctx = document.getElementById('eventsChart')
  if (!ctx) return

  if (chartInstance.value) {
    chartInstance.value.destroy()
  }

  // تجهيز البيانات للمخطط
  const eventTitles = events.map(e => e.title.substring(0, 20) + (e.title.length > 20 ? '...' : ''))
  const ticketCounts = events.map(e => e.available_tickets || e.tickets_count || 1)

  chartInstance.value = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: eventTitles,
      datasets: [{
        data: ticketCounts,
        backgroundColor: [
          '#3B82F6', '#10B981', '#EF4444', '#F59E0B', '#8B5CF6',
          '#EC4899', '#06B6D4', '#84CC16', '#F97316', '#6366F1'
        ],
        borderWidth: 2,
        borderColor: darkMode.value ? '#1F2937' : '#FFFFFF'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: darkMode.value ? '#F9FAFB' : '#374151',
            font: {
              size: 12
            }
          }
        },
        title: {
          display: true,
          text: 'توزيع التذاكر المتاحة للفعاليات',
          color: darkMode.value ? '#F9FAFB' : '#374151',
          font: {
            size: 16
          }
        }
      }
    }
  })
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('ar-SA', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

onMounted(() => {
  darkMode.value = localStorage.getItem('darkMode') === 'true'
  fetchStats()
})
</script>

<style scoped>
.stat-card { 
  transition: transform 0.2s ease, box-shadow 0.2s ease; 
}
.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.dark .stat-card:hover {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

/* Sidebar Animation */
.slide-enter-active, .slide-leave-active { 
  transition: transform 0.3s ease; 
}
.slide-enter-from, .slide-leave-to { 
  transform: translateX(100%); 
}

/* Tooltip */
.tooltip {
  position: absolute;
  right: -9999px;
  top: 50%;
  transform: translateY(-50%);
  background-color: #111;
  color: white;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
  white-space: nowrap;
  opacity: 0;
  transition: opacity 0.2s;
  pointer-events: none;
  font-size: 0.75rem;
}
.group:hover .tooltip {
  right: 100%;
  opacity: 1;
}

/* تحسينات للوضع الداكن */
.dark .bg-white {
  background-color: #1F2937;
}
.dark .text-gray-800 {
  color: #F9FAFB;
}
.dark .text-gray-600 {
  color: #D1D5DB;
}
</style>