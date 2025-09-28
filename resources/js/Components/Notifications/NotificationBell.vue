<template>
  <div class="relative">
    <button 
      @click="toggleDropdown"
      class="p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg relative transition-colors duration-200"
    >
      <span class="text-lg">🔔</span>
      <span 
        v-if="unreadCount > 0" 
        class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-xs text-white flex items-center justify-center"
      >
        {{ unreadCount > 9 ? '9+' : unreadCount }}
      </span>
    </button>

    <!-- Dropdown مبسط -->
    <div 
      v-if="dropdownOpen" 
      class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 z-50"
    >
      <div class="p-4 text-center">
        <p class="text-gray-600 dark:text-gray-300">نظام الإشعارات قيد التطوير</p>
        <button 
          @click="addTestNotification"
          class="mt-2 bg-blue-500 text-white px-3 py-1 rounded text-sm"
        >
          إضافة إشعار تجريبي
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const dropdownOpen = ref(false)
const unreadCount = ref(3) // رقم تجريبي

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value
}

const addTestNotification = () => {
  unreadCount.value += 1
  alert('تم إضافة إشعار تجريبي!')
}
</script>