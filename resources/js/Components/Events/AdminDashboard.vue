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
    <div v-if="mobileMenu" class="md:hidden fixed top-0 right-0 h-full w-20 bg-gray-800 dark:bg-gray-900 text-white p-2 z-40 flex flex-col items-center">
      <nav class="flex flex-col gap-6 mt-20 flex-1">
        <button @click="navigateTo('/dashboard')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700 cursor-pointer">
          <span class="text-2xl">📊</span>
          <span class="absolute left-full ml-2 bg-black text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">لوحة التحكم</span>
        </button>
        <button @click="navigateTo('/events')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700 cursor-pointer">
          <span class="text-2xl">🎪</span>
          <span class="absolute left-full ml-2 bg-black text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">الفعاليات</span>
        </button>
        <button @click="navigateTo('/tickets')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700 cursor-pointer">
          <span class="text-2xl">🎫</span>
          <span class="absolute left-full ml-2 bg-black text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">التذاكر</span>
        </button>
        <button @click="navigateTo('/users')" class="relative group flex flex-col items-center p-2 rounded hover:bg-gray-700 cursor-pointer">
          <span class="text-2xl">👥</span>
          <span class="absolute left-full ml-2 bg-black text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">المستخدمين</span>
        </button>
      </nav>
      <button @click="toggleDarkMode" class="p-2 rounded hover:bg-gray-700 flex justify-center mt-auto">
        <span>{{ darkMode ? '☀️' : '🌙' }}</span>
      </button>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto bg-gray-100 dark:bg-gray-800 transition-colors duration-300 mt-12 md:mt-0">
      
      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center h-64">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
      </div>

      <!-- Content when not loading -->
      <div v-else>
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

        <!-- Quick Actions Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
          <!-- رفع الصور -->
          <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white text-right">رفع صورة فعالية</h3>
            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4 text-center">
              <input type="file" @change="handleImageUpload" accept="image/*" class="hidden" id="imageUpload">
              <label for="imageUpload" class="cursor-pointer block">
                <span class="text-4xl">📁</span>
                <p class="mt-2 text-gray-600 dark:text-gray-400">اسحب وأفلت الصورة أو انقر للاختيار</p>
              </label>
            </div>
            <div v-if="uploadedImage" class="mt-4">
              <img :src="uploadedImage" class="w-32 h-32 object-cover rounded-lg mx-auto">
            </div>
          </div>

          <!-- إضافة فعالية سريعة -->
          <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white text-right">إضافة فعالية سريعة</h3>
            <form @submit.prevent="addQuickEvent" class="space-y-3">
              <input v-model="quickEvent.title" type="text" placeholder="اسم الفعالية" 
                     class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-600 dark:text-white">
              <input v-model="quickEvent.date" type="date" 
                     class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-600 dark:text-white">
              <button type="submit" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700 transition-colors">
                إضافة سريعة
              </button>
            </form>
          </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow-md mb-6">
          <div class="flex flex-col md:flex-row gap-4 items-center">
            <!-- بحث -->
            <div class="flex-1">
              <input v-model="searchQuery" type="text" placeholder="ابحث في الفعاليات..." 
                     class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-600 dark:text-white">
            </div>
            
            <!-- تصفية -->
            <select v-model="filterStatus" class="p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-600 dark:text-white">
              <option value="all">جميع الفعاليات</option>
              <option value="active">فعاليات قادمة</option>
              <option value="past">فعاليات منتهية</option>
            </select>
            
            <!-- ترتيب -->
            <select v-model="sortBy" class="p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-600 dark:text-white">
              <option value="newest">الأحدث أولاً</option>
              <option value="oldest">الأقدم أولاً</option>
              <option value="price-high">الأعلى سعراً</option>
              <option value="price-low">الأقل سعراً</option>
            </select>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md mb-6">
          <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white text-right">توزيع الفعاليات</h3>
          <div class="w-full h-96">
            <canvas id="eventsChart" class="w-full h-full"></canvas>
          </div>
        </div>

        <!-- Recent Events Table -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md">
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
                <tr v-for="event in filteredEvents" :key="event.id" class="border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
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
                <tr v-if="filteredEvents.length === 0">
                  <td colspan="5" class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">
                    لا توجد فعاليات لعرضها
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { ref, onMounted, nextTick, computed } from 'vue'

export default {
  name: 'Dashboard',
  setup() {
    // Refs
    const darkMode = ref(false)
    const mobileMenu = ref(false)
    const loading = ref(true)
    const stats = ref({ 
      totalEvents: 0, 
      activeEvents: 0, 
      averagePrice: 0 
    })
    const recentEvents = ref([])
    const chartInstance = ref(null)
    const uploadedImage = ref(null)
    const quickEvent = ref({
      title: '',
      date: ''
    })
    const searchQuery = ref('')
    const filterStatus = ref('all')
    const sortBy = ref('newest')

    // Computed
    const filteredEvents = computed(() => {
      try {
        let events = recentEvents.value.filter(event => {
          if (!event) return false
          const title = event.title ? event.title.toLowerCase() : ''
          const location = event.location ? event.location.toLowerCase() : ''
          const query = searchQuery.value.toLowerCase()
          return title.includes(query) || location.includes(query)
        })

        // التصفية حسب الحالة
        if (filterStatus.value === 'active') {
          events = events.filter(event => new Date(event.start_date) > new Date())
        } else if (filterStatus.value === 'past') {
          events = events.filter(event => new Date(event.start_date) <= new Date())
        }

        // الترتيب
        switch (sortBy.value) {
          case 'newest':
            events.sort((a, b) => new Date(b.start_date) - new Date(a.start_date))
            break
          case 'oldest':
            events.sort((a, b) => new Date(a.start_date) - new Date(b.start_date))
            break
          case 'price-high':
            events.sort((a, b) => (b.price || 0) - (a.price || 0))
            break
          case 'price-low':
            events.sort((a, b) => (a.price || 0) - (b.price || 0))
            break
        }

        return events
      } catch (error) {
        console.error('Error filtering events:', error)
        return []
      }
    })

    // Methods
    const navigateTo = (path) => {
      try {
        if (window.router) {
          window.router.visit(path)
        } else {
          window.location.href = path
        }
        mobileMenu.value = false
      } catch (error) {
        console.error('Navigation error:', error)
        window.location.href = path
      }
    }

    const toggleDarkMode = () => {
      darkMode.value = !darkMode.value
      localStorage.setItem('darkMode', darkMode.value)
      if (chartInstance.value) {
        renderChart(recentEvents.value)
      }
    }

    const handleImageUpload = (event) => {
      try {
        const file = event.target.files[0]
        if (file && file.type.startsWith('image/')) {
          const reader = new FileReader()
          reader.onload = (e) => {
            uploadedImage.value = e.target.result
            showToast('نجاح', 'تم رفع الصورة بنجاح!', 'success')
          }
          reader.onerror = () => {
            showToast('خطأ', 'فشل في قراءة الصورة', 'error')
          }
          reader.readAsDataURL(file)
        } else {
          showToast('خطأ', 'يرجى اختيار صورة صالحة', 'error')
        }
      } catch (error) {
        console.error('Image upload error:', error)
        showToast('خطأ', 'فشل في رفع الصورة', 'error')
      }
    }

    const addQuickEvent = async () => {
      try {
        if (!quickEvent.value.title || !quickEvent.value.date) {
          showToast('خطأ', 'يرجى ملء جميع الحقول', 'error')
          return
        }

        // محاكاة API call
        await new Promise(resolve => setTimeout(resolve, 1000))
        
        showToast('نجاح', 'تم إضافة الفعالية بنجاح!', 'success')
        quickEvent.value = { title: '', date: '' }
        
        // إعادة تحميل البيانات
        await fetchStats()
      } catch (error) {
        console.error('Error adding event:', error)
        showToast('خطأ', 'فشل في إضافة الفعالية', 'error')
      }
    }

    const fetchStats = async () => {
      try {
        loading.value = true
        
        // محاكاة API call مع بيانات تجريبية
        await new Promise(resolve => setTimeout(resolve, 1000))
        
        // بيانات تجريبية للاختبار
        const mockEvents = [
          {
            id: 1,
            title: 'حفل موسيقي',
            start_date: '2024-02-15',
            location: 'الرياض',
            price: 150,
            available_tickets: 100
          },
          {
            id: 2,
            title: 'ندوة تقنية',
            start_date: '2024-01-10',
            location: 'جدة',
            price: 200,
            available_tickets: 50
          },
          {
            id: 3,
            title: 'معرض فني',
            start_date: '2024-03-20',
            location: 'الدمام',
            price: 75,
            available_tickets: 200
          }
        ]

        const events = mockEvents

        // الإحصائيات
        stats.value.totalEvents = events.length
        stats.value.activeEvents = events.filter(e => new Date(e.start_date) > new Date()).length
        stats.value.averagePrice = events.length > 0 
          ? Math.round(events.reduce((sum, e) => sum + (e.price || 0), 0) / events.length) 
          : 0

        // أحدث الفعاليات
        recentEvents.value = events

        await nextTick()
        renderChart(events)
      } catch (error) {
        console.error('Error fetching stats:', error)
        showToast('خطأ', 'فشل في تحميل البيانات', 'error')
      } finally {
        loading.value = false
      }
    }

    const renderChart = (events) => {
      try {
        const ctx = document.getElementById('eventsChart')
        if (!ctx) {
          console.warn('Chart canvas not found')
          return
        }

        if (chartInstance.value) {
          chartInstance.value.destroy()
        }

        // استخدم Chart.js إذا كان متاحاً، وإلا لا تعرض المخطط
        if (typeof Chart === 'undefined') {
          console.warn('Chart.js not loaded')
          return
        }

        const eventTitles = events.map(e => e.title.substring(0, 15) + (e.title.length > 15 ? '...' : ''))
        const ticketCounts = events.map(e => e.available_tickets || 1)

        chartInstance.value = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: eventTitles,
            datasets: [{
              data: ticketCounts,
              backgroundColor: ['#3B82F6', '#10B981', '#EF4444', '#F59E0B'],
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
                  font: { size: 12 }
                }
              }
            }
          }
        })
      } catch (error) {
        console.error('Chart rendering error:', error)
      }
    }

    const formatDate = (dateString) => {
      try {
        return new Date(dateString).toLocaleDateString('ar-SA', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        })
      } catch (error) {
        return dateString
      }
    }

    const showToast = (title, message, type) => {
      // تنفيذ بسيط للإشعارات
      console.log(`${type}: ${title} - ${message}`)
    }

    // Lifecycle
    onMounted(() => {
      try {
        darkMode.value = localStorage.getItem('darkMode') === 'true'
        fetchStats()
      } catch (error) {
        console.error('Mount error:', error)
        loading.value = false
      }
    })

    return {
      darkMode,
      mobileMenu,
      loading,
      stats,
      recentEvents,
      uploadedImage,
      quickEvent,
      searchQuery,
      filterStatus,
      sortBy,
      filteredEvents,
      navigateTo,
      toggleDarkMode,
      handleImageUpload,
      addQuickEvent,
      formatDate
    }
  }
}
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

/* تحسينات للاستجابة */
@media (max-width: 768px) {
  .grid.grid-cols-1.md\:grid-cols-2 {
    grid-template-columns: 1fr;
  }
}

/* تحسينات عامة */
.transition-colors {
  transition: background-color 0.3s ease, color 0.3s ease;
}
</style>