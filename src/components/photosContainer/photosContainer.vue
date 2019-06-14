<template>
  <div class="photos-container">
    <img
      :class="photoToShowInPhotosContainer.horizontalOrVertical"
      class="photos-container__images-to-show"
      :src="photoToShowInPhotosContainer.src ? photoToShowInPhotosContainer.src : getPhotosToShowUrl()"
      alt="Ajoute ou cherche des photos ..."
    >
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'photosContainer',
  computed: {
    ...mapState({
      photoToShowInPhotosContainer: state => state.photoToShowInPhotosContainer
    })
  },
  methods: {
    getPhotosToShowUrl () {
      // return require(`../../../api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}`) // Local.
      return `http://pascal-evano.org/album_photo_antoine_2/api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}` // For prod. Do it dynamically.
    }
  }
}

</script>

<style lang="scss" scoped src="./photosContainer.scss"></style>
