<template>
  <div class="photos-container">
    <img
      class="photos-container__images-to-show"
      :src="getPhotosToShowUrl()"
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
      photosToShowInPhotosContainer: state => state.photosToShowInPhotosContainer
    })
  },
  methods: {
    getPhotosToShowUrl () {
      return require(`../../../api/PhotosToShow/${this.$store.state.photosToShowInPhotosContainer[0].name}`)
    }
  }
}

</script>

<style lang="scss" scoped src="./photosContainer.scss"></style>
