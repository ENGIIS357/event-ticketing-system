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
            <span class="text-white font-bold text-sm">EH</span>
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
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          <span class="flex-1 text-right">لوحة التحكم</span>
        </Link>

        <Link 
          href="/events"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[isActive('/events') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
          <span class="flex-1 text-right">إدارة الفعاليات</span>
        </Link>

        <Link 
          href="/tickets"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[isActive('/tickets') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
          </svg>
          <span class="flex-1 text-right">إدارة التذاكر</span>
        </Link>

        <Link 
          href="/users"
          class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200"
          :class="[isActive('/users') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700']"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
          </svg>
          <span class="flex-1 text-right">إدارة المستخدمين</span>
        </Link>

        <!-- قسم الإعدادات -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
          <Link 
            href="/profile"
            class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="flex-1 text-right">الإعدادات</span>
          </Link>

          <button @click="logout" class="flex items-center gap-3 p-3 rounded-lg w-full text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
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
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path v-if="isDarkMode" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                  <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
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
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-xs mt-1">التحكم</span>
          </Link>

          <Link 
            href="/events"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[isActive('/events') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-xs mt-1">الفعاليات</span>
          </Link>

          <Link 
            href="/tickets"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[isActive('/tickets') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            <span class="text-xs mt-1">التذاكر</span>
          </Link>

          <Link 
            href="/users"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200"
            :class="[isActive('/users') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300']"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            <span class="text-xs mt-1">المستخدمين</span>
          </Link>

          <Link 
            href="/profile"
            class="flex flex-col items-center p-2 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
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
const userName = ref(' wiam')
const userEmail = ref('wiam@gmail.com')

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