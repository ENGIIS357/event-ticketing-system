<template>
  <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
    <!-- القائمة الجانبية (للكمبيوتر) -->
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
          href="/dashboard"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[isActive('/dashboard') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <span class="text-lg">📊</span>
          <span class="flex-1 text-right">لوحة التحكم</span>
        </Link>

        <Link 
          href="/events"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[isActive('/events') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <span class="text-lg">🎪</span>
          <span class="flex-1 text-right">إدارة الفعاليات</span>
        </Link>

        <Link 
          href="/tickets"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[isActive('/tickets') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <span class="text-lg">🎫</span>
          <span class="flex-1 text-right">إدارة التذاكر</span>
        </Link>

        <Link 
          href="/users"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[isActive('/users') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <span class="text-lg">👥</span>
          <span class="flex-1 text-right">إدارة المستخدمين</span>
        </Link>

        <!-- قسم الإعدادات -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
          <Link 
            href="/profile"
            class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
          >
            <span class="text-lg">⚙️</span>
            <span class="flex-1 text-right">الإعدادات</span>
          </Link>

          <button @click="logout" class="flex items-center gap-3 p-3 rounded-lg w-full text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
            <span class="text-lg">🚪</span>
            <span class="flex-1 text-right">تسجيل خروج</span>
          </button>
        </div>
      </nav>
      
      <!-- معلومات المستخدم -->
      <div class="absolute bottom-0 right-0 left-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <div class="flex items-center gap-3">
          <div class="flex-1 text-right">
            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ userName }}</p>
            <p class="text-xs text-gray-600 dark:text-gray-300">{{ userEmail }}</p>
          </div>
          <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center">
            <span class="text-white font-bold text-sm">{{ userInitials }}</span>
          </div>
        </div>
      </div>
    </aside>

    <!-- المحتوى الرئيسي -->
    <div class="flex-1 flex flex-col overflow-hidden order-1">
      <!-- الهيدر -->
      <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center gap-4">
            <!-- زر القائمة للجوال -->
            <button @click="toggleMobileMenu" class="lg:hidden text-gray-600 dark:text-gray-300">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>

            <div class="flex items-center gap-3">
              <!-- زر الوضع الليلي -->
              <button @click="toggleDarkMode" class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <span class="text-lg">{{ isDarkMode ? '🌙' : '☀️' }}</span>
              </button>

              <!-- التاريخ -->
              <div class="text-left hidden sm:block">
                <span class="text-sm text-gray-500">{{ currentDate }}</span>
              </div>
            </div>
          </div>

          <!-- العنوان -->
          <div class="text-right">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ title }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-1">{{ description }}</p>
          </div>
        </div>
      </header>

      <!-- القائمة الجانبية للجوال -->
      <div v-if="mobileMenuOpen" class="lg:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-3 px-4">
        <div class="flex justify-around">
          <Link 
            href="/dashboard"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[isActive('/dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <span class="text-xl">📊</span>
            <span class="text-xs mt-1">التحكم</span>
          </Link>

          <Link 
            href="/events"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[isActive('/events') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <span class="text-xl">🎪</span>
            <span class="text-xs mt-1">الفعاليات</span>
          </Link>

          <Link 
            href="/tickets"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[isActive('/tickets') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <span class="text-xl">🎫</span>
            <span class="text-xs mt-1">التذاكر</span>
          </Link>

          <Link 
            href="/users"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[isActive('/users') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <span class="text-xl">👥</span>
            <span class="text-xs mt-1">المستخدمين</span>
          </Link>

          <Link 
            href="/profile"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300"
          >
            <span class="text-xl">⚙️</span>
            <span class="text-xs mt-1">الإعدادات</span>
          </Link>
        </div>
      </div>

      <!-- محتوى الصفحة -->
      <main class="flex-1 overflow-y-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'

// تعريف الـ props
const props = defineProps({
  title: {
    type: String,
    default: 'لوحة التحكم'
  },
  description: {
    type: String,
    default: 'مرحباً بك في نظام إدارة الفعاليات'
  }
})

const mobileMenuOpen = ref(false)
const isDarkMode = ref(false)

// بيانات المستخدم (مؤقتة)
const userName = ref('أحمد محمد')
const userEmail = ref('ahmed@example.com')

const userInitials = computed(() => {
  return userName.value.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2)
})

const currentDate = computed(() => {
  return new Date().toLocaleDateString('ar-SA', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
})

// دالة التحقق من الصفحة النشطة
const isActive = (path) => {
  return window.location.pathname === path || window.location.pathname.startsWith(path + '/')
}

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
}

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

const logout = () => {
  if (confirm('هل تريد تسجيل الخروج؟')) {
    window.location.href = '/logout'
  }
}

onMounted(() => {
  // التحقق من الوضع الليلي المحفوظ
  const savedTheme = localStorage.getItem('theme')
  if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
    isDarkMode.value = true
  }
})
</script>