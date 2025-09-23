<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg w-full max-w-md mx-auto">
      <div class="p-6">
        <h2 class="text-xl font-semibold mb-4">نموذج تجريبي</h2>
        <p class="mb-4">هذا نموذج تجريبي لاختبار إذا كان النموذج يظهر</p>
        <button @click="$emit('close')" class="bg-blue-500 text-white px-4 py-2 rounded">
          إغلاق
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineEmits(['close'])
</script>