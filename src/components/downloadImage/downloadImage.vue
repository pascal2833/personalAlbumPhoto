<template>
  <div>
    <label class="add-photos__labels" for="photoUploadInput">Choisi une photo (*):</label>
    <label class="add-photos__labels photo-to-big-message" v-if="showPhotoToBigMessage">La photo est trop lourde, elle doit etre inferieure a 1000k</label>
    <input
      id="photoUploadInput"
      type="file"
      @change="uploadPhotos($event.target.files)"
      accept="image/*"
    >
    <loading
      :active.sync="loading.isLoading"
      :can-cancel="true"
      :is-full-page="loading.fullPage">
    </loading>
  </div>
</template>

<script>
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
export default {
  name: 'downloadImage',
  components: {
    Loading
  },
  data: () => {
    return {
      showPhotoToBigMessage: false,
      imageCodedIn64: '',
      loading: {
        isLoading: false,
        fullPage: true
      },
      imageFile: '' // TODO: put a default one.
    }
  },
  methods: {
    uploadPhotos (files) {
      this.loading.isLoading = true
      const file = files[0]
      if (file.size > 1000000) {
        this.showPhotoToBigMessage = true
        this.loading.isLoading = false
      } else if (file) {
        this.imageFile = file
        const reader = new FileReader()
        reader.addEventListener('load', () => {
          const img = new Image()
          img.onload = () => {
            const widthImage = img.width
            const heightImage = img.height
            let verticalOrHorizontalImg = ''
            widthImage < heightImage ? verticalOrHorizontalImg = 'vertical' : verticalOrHorizontalImg = 'horizontal'
            this.$store.commit('downloadImageMutation', { imageCodedIn64: this.imageCodedIn64, verticalOrHorizontalImg, imageFile: this.imageFile })
            this.$store.commit('setImageIsDownloadedMutation', true)
          }
          img.src = reader.result
          this.imageCodedIn64 = reader.result
          this.showPhotoToBigMessage = false
          this.loading.isLoading = false
        }, false)
        reader.readAsDataURL(file)
      }
    }
  }
}
</script>

<style lang="scss" scoped src="./downloadImage.scss"></style>
