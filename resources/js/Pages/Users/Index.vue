<template>
  <Head title="إدارة المستخدمين" />

  <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
    <!-- القائمة الجانبية -->
    <aside class="hidden lg:block w-64 bg-white dark:bg-gray-800 shadow-lg border-l border-gray-200 dark:border-gray-700 order-2">
      <!-- نفس القائمة الجانبية من Dashboard.vue -->
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

      <nav class="p-4 space-y-2">
        <Link :href="route('dashboard')" class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
          <span class="text-lg">📊</span>
          <span class="flex-1 text-right">لوحة التحكم</span>
        </Link>

        <Link :href="route('events.index')" class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
          <span class="text-lg">🎪</span>
          <span class="flex-1 text-right">إدارة الفعاليات</span>
        </Link>

        <Link :href="route('tickets.index')" class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
          <span class="text-lg">🎫</span>
          <span class="flex-1 text-right">إدارة التذاكر</span>
        </Link>

        <Link :href="route('users.index')" class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400">
          <span class="text-lg">👥</span>
          <span class="flex-1 text-right">إدارة المستخدمين</span>
        </Link>

        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
          <Link :href="route('profile.edit')" class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
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
      <!-- الهيدر -->
      <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center gap-4">
            <button @click="toggleMobileMenu" class="lg:hidden text-gray-600 dark:text-gray-300">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>

            <div class="flex items-center gap-3">
              <button class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg relative">
                <span class="text-lg">🔔</span>
              </button>

              <button @click="toggleDarkMode" class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                <span class="text-lg">{{ isDarkMode ? '🌙' : '☀️' }}</span>
              </button>

              <div class="text-left hidden sm:block">
                <span class="text-sm text-gray-500">{{ currentDate }}</span>
              </div>
            </div>
          </div>

          <div class="text-right">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">إدارة المستخدمين</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-1">إدارة مستخدمي النظام</p>
          </div>
        </div>
      </header>

      <!-- محتوى الصفحة -->
      <main class="flex-1 overflow-y-auto">
        <div class="py-6">
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center py-12">
              <div class="text-6xl mb-4">👥</div>
              <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">صفحة إدارة المستخدمين</h3>
              <p class="text-gray-500 dark:text-gray-400">هذه الصفحة قيد التطوير</p>
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

const mobileMenuOpen = ref(false)
const isDarkMode = ref(false)

const currentUser = computed(() => {
  return window.$page?.props?.auth?.user || { 
    name: 'مستخدم', 
    email: 'example@email.com' 
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
  router.post(route('logout'))
}

onMounted(() => {
  if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
    isDarkMode.value = true
  }
})
</script>