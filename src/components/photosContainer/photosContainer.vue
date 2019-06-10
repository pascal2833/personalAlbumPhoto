<template>
  <div class="photos-container">
    <img
      :class="photoToShowInPhotosContainer.horizontalOrVertical"
      class="photos-container__images-to-show"
      :src="photoToShowInPhotosContainer.src"
      alt="Image preview..."
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
      return require(`../../../api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.name}`)
      // return require(`${this.$store.state.photoToShowInPhotosContainer.src}`)
    }
  }
}

</script>

<style lang="scss" scoped src="./photosContainer.scss"></style>
