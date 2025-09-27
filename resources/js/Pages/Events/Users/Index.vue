<template>
  <Head title="إدارة المستخدمين" />
  
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <div class="text-right">
          <h2 class="text-2xl font-bold text-gray-800 dark:text-white">إدارة المستخدمين</h2>
          <p class="text-gray-600 dark:text-gray-300 mt-1">إدارة مستخدمي النظام</p>
        </div>
      </div>
    </template>

    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 text-right">
          <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border">
            <div class="text-2xl font-bold text-blue-600">{{ users.length }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">إجمالي المستخدمين</div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border">
            <div class="text-2xl font-bold text-green-600">{{ activeUsers }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">مستخدمين نشطين</div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border">
            <div class="text-2xl font-bold text-purple-600">0</div>
            <div class="text-sm text-gray-600 dark:text-gray-400">مسؤولين</div>
          </div>
        </div>

        <!-- جدول المستخدمين -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">قائمة المستخدمين</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-right">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">الاسم</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">البريد</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">تاريخ التسجيل</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">الحالة</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">الإجراءات</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">{{ user.name }}</td>
                  <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ user.email }}</td>
                  <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ formatDate(user.created_at) }}</td>
                  <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                      نشط
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm">
                    <button class="text-blue-600 hover:text-blue-900 mr-3">تعديل</button>
                    <button class="text-red-600 hover:text-red-900">حذف</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- رسالة إذا لم يكن هناك مستخدمين -->
        <div v-if="users.length === 0" class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow mt-6">
          <div class="text-6xl mb-4">👥</div>
          <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">لا توجد مستخدمين</h3>
          <p class="text-gray-500 dark:text-gray-400">سيظهر المستخدمون هنا عند تسجيلهم</p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { ref, onMounted, computed } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const users = ref([])
const loading = ref(true)

const activeUsers = computed(() => users.value.length)

const fetchUsers = async () => {
  try {
    // بيانات تجريبية - سيتم استبدالها ب API حقيقي
    users.value = [
      {
        id: 1,
        name: 'محمد أحمد',
        email: 'mohamed@example.com',
        created_at: new Date().toISOString(),
        status: 'active'
      },
      {
        id: 2,
        name: 'فاطمة محمد',
        email: 'fatima@example.com',
        created_at: new Date().toISOString(),
        status: 'active'
      }
    ]
  } catch (error) {
    console.error('Error fetching users:', error)
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('ar-SA')
}

onMounted(() => {
  fetchUsers()
})
</script>