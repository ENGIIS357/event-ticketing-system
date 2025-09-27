<template>
  <Head title="إضافة فعالية جديدة" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="text-right">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white">إضافة فعالية جديدة</h2>
          <p class="text-gray-600 dark:text-gray-300 mt-1">املأ البيانات لإنشاء فعالية جديدة</p>
        </div>
        <button @click="$inertia.visit('/events')" 
                class="flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
          رجوع للقائمة ←
        </button>
      </div>
    </template>

    <div class="py-6">
      <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
          <div class="bg-gradient-to-r from-green-500 to-green-600 h-1 w-full"></div>
          <div class="p-8">
            <form @submit.prevent="submitEvent" class="space-y-6">
              <div class="grid md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-right">
                    اسم الفعالية *
                  </label>
                  <input v-model="form.title" type="text" required 
                         placeholder="أدخل اسم الفعالية..."
                         class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                focus:ring-2 focus:ring-green-500 focus:border-transparent
                                dark:bg-gray-700 dark:text-white transition-all text-right"
                         dir="rtl">
                </div>

                <div class="md:col-span-2">
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-right">
                    الوصف *
                  </label>
                  <textarea v-model="form.description" rows="4" required
                            placeholder="وصف مختصر للفعالية..."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                   focus:ring-2 focus:ring-green-500 focus:border-transparent
                                   dark:bg-gray-700 dark:text-white transition-all text-right"
                            dir="rtl"></textarea>
                </div>

                <div class="md:col-span-2">
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 text-right">
                    الموقع *
                  </label>
                  <input v-model="form.location" type="text" required
                         placeholder="موقع انعقاد الفعالية..."
                         class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                focus:ring-2 focus:ring-green-500 focus:border-transparent
                                dark:bg-gray-700 dark:text-white transition-all text-right"
                         dir="rtl">
                </div>
              </div>

              <div class="grid md:grid-cols-2 gap-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                <div class="text-right">
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    تاريخ البداية *
                  </label>
                  <input v-model="form.start_date" type="date" required
                         class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                focus:ring-2 focus:ring-green-500 focus:border-transparent
                                dark:bg-gray-700 dark:text-white transition-all text-center"
                         dir="rtl">
                </div>

                <div class="text-right">
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    تاريخ النهاية *
                  </label>
                  <input v-model="form.end_date" type="date" required
                         class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                focus:ring-2 focus:ring-green-500 focus:border-transparent
                                dark:bg-gray-700 dark:text-white transition-all text-center"
                         dir="rtl">
                </div>
              </div>

              <div class="grid md:grid-cols-2 gap-6 pt-4 border-t border-gray-200 dark:border-gray-600">
                <div class="text-right">
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    السعر (ر.س) *
                  </label>
                  <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-500">ر.س</span>
                    <input v-model.number="form.price" type="number" min="0" step="0.01" required
                           class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 rounded-lg 
                                  focus:ring-2 focus:ring-green-500 focus:border-transparent
                                  dark:bg-gray-700 dark:text-white transition-all text-right"
                           dir="rtl">
                  </div>
                </div>

                <div class="text-right">
                  <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    عدد التذاكر *
                  </label>
                  <input v-model.number="form.available_tickets" type="number" min="1" required
                         class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                                focus:ring-2 focus:ring-green-500 focus:border-transparent
                                dark:bg-gray-700 dark:text-white transition-all text-right"
                         dir="rtl">
                </div>
              </div>

              <div class="flex justify-start gap-3 pt-6 border-t border-gray-200 dark:border-gray-600">
                <button type="submit" :disabled="saving"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg
                               hover:from-green-600 hover:to-green-700 disabled:opacity-50 disabled:cursor-not-allowed
                               transition-all flex items-center gap-2 order-2">
                  <span v-if="saving" class="animate-spin">⟳</span>
                  {{ saving ? 'جاري الحفظ...' : 'إنشاء الفعالية' }}
                </button>
                <button type="button" @click="$inertia.visit('/events')"
                        class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 
                               rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors order-1">
                  إلغاء
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'

export default {
  data() {
    return {
      form: {
        title: '',
        description: '',
        location: '',
        start_date: '',
        end_date: '',
        price: 0,
        available_tickets: 1,
      },
      saving: false,
    }
  },
  methods: {
    submitEvent() {
      this.saving = true
      Inertia.post('/events', this.form)
        .then(() => {
          this.saving = false
        })
        .catch(() => {
          this.saving = false
        })
    }
  }
}
</script>
