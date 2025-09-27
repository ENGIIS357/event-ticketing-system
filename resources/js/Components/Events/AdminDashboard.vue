<template>
  <div :class="darkMode ? 'dark' : ''" class="flex h-screen transition-colors duration-300" dir="rtl">
    <!-- Sidebar Desktop -->
    <aside class="bg-gradient-to-b from-blue-800 to-purple-900 text-white w-64 p-4 hidden md:flex flex-col shadow-2xl">
      <div class="text-center mb-8">
        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
          <span class="text-2xl">🎪</span>
        </div>
        <h2 class="text-xl font-bold">EventHub Pro</h2>
        <p class="text-blue-200 text-sm">نظام إدارة الفعاليات</p>
      </div>
      
      <nav class="flex flex-col gap-2 flex-1">
        <button @click="navigateTo('/dashboard')" 
                :class="activeTab === 'dashboard' ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10'"
                class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group">
          <span class="text-xl">📊</span>
          <span class="flex-1 text-right">لوحة التحكم</span>
          <div class="w-2 h-2 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </button>
        
        <button @click="navigateTo('/events')" 
                :class="activeTab === 'events' ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10'"
                class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group">
          <span class="text-xl">🎪</span>
          <span class="flex-1 text-right">إدارة الفعاليات</span>
          <div class="w-2 h-2 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </button>
        
        <button @click="navigateTo('/tickets')" 
                :class="activeTab === 'tickets' ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10'"
                class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group">
          <span class="text-xl">🎫</span>
          <span class="flex-1 text-right">التذاكر والحجوزات</span>
          <div class="w-2 h-2 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </button>
        
        <button @click="navigateTo('/users')" 
                :class="activeTab === 'users' ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10'"
                class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group">
          <span class="text-xl">👥</span>
          <span class="flex-1 text-right">إدارة المستخدمين</span>
          <div class="w-2 h-2 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </button>

        <button @click="navigateTo('/reports')" 
                :class="activeTab === 'reports' ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10'"
                class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 group">
          <span class="text-xl">📈</span>
          <span class="flex-1 text-right">التقارير والإحصائيات</span>
          <div class="w-2 h-2 bg-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </button>
      </nav>

      <div class="mt-auto space-y-3">
        <button @click="toggleDarkMode" 
                class="w-full bg-white/10 hover:bg-white/20 p-3 rounded-xl flex items-center gap-3 transition-all duration-300">
          <span class="text-xl">{{ darkMode ? '☀️' : '🌙' }}</span>
          <span class="flex-1 text-right">{{ darkMode ? 'الوضع النهاري' : 'الوضع الليلي' }}</span>
        </button>
        
        <button @click="logout" 
                class="w-full bg-red-500/20 hover:bg-red-500/30 text-red-200 p-3 rounded-xl flex items-center gap-3 transition-all duration-300">
          <span class="text-xl">🚪</span>
          <span class="flex-1 text-right">تسجيل الخروج</span>
        </button>
      </div>
    </aside>

    <!-- Mobile Header -->
    <header class="md:hidden fixed top-0 right-0 w-full bg-gradient-to-r from-blue-800 to-purple-900 text-white p-4 z-50 shadow-lg">
      <div class="flex justify-between items-center">
        <div class="flex items-center gap-3">
          <span class="text-2xl">🎪</span>
          <div>
            <h1 class="font-bold">EventHub</h1>
            <p class="text-blue-200 text-xs">لوحة التحكم</p>
          </div>
        </div>
        
        <div class="flex items-center gap-2">
          <button @click="toggleDarkMode" class="p-2 rounded-full bg-white/10">
            {{ darkMode ? '☀️' : '🌙' }}
          </button>
          <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-full bg-white/10">
            ☰
          </button>
        </div>
      </div>
    </header>

    <!-- Mobile Menu -->
    <div v-if="mobileMenu" class="md:hidden fixed top-16 right-0 w-full bg-gradient-to-b from-blue-800 to-purple-900 text-white z-40 shadow-2xl">
      <nav class="p-4 space-y-2">
        <button @click="navigateTo('/dashboard')" class="w-full text-right p-3 hover:bg-white/10 rounded-xl transition-colors">
          📊 لوحة التحكم
        </button>
        <button @click="navigateTo('/events')" class="w-full text-right p-3 hover:bg-white/10 rounded-xl transition-colors">
          🎪 إدارة الفعاليات
        </button>
        <button @click="navigateTo('/tickets')" class="w-full text-right p-3 hover:bg-white/10 rounded-xl transition-colors">
          🎫 التذاكر والحجوزات
        </button>
        <button @click="navigateTo('/users')" class="w-full text-right p-3 hover:bg-white/10 rounded-xl transition-colors">
          👥 إدارة المستخدمين
        </button>
        <button @click="navigateTo('/reports')" class="w-full text-right p-3 hover:bg-white/10 rounded-xl transition-colors">
          📈 التقارير والإحصائيات
        </button>
        <button @click="logout" class="w-full text-right p-3 hover:bg-red-500/20 text-red-200 rounded-xl transition-colors">
          🚪 تسجيل الخروج
        </button>
      </nav>
    </div>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto bg-gradient-to-br from-blue-50 to-purple-100 dark:from-gray-900 dark:to-blue-900 transition-colors duration-300 mt-16 md:mt-0">
      
      <!-- Welcome Header -->
      <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 mb-6 shadow-lg">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
              مرحباً بك، {{ user.name }}! 👋
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
              {{ getGreeting() }} - لديك {{ stats.upcomingEvents }} فعالية قادمة هذا الأسبوع
            </p>
          </div>
          <div class="flex items-center gap-3 mt-4 md:mt-0">
            <div class="text-right">
              <p class="text-sm text-gray-500 dark:text-gray-400">الدور: {{ user.role }}</p>
              <p class="text-xs text-gray-400 dark:text-gray-500">آخر دخول: {{ user.last_login }}</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
              {{ getUserInitials() }}
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Overview -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-blue-500">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-gray-500 dark:text-gray-400 text-sm">إجمالي الفعاليات</p>
              <h3 class="text-1xl font-bold text-gray-800 dark:text-white">{{ stats.totalEvents }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
              <span class="text-2xl text-blue-600 dark:text-blue-400">🎪</span>
            </div>
          </div>
          <p class="text-green-500 text-sm mt-2">↑ 12% عن الشهر الماضي</p>
        </div>

        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-500">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-gray-500 dark:text-gray-400 text-sm">التذاكر المباعة</p>
              <h3 class="text-1xl font-bold text-gray-800 dark:text-white">{{ stats.totalTickets }}</h3>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center">
              <span class="text-2xl text-green-600 dark:text-green-400">🎫</span>
            </div>
          </div>
          <p class="text-green-500 text-sm mt-2">↑ 8% عن الأسبوع الماضي</p>
        </div>

        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-purple-500">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-gray-500 dark:text-gray-400 text-sm">إجمالي الإيرادات</p>
              <h3 class="text-1xl font-bold text-gray-800 dark:text-white">{{ formatCurrency(stats.totalRevenue) }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center">
              <span class="text-2xl text-purple-600 dark:text-purple-400">💵</span>
            </div>
          </div>
          <p class="text-green-500 text-sm mt-2">↑ 15% عن الشهر الماضي</p>
        </div>

        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-orange-500">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-gray-500 dark:text-gray-400 text-sm">معدل الإشغال</p>
              <h3 class="text-1xl font-bold text-gray-800 dark:text-white">{{ stats.occupancyRate }}%</h3>
            </div>
            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-xl flex items-center justify-center">
              <span class="text-2xl text-orange-600 dark:text-orange-400">📊</span>
            </div>
          </div>
          <p class="text-green-500 text-sm mt-2">↑ 5% عن الأسبوع الماضي</p>
        </div>
      </div>

      <!-- Quick Actions & Charts -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="lg:col-span-1 space-y-4">
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">إجراءات سريعة ⚡</h3>
            <div class="space-y-3">
              <button @click="navigateTo('/events/create')" 
                      class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white p-3 rounded-xl flex items-center gap-3 hover:from-blue-600 hover:to-purple-700 transition-all duration-300">
                <span>➕</span>
                <span>إضافة فعالية جديدة</span>
              </button>
              <button @click="navigateTo('/tickets/create')" 
                      class="w-full bg-gradient-to-r from-green-500 to-teal-600 text-white p-3 rounded-xl flex items-center gap-3 hover:from-green-600 hover:to-teal-700 transition-all duration-300">
                <span>🎫</span>
                <span>إنشاء تذاكر جديدة</span>
              </button>
              <button @click="navigateTo('/reports')" 
                      class="w-full bg-gradient-to-r from-purple-500 to-pink-600 text-white p-3 rounded-xl flex items-center gap-3 hover:from-purple-600 hover:to-pink-700 transition-all duration-300">
                <span>📈</span>
                <span>عرض التقارير</span>
              </button>
            </div>
          </div>

          <!-- File Upload -->
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">رفع ملفات 📁</h3>
            <div @click="triggerFileUpload" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center cursor-pointer hover:border-blue-500 transition-colors">
              <span class="text-4xl">📁</span>
              <p class="mt-2 text-gray-600 dark:text-gray-400">انقر لرفع صورة أو ملف</p>
              <input type="file" ref="fileInput" @change="handleFileUpload" class="hidden" accept="image/*,.pdf,.doc,.docx">
            </div>
          </div>
        </div>

        <!-- Charts Section -->
        <div class="lg:col-span-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">الإحصائيات والرسوم البيانية 📊</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
              <h4 class="font-medium text-gray-800 dark:text-white mb-3">توزيع الفعاليات</h4>
              <div class="h-48">
                <canvas ref="eventsChart"></canvas>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
              <h4 class="font-medium text-gray-800 dark:text-white mb-3">الإيرادات الشهرية</h4>
              <div class="h-48">
                <canvas ref="revenueChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity & Upcoming Events -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">النشاط الأخير 🔔</h3>
            <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs px-2 py-1 rounded-full">
              {{ recentActivities.length }} نشاط
            </span>
          </div>
          <div class="space-y-3">
            <div v-for="activity in recentActivities" :key="activity.id" 
                 class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
              <span class="text-2xl">{{ activity.icon }}</span>
              <div class="flex-1">
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ activity.message }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ activity.time }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">الفعاليات القادمة 🗓️</h3>
            <button @click="navigateTo('/events')" 
                    class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-medium">
              عرض الكل
            </button>
          </div>
          <div class="space-y-3">
            <div v-for="event in upcomingEvents" :key="event.id" 
                 @click="navigateTo('/events/' + event.id)"
                 class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600/50 transition-colors">
              <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                <span class="text-white text-lg">🎪</span>
              </div>
              <div class="flex-1">
                <p class="font-medium text-gray-800 dark:text-white">{{ event.title }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                  {{ formatDate(event.start_date) }} • {{ event.location }}
                </p>
              </div>
              <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs px-2 py-1 rounded-full">
                {{ event.tickets_sold }}/{{ event.total_tickets }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- File Input (hidden) -->
    <input type="file" ref="fileInput" @change="handleFileUpload" class="hidden">
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue'

export default {
  name: 'Dashboard',
  setup() {
    // Refs
    const darkMode = ref(false)
    const mobileMenu = ref(false)
    const activeTab = ref('dashboard')
    const fileInput = ref(null)
    
    // User Data
    const user = ref({
      name: 'أحمد محمد',
      role: 'مدير النظام',
      last_login: 'قبل ساعتين',
      email: 'ahmed@example.com'
    })

    // Statistics
    const stats = ref({
      totalEvents: 24,
      totalTickets: 1560,
      totalRevenue: 125400,
      occupancyRate: 78,
      upcomingEvents: 3
    })

    // Sample Data
    const recentActivities = ref([
      { id: 1, icon: '🎫', message: 'تم بيع 5 تذاكر لفعالية الحفل الموسيقي', time: 'قبل 5 دقائق' },
      { id: 2, icon: '➕', message: 'تم إضافة فعالية جديدة: معرض الفنون', time: 'قبل ساعة' },
      { id: 3, icon: '👥', message: 'مستخدم جديد انضم إلى النظام', time: 'قبل ساعتين' },
      { id: 4, icon: '📧', message: 'تم إرسال إشعارات للفعالية القادمة', time: 'قبل 3 ساعات' }
    ])

    const upcomingEvents = ref([
      { id: 1, title: 'حفل موسيقي راقي', start_date: '2024-02-15', location: 'قاعة المؤتمرات', tickets_sold: 45, total_tickets: 100 },
      { id: 2, title: 'ندوة التكنولوجيا', start_date: '2024-02-18', location: 'المركز الثقافي', tickets_sold: 78, total_tickets: 150 },
      { id: 3, title: 'معرض الفنون', start_date: '2024-02-20', location: 'صالة المعارض', tickets_sold: 23, total_tickets: 80 }
    ])

    // Computed
    const greeting = computed(() => {
      const hour = new Date().getHours()
      if (hour < 12) return 'صباح الخير'
      if (hour < 18) return 'مساء الخير'
      return 'مساء الخير'
    })

    // Methods
    const navigateTo = (path) => {
      activeTab.value = path.split('/')[1] || 'dashboard'
      mobileMenu.value = false
      
      // استخدام Inertia.js للتنقل إذا كان متاحاً
      if (window.Inertia) {
        window.Inertia.visit(path)
      } else {
        // التنقل العادي كحل بديل
        window.location.href = path
      }
    }

    const toggleDarkMode = () => {
      darkMode.value = !darkMode.value
      localStorage.setItem('darkMode', darkMode.value)
    }

    const triggerFileUpload = () => {
      fileInput.value.click()
    }

    const handleFileUpload = (event) => {
      const file = event.target.files[0]
      if (file) {
        // هنا يمكنك إضافة رفع الملف إلى الخادم
        console.log('File selected:', file.name)
        // إضافة نشاط جديد
        recentActivities.value.unshift({
          id: Date.now(),
          icon: '📁',
          message: `تم رفع الملف: ${file.name}`,
          time: 'الآن'
        })
      }
    }

    const logout = () => {
      if (confirm('هل تريد تسجيل الخروج؟')) {
        // تسجيل الخروج عبر Laravel
        fetch('/logout', { method: 'POST' })
          .then(() => window.location.href = '/')
          .catch(() => window.location.href = '/')
      }
    }

    const getGreeting = () => {
      const hour = new Date().getHours()
      if (hour < 12) return 'صباح الخير! 🌅'
      if (hour < 18) return 'مساء الخير! ☀️'
      return 'مساء الخير! 🌙'
    }

    const getUserInitials = () => {
      return user.value.name.split(' ').map(n => n[0]).join('').toUpperCase()
    }

    const formatCurrency = (amount) => {
      return new Intl.NumberFormat('ar-SA', {
        style: 'currency',
        currency: 'SAR'
      }).format(amount)
    }

    const formatDate = (dateString) => {
      return new Date(dateString).toLocaleDateString('ar-SA', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }

    // Initialize Charts
    const initializeCharts = () => {
      // سوف نضيف الرسوم البيانية هنا لاحقاً
      console.log('Charts initialized')
    }

    // Fetch Data from API
    const fetchDashboardData = async () => {
      try {
        const response = await fetch('/api/v1/dashboard')
        if (response.ok) {
          const data = await response.json()
          // تحديث البيانات من الخادم
          stats.value = data.stats
          upcomingEvents.value = data.upcomingEvents
          recentActivities.value = data.recentActivities
        }
      } catch (error) {
        console.error('Error fetching dashboard data:', error)
      }
    }

    // Lifecycle
    onMounted(() => {
      darkMode.value = localStorage.getItem('darkMode') === 'true'
      fetchDashboardData()
      initializeCharts()
    })

    return {
      darkMode,
      mobileMenu,
      activeTab,
      user,
      stats,
      recentActivities,
      upcomingEvents,
      fileInput,
      navigateTo,
      toggleDarkMode,
      triggerFileUpload,
      handleFileUpload,
      logout,
      getGreeting,
      getUserInitials,
      formatCurrency,
      formatDate
    }
  }
}
</script>

<style scoped>
/* تحسينات التصميم */
.backdrop-blur-sm {
  backdrop-filter: blur(8px);
}

/* تأثيرات الظلال */
.shadow-2xl {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

/* تحسينات للوضع الداكن */
.dark .backdrop-blur-sm {
  background-color: rgba(17, 24, 39, 0.8);
}

/* تأثيرات hover محسنة */
.transition-all {
  transition: all 0.3s ease;
}

/* تحسينات للاستجابة */
@media (max-width: 768px) {
  .grid.grid-cols-1.lg\:grid-cols-3 {
    grid-template-columns: 1fr;
  }
  
  .grid.grid-cols-1.lg\:grid-cols-2 {
    grid-template-columns: 1fr;
  }
}

/* تحسينات النص للغة العربية */
[dir="rtl"] {
  text-align: right;
}

/* تحسينات الشريط الجانبي */
.bg-gradient-to-b {
  background: linear-gradient(to bottom, var(--tw-gradient-stops));
}

/* تأثيرات بصرية إضافية */
.hover\:scale-105:hover {
  transform: scale(1.05);
}

/* تحسينات للشعارات */
.text-2xl {
  font-size: 1.5rem;
  line-height: 2rem;
}

/* تحسينات للأزرار */
button {
  border: none;
  outline: none;
}

button:focus {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}
</style>