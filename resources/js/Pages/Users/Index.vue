<template>
  <AppLayout title="إدارة المستخدمين" description="إدارة مستخدمي النظام والصلاحيات">
    <div class="py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-blue-100 text-sm">إجمالي المستخدمين</p>
                <p class="text-3xl font-bold">{{ users.total }}</p>
              </div>
              <div class="text-3xl">👥</div>
            </div>
          </div>

          <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-green-100 text-sm">منظمي فعاليات</p>
                <p class="text-3xl font-bold">{{ organizersCount }}</p>
              </div>
              <div class="text-3xl">🎪</div>
            </div>
          </div>

          <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-purple-100 text-sm">مستخدمين عاديين</p>
                <p class="text-3xl font-bold">{{ regularUsersCount }}</p>
              </div>
              <div class="text-3xl">👤</div>
            </div>
          </div>
        </div>

        <!-- البحث والإجراءات -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
          <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <div class="flex gap-4 w-full md:w-auto">
              <div class="relative flex-1 md:flex-none">
                <input 
                  v-model="search"
                  type="text" 
                  placeholder="ابحث عن مستخدم..."
                  class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <span class="absolute right-3 top-2.5 text-gray-400">🔍</span>
              </div>
              
              <select v-model="roleFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">جميع الأدوار</option>
                <option value="admin">مدير</option>
                <option value="organizer">منظم</option>
                <option value="user">مستخدم عادي</option>
              </select>
            </div>
            
            <button 
              @click="showCreateModal = true"
              class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors flex items-center gap-2"
            >
              <span>+</span>
              <span>إضافة مستخدم</span>
            </button>
          </div>
        </div>

        <!-- جدول المستخدمين -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">قائمة المستخدمين</h3>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-right">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">المستخدم</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">البريد الإلكتروني</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">الدور</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">تاريخ التسجيل</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">الحالة</th>
                  <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300">الإجراءات</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                <tr v-for="user in filteredUsers" :key="user.id" class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3 justify-end">
                      <div class="text-right">
                        <p class="font-medium text-gray-800 dark:text-white">{{ user.name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">ID: {{ user.id }}</p>
                      </div>
                      <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">{{ getUserInitials(user.name) }}</span>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ user.email }}</td>
                  <td class="px-6 py-4">
                    <span :class="`px-3 py-1 rounded-full text-xs font-medium ${
                      user.role === 'admin' 
                        ? 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'
                        : user.role === 'organizer'
                        ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'
                        : 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                    }`">
                      {{ getUserRoleText(user.role) }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ formatDate(user.created_at) }}</td>
                  <td class="px-6 py-4">
                    <span :class="`px-3 py-1 rounded-full text-xs font-medium ${
                      user.status === 'active' 
                        ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                        : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'
                    }`">
                      {{ user.status === 'active' ? 'نشط' : 'غير نشط' }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex gap-2">
                      <button 
                        @click="editUser(user)"
                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 text-sm px-3 py-1 rounded hover:bg-blue-50 dark:hover:bg-blue-900"
                      >
                        تعديل
                      </button>
                      <button 
                        @click="deleteUser(user)"
                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm px-3 py-1 rounded hover:bg-red-50 dark:hover:bg-red-900"
                      >
                        حذف
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- رسالة إذا لم يكن هناك مستخدمين -->
        <div v-if="filteredUsers.length === 0" class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg mt-6">
          <div class="text-6xl mb-4">👥</div>
          <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">لا توجد مستخدمين</h3>
          <p class="text-gray-500 dark:text-gray-400 mb-6">لم يتم العثور على مستخدمين مطابقين لبحثك</p>
          <button 
            @click="resetFilters"
            class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors"
          >
            عرض جميع المستخدمين
          </button>
        </div>
      </div>
    </div>

    <!-- نموذج إضافة/تعديل مستخدم -->
    <div v-if="showCreateModal || editingUser" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
            {{ editingUser ? 'تعديل المستخدم' : 'إضافة مستخدم جديد' }}
          </h3>
        </div>
        
        <form @submit.prevent="saveUser" class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الاسم الكامل</label>
            <input 
              v-model="userForm.name"
              type="text" 
              required
              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">البريد الإلكتروني</label>
            <input 
              v-model="userForm.email"
              type="email" 
              required
              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الدور</label>
            <select 
              v-model="userForm.role"
              class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="user">مستخدم عادي</option>
              <option value="organizer">منظم فعاليات</option>
              <option value="admin">مدير النظام</option>
            </select>
          </div>
          
          <div class="flex gap-4 pt-4">
            <button 
              type="button"
              @click="closeModal"
              class="flex-1 px-4 py-2 text-gray-600 dark:text-gray-400 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            >
              إلغاء
            </button>
            <button 
              type="submit"
              class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
            >
              {{ editingUser ? 'تحديث' : 'حفظ' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/Applayout.vue'


// البيانات الحقيقية من قاعدة البيانات
const props = defineProps({
  users: {
    type: Object,
    default: () => ({ data: [], total: 0 })
  }
})

const search = ref('')
const roleFilter = ref('')
const showCreateModal = ref(false)
const editingUser = ref(null)

const userForm = ref({
  name: '',
  email: '',
  role: 'user'
})

// إحصائيات محسوبة
const organizersCount = computed(() => 
  props.users.data.filter(user => user.role === 'organizer').length
)

const regularUsersCount = computed(() => 
  props.users.data.filter(user => user.role === 'user').length
)

// تصفية المستخدمين
const filteredUsers = computed(() => {
  let filtered = props.users.data

  if (search.value) {
    filtered = filtered.filter(user => 
      user.name.includes(search.value) || 
      user.email.includes(search.value)
    )
  }

  if (roleFilter.value) {
    filtered = filtered.filter(user => user.role === roleFilter.value)
  }

  return filtered
})

// دوال المساعدة
const getUserInitials = (name) => {
  return name.split(' ').map(n => n[0]).join('') || 'U'
}

const getUserRoleText = (role) => {
  const roles = {
    'admin': 'مدير',
    'organizer': 'منظم',
    'user': 'مستخدم'
  }
  return roles[role] || role
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('ar-SA', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

// دوال الإجراءات
const editUser = (user) => {
  editingUser.value = user
  userForm.value = { ...user }
}

const deleteUser = (user) => {
  if (confirm(`هل أنت متأكد من حذف المستخدم "${user.name}"؟`)) {
    router.delete(`/users/${user.id}`, {
      onSuccess: () => {
        // سيتم تحديث القائمة تلقائياً بعد الحذف
      }
    })
  }
}

const saveUser = () => {
  if (editingUser.value) {
    // تحديث المستخدم
    router.put(`/users/${editingUser.value.id}`, userForm.value, {
      onSuccess: () => {
        closeModal()
      }
    })
  } else {
    // إضافة مستخدم جديد
    router.post('/users', userForm.value, {
      onSuccess: () => {
        closeModal()
      }
    })
  }
}

const closeModal = () => {
  showCreateModal.value = false
  editingUser.value = null
  userForm.value = {
    name: '',
    email: '',
    role: 'user'
  }
}

const resetFilters = () => {ض
  search.value = ''
  roleFilter.value = ''
}
</script>