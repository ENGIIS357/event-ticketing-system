<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-blue-900">
    <!-- Header -->
    <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-sm">
      <div class="container mx-auto px-6 py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
            <span class="text-2xl">🎪</span>
          </div>
          <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">EventHub</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300">نظام إدارة الفعاليات</p>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="flex items-center gap-4">
          <template v-if="$page.props.auth.user">
            <Link
              :href="route('dashboard')"
              class="px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 font-medium shadow-lg"
            >
              لوحة التحكم 🎯
            </Link>
          </template>

          <template v-else>
            <Link
              :href="route('login')"
              class="px-5 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition duration-200 font-medium shadow-lg flex items-center gap-2"
            >
              🔐 تسجيل الدخول
            </Link>

            <Link
              v-if="canRegister"
              :href="route('register')"
              class="px-5 py-2 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-lg hover:from-purple-600 hover:to-pink-700 transition duration-200 font-medium shadow-lg flex items-center gap-2"
            >
              🚀 إنشاء حساب
            </Link>
          </template>
        </nav>
      </div>
    </header>

    <!-- Hero Section -->
    <main class="container mx-auto px-6 text-center py-20">
      <h1 class="text-5xl md:text-6xl font-bold text-gray-800 dark:text-white mb-6">
        أدر فعالياتك
        <span class="bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">بكل سهولة</span>
      </h1>

      <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
        نظام متكامل لإدارة الفعاليات، التذاكر، والحضور. وفر وقتك وركز على ما يهم - نجاح فعاليتك.
      </p>

      <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
        <Link
          :href="canRegister ? route('register') : route('login')"
          class="px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl hover:from-blue-600 hover:to-purple-700 transition duration-200 font-semibold text-lg shadow-lg flex items-center gap-2 transform hover:scale-105"
        >
          🎪 ابدأ الآن مجاناً
        </Link>

        <Link
          :href="route('events')"
          class="px-8 py-4 border-2 border-blue-500 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-500 hover:text-white transition duration-200 font-semibold flex items-center gap-2"
        >
          👀 تصفح الفعاليات
        </Link>
      </div>
    </main>

    <!-- Features Section -->
    <section class="py-16 bg-white/50 dark:bg-gray-800/50">
      <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">مميزات النظام</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-12">
          كل ما تحتاجه لإدارة فعاليات ناجحة في مكان واحد
        </p>

        <div class="grid md:grid-cols-3 gap-8">
          <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center mb-4 text-blue-600 dark:text-blue-400 text-2xl">🎟️</div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">إدارة التذاكر</h3>
            <p class="text-gray-600 dark:text-gray-300">أنشئ أنواع متعددة من التذاكر، حدد الأسعار، وادر الحجوزات بسهولة.</p>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center mb-4 text-green-600 dark:text-green-400 text-2xl">📊</div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">تقارير وتحليلات</h3>
            <p class="text-gray-600 dark:text-gray-300">احصل على تقارير مفصلة عن الحضور، الإيرادات، وأداء الفعاليات.</p>
          </div>

          <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center mb-4 text-purple-600 dark:text-purple-400 text-2xl">⏰</div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">تذكيرات تلقائية</h3>
            <p class="text-gray-600 dark:text-gray-300">أرسل تذكيرات تلقائية للحضور وتحديثات الفعاليات عبر البريد الإلكتروني.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats -->
    <section class="py-16 container mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
        <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">500+</div>
        <div class="text-gray-600 dark:text-gray-300">فعالية ناجحة</div>
      </div>
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
        <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">50K+</div>
        <div class="text-gray-600 dark:text-gray-300">تذكرة مباعة</div>
      </div>
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
        <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">100+</div>
        <div class="text-gray-600 dark:text-gray-300">منظم فعاليات</div>
      </div>
      <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
        <div class="text-4xl font-bold text-orange-600 dark:text-orange-400 mb-2">24/7</div>
        <div class="text-gray-600 dark:text-gray-300">دعم فني</div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-16 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center">
      <h2 class="text-3xl md:text-4xl font-bold mb-4">مستعد للبدء؟</h2>
      <p class="text-xl mb-8 opacity-90">انضم إلى آلاف المنظمين الذين يثقون بنا</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <Link
          :href="route('register')"
          class="px-8 py-3 bg-white text-blue-600 rounded-lg hover:bg-gray-100 transition duration-200 font-semibold text-lg"
        >
          إنشاء حساب مجاني
        </Link>
        <Link
          :href="route('login')"
          class="px-8 py-3 border-2 border-white text-white rounded-lg hover:bg-white/10 transition duration-200 font-semibold"
        >
          تسجيل الدخول
        </Link>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 text-center">
      <p class="text-gray-400">© 2025 EventHub - جميع الحقوق محفوظة</p>
    </footer>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';

export default {
  name: "WelcomePage",
  components: { Head, Link },
  props: {
    canLogin: { type: Boolean, default: true },
    canRegister: { type: Boolean, default: true },
  },
  methods: {
    route(name) {
      const routes = {
        login: "/login",
        register: "/register",
        dashboard: "/dashboard",
        events: "/events",
      };
      return routes[name] || "/";
    },
  },
  mounted() {
    console.log("✅ EventHub الصفحة جاهزة!");
  },
};
</script>

<style scoped>
body {
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.shadow-lg {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
.dark .shadow-lg {
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.transform:hover {
  transform: scale(1.05);
}
</style>