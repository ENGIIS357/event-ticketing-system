<template>
  <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
    
    <!-- الأزرار يسار -->
    <div class="flex gap-2">
      <button 
        @click="$inertia.visit(backUrl)" 
        class="flex items-center gap-2 bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors text-lg font-semibold">
        ← رجوع للفعاليات
      </button>
    </div>

    <!-- النصوص يمين -->
    <div class="text-right">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
        {{ title }}
      </h2>
      <p class="text-gray-600 dark:text-gray-300 mt-1">
        {{ subtitle }}
      </p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  subtitle: String,
  backUrl: {
    type: String,
    default: '/events'
  }
})
</script>