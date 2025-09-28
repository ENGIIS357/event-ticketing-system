<template>
  <Head title="إدارة الفعاليات" />
  <AppLayout title="إدارة الفعاليات" description="قم بإدارة فعالياتك بكل سهولة">
    
    <div class="py-4 md:py-6">
      <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">

        <!-- حالة التحميل -->
        <div v-if="loading" class="flex justify-center items-center py-12 md:py-20 text-right">
          <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-3"></div>
            <p class="text-gray-600 dark:text-gray-300 text-sm md:text-base">جاري تحميل الفعاليات...</p>
          </div>
        </div>

        <!-- حالة الخطأ -->
        <div v-else-if="error" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 md:p-6 text-center">
          <div class="text-red-500 text-3xl md:text-4xl mb-2">❌</div>
          <h3 class="text-red-800 dark:text-red-300 text-base md:text-lg font-semibold mb-2">حدث خطأ</h3>
          <p class="text-red-700 dark:text-red-400 text-sm md:text-base">{{ error }}</p>
          <button @click="fetchEvents" class="mt-3 bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600 transition-colors">
            إعادة المحاولة
          </button>
        </div>

        <!-- المحتوى الرئيسي -->
        <div v-else>
          <!-- البحث والتصفية -->
          <div class="bg-white dark:bg-gray-800 rounded-lg p-3 md:p-4 shadow-sm border border-gray-200 dark:border-gray-700 mb-4 md:mb-6 text-right">
            <div class="flex flex-col md:flex-row gap-3 md:gap-4 items-center">
              <div class="flex-1 w-full relative">
                <span class="absolute left-3 top-2.5 md:top-3 text-gray-400 text-sm">🔍</span>
                <input v-model="searchQuery" type="text" placeholder="ابحث في الفعاليات..." 
                       class="w-full pr-3 pl-9 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg 
                              dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 text-right"
                       dir="rtl">
              </div>

              <select v-model="filterStatus" 
                      class="w-full md:w-auto px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white text-right"
                      dir="rtl">
                <option value="all">جميع الفعاليات</option>
                <option value="active">فعاليات قادمة</option>
                <option value="past">فعاليات منتهية</option>
              </select>
            </div>
          </div>

          <!-- إحصائيات سريعة -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 mb-4 md:mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-lg p-3 text-center">
              <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ events.length }}</div>
              <div class="text-xs md:text-sm text-gray-600 dark:text-gray-300">إجمالي الفعاليات</div>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-lg p-3 text-center">
              <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ activeEventsCount }}</div>
              <div class="text-xs md:text-sm text-gray-600 dark:text-gray-300">فعاليات قادمة</div>
            </div>
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-lg p-3 text-center">
              <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ totalTickets }}</div>
              <div class="text-xs md:text-sm text-gray-600 dark:text-gray-300">إجمالي التذاكر</div>
            </div>
            <div class="bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 rounded-lg p-3 text-center">
              <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ totalRevenue }}</div>
              <div class="text-xs md:text-sm text-gray-600 dark:text-gray-300">إجمالي الإيرادات</div>
            </div>
          </div>

          <!-- زر الإضافة الجديد -->
          <div class="flex justify-between items-center mb-4 md:mb-6">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">فعالياتي</h2>
            <button @click="goToCreate" 
                    class="bg-gradient-to-r from-green-500 to-teal-600 text-white px-4 py-2.5 rounded-lg hover:from-green-600 hover:to-teal-700 transition-all duration-300 flex items-center gap-2 text-sm font-medium">
              <span>➕</span>
              إضافة فعالية جديدة
            </button>
          </div>

          <!-- قائمة الفعاليات -->
          <div v-if="filteredEvents.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            <div v-for="event in filteredEvents" :key="event.id" 
                 class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 
                        hover:shadow-lg transition-all duration-300 text-right overflow-hidden">

              <!-- شريط الحالة -->
              <div :class="`h-1.5 ${ new Date(event.start_date) > new Date() ? 'bg-gradient-to-r from-green-500 to-teal-500' : 'bg-gray-400' }`"></div>

              <div class="p-4 md:p-5">
                <div class="flex justify-between items-start mb-3">
                  <h3 class="text-base md:text-lg font-semibold text-gray-800 dark:text-white line-clamp-1 text-right w-full">{{ event.title }}</h3>
                  <span :class="`px-2 py-1 rounded-full text-xs font-medium ${
                    new Date(event.start_date) > new Date() 
                      ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' 
                      : 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-300'
                  }`">
                    {{ new Date(event.start_date) > new Date() ? 'قادمة' : 'منتهية' }}
                  </span>
                </div>

                <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2 text-right">{{ event.description || 'لا يوجد وصف' }}</p>

                <div class="space-y-2 text-xs md:text-sm text-gray-500 dark:text-gray-400 mb-4">
                  <div class="flex items-center gap-2 justify-end text-right">
                    <span class="truncate">{{ event.location || 'غير محدد' }}</span>
                    <span class="text-gray-400">📍</span>
                  </div>
                  <div class="flex items-center gap-2 justify-end text-right">
                    <span>{{ formatDate(event.start_date) }}</span>
                    <span class="text-gray-400">📅</span>
                  </div>
                  <div class="flex items-center gap-2 justify-end text-right">
                    <span>{{ event.price || 0 }} ر.س</span>
                    <span class="text-gray-400">💰</span>
                  </div>
                  <div class="flex items-center gap-2 justify-end text-right">
                    <span>{{ event.available_tickets || 0 }} تذكرة</span>
                    <span class="text-gray-400">🎫</span>
                  </div>
                </div>

                <!-- أزرار التحكم -->
                <div class="flex gap-2 pt-3 border-t border-gray-200 dark:border-gray-600">
                  <button @click="viewEvent(event)" 
                          class="flex-1 bg-gray-500 text-white py-2 px-3 rounded-lg hover:bg-gray-600 transition-colors flex items-center justify-center gap-1 text-sm font-medium">
                    <span>👁️</span>
                    عرض
                  </button>
                  <button @click="editEvent(event)" 
                          class="flex-1 bg-blue-500 text-white py-2 px-3 rounded-lg hover:bg-blue-600 transition-colors flex items-center justify-center gap-1 text-sm font-medium">
                    <span>✏️</span>
                    تعديل
                  </button>
                  <button 
                    v-if="event.user.id === currentUserId" 
                    @click="deleteEvent(event.id)" 
                    class="flex-1 bg-red-500 text-white py-2 px-3 rounded-lg hover:bg-red-600 transition-colors flex items-center justify-center gap-1 text-sm font-medium"
                  >
                    <span>🗑️</span>
                    حذف
                  </button>
                </div>
              </div>
            </div>
          </div>

          <div v-else class="text-center py-8 md:py-12 text-right">
            <div class="text-4xl md:text-6xl mb-3">🎪</div>
            <h3 class="text-lg md:text-xl font-semibold text-gray-700 dark:text-gray-300">لا توجد فعاليات</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-1 mb-4 text-sm md:text-base">ابدأ بإضافة أول فعالية لك</p>
            <button @click="goToCreate" 
                    class="bg-gradient-to-r from-green-500 to-teal-600 text-white px-5 py-3 rounded-lg hover:from-green-600 hover:to-teal-700 transition-all duration-300 text-base font-medium">
              إضافة فعالية جديدة
            </button>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { ref, computed, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/Applayout.vue'

// المتغيرات التفاعلية
const loading = ref(true)
const error = ref('')
const events = ref([])
const searchQuery = ref('')
const filterStatus = ref('all')

// المعرف الحالي للمستخدم المسجل
const currentUserId = ref(2)

// الدوال المحسوبة
const filteredEvents = computed(() => {
  let filtered = events.value

  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(event =>
      event.title?.toLowerCase().includes(query) ||
      event.location?.toLowerCase().includes(query) ||
      event.description?.toLowerCase().includes(query)
    )
  }

  if (filterStatus.value === 'active') {
    filtered = filtered.filter(event => new Date(event.start_date) > new Date())
  } else if (filterStatus.value === 'past') {
    filtered = filtered.filter(event => new Date(event.start_date) <= new Date())
  }

  return filtered.sort((a,b) => new Date(b.start_date) - new Date(a.start_date))
})

const activeEventsCount = computed(() => {
  return events.value.filter(event => new Date(event.start_date) > new Date()).length
})

const totalTickets = computed(() => {
  return events.value.reduce((sum, event) => sum + (event.available_tickets || 0), 0)
})

const totalRevenue = computed(() => {
  return events.value.reduce((sum, event) => sum + (event.price || 0) * (event.available_tickets || 0), 0)
})

// الدوال
const fetchEvents = async () => {
  try {
    loading.value = true
    error.value = ''

    const response = await fetch('/api/v1/events')
    if (!response.ok) throw new Error(`خطأ في الشبكة: ${response.status}`)

    const data = await response.json()
    events.value = data.events || data || []
  } catch (err) {
    error.value = err.message || 'فشل في تحميل الفعاليات'
    events.value = []
  } finally {
    loading.value = false
  }
}

const goToCreate = () => {
  router.visit('/events/create')
}

const viewEvent = (event) => router.visit(`/events/${event.id}`)
const editEvent = (event) => router.visit(`/events/${event.id}/edit`)

const deleteEvent = async (eventId) => {
  if (!confirm('هل أنت متأكد من حذف هذه الفعالية؟')) return
  
  try {
    const response = await fetch(`/events/${eventId}`, {
      method: 'DELETE',
      headers: { 
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    
    if (response.ok) {
      events.value = events.value.filter(event => event.id !== eventId)
    } else {
      throw new Error('فشل في حذف الفعالية')
    }
  } catch (err) {
    alert('❌ فشل في حذف الفعالية: ' + err.message)
  }
}

const formatDate = (dateString) => {
  if (!dateString) return 'غير محدد'
  return new Date(dateString).toLocaleDateString('ar-SA', {
    year: 'numeric', month: 'long', day: 'numeric'
  })
}

onMounted(() => fetchEvents())
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>