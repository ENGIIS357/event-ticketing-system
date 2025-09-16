<template>
  <div>
    <!-- زر إضافة فعالية جديدة -->
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white">قائمة الفعاليات</h2>
      <button 
        @click="showCreateForm = true"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md"
      >
        إضافة فعالية جديدة
      </button>
    </div>

    <!-- نموذج الإضافة -->
    <CreateEventForm 
      v-if="showCreateForm"
      @cancel="showCreateForm = false"
      @created="handleEventCreated"
    />

    <!-- باقي الكود -->
  </div>
</template>

<script>
import CreateEventForm from './CreateEventForm.vue';

export default {
  components: {
    CreateEventForm
  },
  data() {
    return {
      showCreateForm: false,
      // باقي البيانات
    };
  },
  methods: {
    handleEventCreated(newEvent) {
      this.events.push(newEvent);
      this.showCreateForm = false;
    },
    // باقي methods
  }
};
</script>