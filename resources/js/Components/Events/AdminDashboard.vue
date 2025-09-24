<template>
  <div :class="darkMode ? 'dark' : ''" class="flex h-screen transition-colors duration-300" dir="rtl">

    <!-- Sidebar Desktop -->
    <aside class="bg-gray-800 dark:bg-gray-900 text-white w-64 p-4 hidden md:flex flex-col">
      <h2 class="text-xl font-bold mb-6">إدارة الفعاليات 🎟️</h2>
      <nav class="flex flex-col gap-4 flex-1">
        <button @click="$router.push('/dashboard')" class="flex items-center gap-2 hover:bg-gray-700 p-2 rounded justify-end">
          لوحة التحكم <span class="material-icons">dashboard</span>
        </button>
        <button @click="$router.push('/events')" class="flex items-center gap-2 hover:bg-gray-700 p-2 rounded justify-end">
          الفعاليات <span class="material-icons">event</span>
        </button>
        <button @click="$router.push('/tickets')" class="flex items-center gap-2 hover:bg-gray-700 p-2 rounded justify-end">
          التذاكر <span class="material-icons">confirmation_number</span>
        </button>
        <button @click="$router.push('/users')" class="flex items-center gap-2 hover:bg-gray-700 p-2 rounded justify-end">
          المستخدمين <span class="material-icons">people</span>
        </button>
      </nav>
      <button @click="toggleDarkMode" class="mt-auto bg-gray-700 dark:bg-gray-800 hover:bg-gray-600 p-2 rounded flex justify-center">
        <span class="material-icons">{{ darkMode ? 'light_mode' : 'dark_mode' }}</span>
      </button>
    </aside>

    <!-- Topbar Mobile -->
    <div class="md:hidden fixed top-0 right-0 w-full flex justify-between items-center bg-gray-800 dark:bg-gray-900 p-3 z-50">
      <button @click="mobileMenu = !mobileMenu" class="text-white material-icons">menu</button>
      <button @click="toggleDarkMode" class="text-white material-icons">
        {{ darkMode ? 'light_mode' : 'dark_mode' }}
      </button>
    </div>

    <!-- Sidebar Mobile -->
    <transition name="slide">
      <aside v-if="mobileMenu" class="md:hidden fixed top-0 right-0 h-full w-20 bg-gray-800 dark:bg-gray-900 text-white p-2 z-40 flex flex-col items-center">
        <nav class="flex flex-col gap-6 mt-20 flex-1">
          <a @click="$router.push('/dashboard')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700">
            <span class="material-icons text-2xl">dashboard</span>
            <span class="tooltip">لوحة التحكم</span>
          </a>
          <a @click="$router.push('/events')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700">
            <span class="material-icons text-2xl">event</span>
            <span class="tooltip">الفعاليات</span>
          </a>
          <a @click="$router.push('/tickets')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700">
            <span class="material-icons text-2xl">confirmation_number</span>
            <span class="tooltip">التذاكر</span>
          </a>
          <a @click="$router.push('/users')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700">
            <span class="material-icons text-2xl">people</span>
            <span class="tooltip">المستخدمين</span>
          </a>
        </nav>
        <button @click="toggleDarkMode" class="p-2 rounded hover:bg-gray-700 flex justify-center mt-auto">
          <span class="material-icons">{{ darkMode ? 'light_mode' : 'dark_mode' }}</span>
        </button>
      </aside>
    </transition>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto bg-gray-100 dark:bg-gray-800 transition-colors duration-300 mt-12 md:mt-0">
      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 text-right">
        <div class="stat-card bg-white p-6 rounded-lg shadow-md text-center">
          <div class="text-3xl font-bold text-blue-600">{{ stats.totalEvents }}</div>
          <div class="text-gray-600">إجمالي الفعاليات</div>
        </div>
        <div class="stat-card bg-white p-6 rounded-lg shadow-md text-center">
          <div class="text-3xl font-bold text-green-600">{{ stats.activeEvents }}</div>
          <div class="text-gray-600">فعاليات نشطة</div>
        </div>
        <div class="stat-card bg-white p-6 rounded-lg shadow-md text-center">
          <div class="text-3xl font-bold text-purple-600">{{ stats.averagePrice }} ر.س</div>
          <div class="text-gray-600">متوسط الأسعار</div>
        </div>
      </div>

      <!-- Pie Chart -->
      <div class="w-full h-96">
        <canvas id="eventsChart" class="w-full h-full"></canvas>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick, watch } from 'vue'
import axios from 'axios'
import { Chart } from 'chart.js/auto'

const darkMode = ref(false)
const mobileMenu = ref(false)
const stats = ref({ totalEvents: 0, activeEvents: 0, averagePrice: 0 })
const chartInstance = ref(null)
let eventsData = []

const toggleDarkMode = () => {
  darkMode.value = !darkMode.value
  localStorage.setItem('darkMode', darkMode.value)
  renderChart(eventsData) // إعادة رسم المخطط لتغيير الألوان حسب الوضع
}

const fetchStats = async () => {
  try {
    const res = await axios.get('/api/v1/events')
    eventsData = res.data.events || res.data

    stats.value.totalEvents = eventsData.length
    stats.value.activeEvents = eventsData.filter(e => new Date(e.start_date) > new Date()).length
    stats.value.averagePrice = eventsData.length > 0 ?
      Math.round(eventsData.reduce((sum, e) => sum + e.price, 0) / eventsData.length) : 0

    await nextTick()
    renderChart(eventsData)
  } catch (err) {
    console.error(err)
  }
}

const renderChart = (events) => {
  const ctx = document.getElementById('eventsChart').getContext('2d')
  if(chartInstance.value) chartInstance.value.destroy()

  const colors = events.map(() => darkMode.value 
    ? `hsl(${Math.random()*360}, 50%, 40%)` 
    : `hsl(${Math.random()*360}, 70%, 60%)`
  )

  chartInstance.value = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: events.map(e => e.title),
      datasets: [{
        label: 'عدد التذاكر لكل فعالية',
        data: events.map(e => e.tickets_count || 0),
        backgroundColor: colors
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { 
          position: 'right', 
          labels: { color: darkMode.value ? '#fff' : '#000' } 
        }
      }
    }
  })
}

onMounted(() => {
  darkMode.value = localStorage.getItem('darkMode') === 'true'
  fetchStats()
})
</script>

<style>
.stat-card { transition: background 0.3s, color 0.3s; }
.dark .stat-card { background: #1f2937; color: #f9fafb; }

/* Sidebar Animation */
.slide-enter-active, .slide-leave-active { transition: transform 0.3s ease; }
.slide-enter-from, .slide-leave-to { transform: translateX(100%); }

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
</style>
