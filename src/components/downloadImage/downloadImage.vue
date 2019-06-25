<template>
  <div>
    <div class="add-photos__upload-photo-container">
      <label class="labels-4-inputs label-to-choose-photo" for="photoUploadInput">{{text4ChoosePhotoLabel}}</label>
      <label class="labels-4-inputs photo-to-big-message" v-if="showPhotoToBigMessage">La photo est trop lourde, elle doit etre inferieure a 4Mb</label>
      <input
        class="input-to-add-photo"
        id="photoUploadInput"
        type="file"
        @change="uploadPhotos($event.target.files)"
        accept="image/*"
      >
      <i
        class="far fa-trash-alt icons"
        title="Annuler cette photo"
        @click="deletePhoto()"
      >
      </i>
    </div>
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
  props: {
    text4ChoosePhotoLabel: {
      type: String
    }
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
    deletePhoto () {
      this.$store.commit('turnToInitialImageMutation')
      this.$emit('setIfPhotoHasBeenDownloadedOrNotEvent', '')
      this.$emit('changeText4ChoosePhotoLabelEvent', 'Clique pour choisir une photo (*) :')
    },
    uploadPhotos (files) {
      this.loading.isLoading = true
      const file = files[0] // We don't want the possibility to add x photos on the same time.
      if (file.size > 4000000) {
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
            this.$emit('setIfPhotoHasBeenDownloadedOrNotEvent', 'hasBeenDownloaded')
            this.$emit('changeText4ChoosePhotoLabelEvent', 'La photo a ete choisie !')
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
