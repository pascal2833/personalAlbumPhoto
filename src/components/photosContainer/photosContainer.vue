<template>
  <div class="photos-container">
    <img
      :class="photoToShowInPhotosContainer.horizontalOrVertical"
      class="photos-container__images-to-show"
      :src="photoToShowInPhotosContainer.src ? photoToShowInPhotosContainer.src : getPhotosToShowUrl()"
      alt="Ajoute ou cherche des photos ..."
    >
    <template v-if="numPhotosRetrievedBySearch > 1">
      <pagination-perso
        :num-numeros-to-show="Math.ceil(numPhotosRetrievedBySearch / 1)"
        :total-data="numPhotosRetrievedBySearch"
        :num-elements-to-show-at-the-same-time="1"
        :max-visible-numbers="10"
      >
      </pagination-perso>
    </template>
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
