<template>
  <div v-if="show" :class="toastClass" class="fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300">
    <div class="flex items-center gap-3">
      <span class="text-xl">{{ toastIcon }}</span>
      <div>
        <p class="font-semibold">{{ message }}</p>
        <p v-if="description" class="text-sm opacity-90">{{ description }}</p>
      </div>
      <button @click="hide" class="text-lg hover:opacity-70">×</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const show = ref(false)
const message = ref('')
const description = ref('')
const type = ref('success') // success, error, warning, info

const toastIcon = computed(() => {
  const icons = {
    success: '✅',
    error: '❌',
    warning: '⚠️',
    info: 'ℹ️'
  }
  return icons[type.value]
})

const toastClass = computed(() => {
  const classes = {
    success: 'bg-green-500 text-white',
    error: 'bg-red-500 text-white',
    warning: 'bg-yellow-500 text-white',
    info: 'bg-blue-500 text-white'
  }
  return classes[type.value]
})

const showToast = (msg, desc = '', toastType = 'success') => {
  message.value = msg
  description.value = desc
  type.value = toastType
  show.value = true
  
  setTimeout(() => {
    hide()
  }, 3000)
}

const hide = () => {
  show.value = false
}

// Export للاستخدام في المكونات الأخرى
defineExpose({ showToast })
</script>