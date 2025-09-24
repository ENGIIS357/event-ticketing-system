<template>
  <div>
    <h2>رفع صورة للفعالية: {{ event.title }}</h2>
    <input type="file" @change="onFileChange" />
    <button @click="uploadImage">رفع الصورة</button>

    <div v-if="event.image">
      <h3>الصورة الحالية:</h3>
      <img :src="event.image_url" alt="Event Image" width="200" />
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: ['event'],
  data() {
    return { file: null }
  },
  methods: {
    onFileChange(e) {
      this.file = e.target.files[0]
    },
    async uploadImage() {
      if (!this.file) {
        this.$toast.error('اختر صورة أولاً')
        return
      }

      const formData = new FormData()
      formData.append('image', this.file)

      try {
        await axios.post(`/api/v1/events/${this.event.id}/upload`, formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        this.$toast.success('تم رفع الصورة بنجاح')
        // تحديث البيانات بعد رفع الصورة
        this.$emit('refresh')
      } catch (err) {
        this.$toast.error('حدث خطأ أثناء رفع الصورة')
      }
    }
  }
}
</script>
