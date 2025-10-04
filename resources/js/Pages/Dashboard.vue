<template>
  <Head title="لوحة التحكم" />

  <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
    <!-- القائمة الجانبية (من اليمين) -->
    <aside class="hidden lg:block w-64 bg-white dark:bg-gray-800 shadow-lg border-l border-gray-200 dark:border-gray-700 order-2">
      <!-- اللوجو -->
      <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
          <div class="text-right flex-1">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">EventHub</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300">نظام الفعاليات</p>
          </div>
          <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
            <span class="text-white">🎪</span>
          </div>
        </div>
      </div>

      <!-- قائمة التنقل -->
      <nav class="p-4 space-y-2">
        <Link 
          :href="route('dashboard')"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[$page.url === '/dashboard' ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <span class="text-lg">📊</span>
          <span class="flex-1 text-right">لوحة التحكم</span>
        </Link>

        <Link 
          :href="route('events.index')"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[$page.url.startsWith('/events') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <span class="text-lg">🎪</span>
          <span class="flex-1 text-right">إدارة الفعاليات</span>
        </Link>

        <Link 
          :href="route('tickets.index')"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[$page.url.startsWith('/tickets') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <span class="text-lg">🎫</span>
          <span class="flex-1 text-right">إدارة التذاكر</span>
        </Link>

        <Link 
          :href="route('users.index')"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[$page.url.startsWith('/users') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <span class="text-lg">👥</span>
          <span class="flex-1 text-right">إدارة المستخدمين</span>
        </Link>

        <!-- قسم الإعدادات -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
          <Link 
            :href="route('profile.edit')"
            class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
          >
            <span class="text-lg">⚙️</span>
            <span class="flex-1 text-right">الإعدادات</span>
          </Link>

          <form @submit.prevent="logout" class="w-full">
            <button type="submit" class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 w-full text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
              <span class="text-lg">🚪</span>
              <span class="flex-1 text-right">تسجيل خروج</span>
            </button>
          </form>
        </div>
      </nav>

      <!-- معلومات المستخدم في الأسفل -->
      <div class="absolute bottom-0 right-0 left-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="flex items-center gap-3">
          <div class="flex-1 text-right">
            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ currentUser.name }}</p>
            <p class="text-xs text-gray-600 dark:text-gray-300">{{ currentUser.email }}</p>
          </div>
          <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center">
            <span class="text-white font-bold text-sm">{{ currentUserInitials }}</span>
          </div>
        </div>
      </div>
    </aside>

    <!-- المحتوى الرئيسي -->
    <div class="flex-1 flex flex-col overflow-hidden order-1">
      <!-- الهيدر المعدل (العنوان في اليمين، الأيقونات في اليسار) -->
      <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between p-4">
          <!-- الجانب الأيسر: الأيقونات -->
          <div class="flex items-center gap-4">
            <!-- زر إظهار/إخفاء القائمة (للجوال) -->
            <button @click="toggleMobileMenu" class="lg:hidden text-gray-600 dark:text-gray-300">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>

            <!-- الأيقونات (الإشعارات، الوضع الليلي) -->
            <div class="flex items-center gap-3">
              <!-- إشعارات -->
              <button class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg relative">
                <span class="text-lg">🔔</span>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
              </button>

              <!-- زر تبديل الوضع الليلي/النهاري -->
              <button @click="toggleDarkMode" class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <span class="text-lg">{{ isDarkMode ? '🌙' : '☀️' }}</span>
              </button>

              <!-- التاريخ -->
              <div class="text-left hidden sm:block">
                <span class="text-sm text-gray-500">{{ currentDate }}</span>
              </div>
            </div>
          </div>

          <!-- الجانب الأيمن: العنوان والوصف -->
          <div class="text-right">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">لوحة التحكم</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-1">نظرة عامة على إحصائيات النظام</p>
          </div>
        </div>
      </header>

      <!-- القائمة الجانبية للجوال (أيقونات فقط) -->
      <div v-if="mobileMenuOpen" class="lg:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-2 px-4">
        <div class="flex justify-around">
          <Link 
            :href="route('dashboard')"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[$page.url === '/dashboard' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <span class="text-xl">📊</span>
            <span class="text-xs mt-1">التحكم</span>
          </Link>

          <Link 
            :href="route('events.index')"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[$page.url.startsWith('/events') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <span class="text-xl">🎪</span>
            <span class="text-xs mt-1">الفعاليات</span>
          </Link>

          <Link 
            :href="route('tickets.index')"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[$page.url.startsWith('/tickets') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <span class="text-xl">🎫</span>
            <span class="text-xs mt-1">التذاكر</span>
          </Link>

          <Link 
            :href="route('users.index')"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[$page.url.startsWith('/users') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <span class="text-xl">👥</span>
            <span class="text-xs mt-1">المستخدمين</span>
          </Link>

          <Link 
            :href="route('profile.edit')"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300"
          >
            <span class="text-xl">⚙️</span>
            <span class="text-xs mt-1">الإعدادات</span>
          </Link>
        </div>
      </div>

      <!-- محتوى Dashboard -->
      <main class="flex-1 overflow-y-auto">
        <div class="py-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- حالة التحميل -->
            <div v-if="loading" class="text-center py-12">
              <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-3"></div>
              <p class="text-gray-600 dark:text-gray-300">جاري تحميل البيانات...</p>
            </div>

            <!-- المحتوى الرئيسي -->
            <div v-else>
              <!-- إحصائيات سريعة -->
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-4 shadow-lg">
                  <div class="flex items-center justify-between">
                    <div class="text-right">
                      <p class="text-blue-100 text-sm">إجمالي الفعاليات</p>
                      <p class="text-2xl font-bold">{{ stats.total_events || 0 }}</p>
                    </div>
                    <div class="text-2xl">🎪</div>
                  </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-4 shadow-lg">
                  <div class="flex items-center justify-between">
                    <div class="text-right">
                      <p class="text-green-100 text-sm">فعاليات قادمة</p>
                      <p class="text-2xl font-bold">{{ stats.active_events || 0 }}</p>
                    </div>
                    <div class="text-2xl">📅</div>
                  </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-4 shadow-lg">
                  <div class="flex items-center justify-between">
                    <div class="text-right">
                      <p class="text-purple-100 text-sm">إجمالي التذاكر</p>
                      <p class="text-2xl font-bold">{{ stats.total_tickets || 0 }}</p>
                    </div>
                    <div class="text-2xl">🎫</div>
                  </div>
                </div>

                <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg p-4 shadow-lg">
                  <div class="flex items-center justify-between">
                    <div class="text-right">
                      <p class="text-orange-100 text-sm">إجمالي الإيرادات</p>
                      <p class="text-2xl font-bold">{{ (stats.total_revenue || 0) }} ر.س</p>
                    </div>
                    <div class="text-2xl">💰</div>
                  </div>
                </div>
              </div>

              <!-- قسم النص التفسيري -->
              <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
                <div class="text-right">
                  <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">نظرة عامة على النظام</h3>
                  <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    لوحة التحكم تقدم لك نظرة شاملة على أداء نظام إدارة الفعاليات. يمكنك متابعة الإحصائيات الحيوية، 
                    تتبع الفعاليات القادمة، وإدارة التذاكر والمستخدمين بكل سهولة. استخدم الأيقونات أعلى الصفحة للوصول 
                    السريع إلى مختلف أقسام النظام.
                  </p>
                </div>
              </div>

              <!-- الرسوم البيانية والإحصائيات -->
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                  <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 text-right">
                    📈 الفعاليات حسب الشهر
                  </h3>
                  <div class="h-48 flex items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded">
                    <p class="text-gray-500 dark:text-gray-400">الرسم البياني قيد التطوير</p>
                  </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                  <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 text-right">
                    📊 التذاكر حسب النوع
                  </h3>
                  <div class="h-48 flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded">
                    <p class="text-gray-500 dark:text-gray-400">الرسم البياني قيد التطوير</p>
                  </div>
                </div>
              </div>

              <!-- إحصائيات المستخدم -->
              <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 text-right">
                  👤 إحصائياتي الشخصية
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                  <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <div class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ userStats.my_events || 0 }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-300">فعالياتي</div>
                  </div>
                  <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <div class="text-xl font-bold text-green-600 dark:text-green-400">{{ userStats.my_active_events || 0 }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-300">فعاليات قادمة</div>
                  </div>
                  <div class="text-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <div class="text-xl font-bold text-purple-600 dark:text-purple-400">{{ userStats.my_tickets_sold || 0 }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-300">تذاكر مباعة</div>
                  </div>
                  <div class="text-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <div class="text-xl font-bold text-orange-600 dark:text-orange-400">{{ userStats.my_revenue || 0 }} ر.س</div>
                    <div class="text-xs text-gray-600 dark:text-gray-300">إيرادات</div>
                  </div>
                </div>
              </div>

              <!-- فعالياتي القادمة -->
              <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 text-right">
                  🎪 فعالياتي القادمة
                </h3>
                <div v-if="upcomingEvents.length > 0" class="space-y-3">
                  <div v-for="event in upcomingEvents" :key="event.id" 
                       class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <div class="text-right">
                      <h4 class="font-medium text-gray-800 dark:text-white">{{ event.title }}</h4>
                      <p class="text-sm text-gray-600 dark:text-gray-300">{{ event.location }} - {{ formatDate(event.start_date) }}</p>
                    </div>
                    <button @click="$inertia.visit(`/events/${event.id}`)" 
                            class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition-colors">
                      عرض
                    </button>
                  </div>
                </div>
                <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400">
                  <div class="text-4xl mb-2">📅</div>
                  <p>لا توجد فعاليات قادمة</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, onMounted, computed } from 'vue'

// المتغيرات التفاعلية
const mobileMenuOpen = ref(false)
const isDarkMode = ref(false)
const stats = ref({})
const userStats = ref({})
const upcomingEvents = ref([])
const loading = ref(true)

// تحقق من وجود المستخدم المسجل
const currentUser = computed(() => {
  return window.$page?.props?.auth?.user || { 
    name: 'wiam', 
    email: 'wiam@gmail.com' 
  }
})

const currentUserInitials = computed(() => {
  const name = currentUser.value?.name || 'مستخدم'
  return name.split(' ').map(n => n[0]).join('') || 'U'
})

const currentDate = computed(() => {
  return new Date().toLocaleDateString('ar-SA', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
})

// الدوال
const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
}

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
    // إعادة تطبيق الألوان على جميع العناصر
    applyDarkModeStyles()
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
    applyLightModeStyles()
  }
}

// تطبيق أنماط الوضع الليلي
const applyDarkModeStyles = () => {
  const styles = `
    .dark .bg-white { background-color: #1f2937; }
    .dark .text-gray-800 { color: #f9fafb; }
    .dark .text-gray-600 { color: #d1d5db; }
    .dark .border-gray-200 { border-color: #374151; }
  `
  if (!document.getElementById('dark-mode-styles')) {
    const styleSheet = document.createElement('style')
    styleSheet.id = 'dark-mode-styles'
    styleSheet.innerText = styles
    document.head.appendChild(styleSheet)
  }
}

const applyLightModeStyles = () => {
  const styleSheet = document.getElementById('dark-mode-styles')
  if (styleSheet) {
    styleSheet.remove()
  }
}

const fetchDashboardData = async () => {
  try {
    console.log('🔍 جاري جلب البيانات من API...')
    
    // محاكاة جلب البيانات من API
    await new Promise(resolve => setTimeout(resolve, 1500))
    
    // بيانات تجريبية (ستستبدل بالبيانات الحقيقية)
    stats.value = {
      total_events: 15,
      active_events: 8,
      total_tickets: 250,
      total_revenue: 12500
    }
    
    userStats.value = {
      my_events: 5,
      my_active_events: 3,
      my_tickets_sold: 45,
      my_revenue: 3200
    }
    
    upcomingEvents.value = []
    
    console.log('✅ تم تحميل البيانات بنجاح')
    
  } catch (error) {
    console.error('❌ خطأ في جلب البيانات:', error)
    // بيانات تجريبية للطوارئ
    stats.value = {
      total_events: 15,
      active_events: 8,
      total_tickets: 250,
      total_revenue: 12500
    }
    userStats.value = {
      my_events: 5,
      my_active_events: 3,
      my_tickets_sold: 45,
      my_revenue: 3200
    }
    upcomingEvents.value = []
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  if (!dateString) return 'غير محدد'
  return new Date(dateString).toLocaleDateString('ar-SA', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const logout = () => {
  router.post(route('logout'))
}

onMounted(() => {
  // تحميل تفضيل الوضع الليلي
  if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
    isDarkMode.value = true
    applyDarkModeStyles()
  } else {
    document.documentElement.classList.remove('dark')
    isDarkMode.value = false
    applyLightModeStyles()
  }
  
  fetchDashboardData()
})
</script>

<style scoped>
/* تحسينات للعرض على الجوال */
@media (max-width: 1024px) {
  .mobile-menu {
    transform: translateY(-100%);
    transition: transform 0.3s ease-in-out;
  }
  
  .mobile-menu.open {
    transform: translateY(0%);
  }
}

/* تحسينات للوضع الليلي */
.dark {
  color-scheme: dark;
}

/* تحسينات للرسوم البيانية */
.bg-gradient-to-br {
  background-size: 200% 200%;
  animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
</style>