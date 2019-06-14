<template>
  <div class="photos-container">
    <img
      :class="photoToShowInPhotosContainer.horizontalOrVertical"
      class="photos-container__images-to-show"
      :src="photoToShowInPhotosContainer.src ? photoToShowInPhotosContainer.src : getPhotosToShowUrl()"
      alt="Ajoute ou cherche des photos ..."
    >
    <pagination-perso></pagination-perso>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import paginationPerso from '../paginationPerso/paginationPerso'
export default {
  name: 'photosContainer',
  components: {
    paginationPerso
  },
  computed: {
    ...mapState({
      photoToShowInPhotosContainer: state => state.photoToShowInPhotosContainer,
      numPhotosRetrievedBySearch: state => state.numPhotosRetrievedBySearch
    })
  },
  methods: {
    getPhotosToShowUrl () {
      return require(`../../../api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}`) // Local.
      // return `http://pascal-evano.org/album_photo_antoine_2/api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}` // For prod. Do it dynamically.
    }
  }
}

</script>

<style lang="scss" scoped src="./photosContainer.scss"></style>
