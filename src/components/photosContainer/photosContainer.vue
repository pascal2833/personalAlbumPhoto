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
        :total-data="numPhotosRetrievedBySearch"
        :num-elements-to-show-at-the-same-time="1"
        :max-visible-numbers="5"
        @clickOnPagination="doSearchWithPagination($event)"
      >
      </pagination-perso>
    </template>
    <loading
      :active.sync="loading.isLoading"
      :can-cancel="true"
      :is-full-page="loading.fullPage">
    </loading>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import paginationPerso from '../paginationPerso/paginationPerso'
import axios from 'axios'
import { AsynRequestsParams } from '../../services/Asyn_requests_params'
import Loading from 'vue-loading-overlay'
export default {
  name: 'photosContainer',
  components: {
    paginationPerso,
    Loading
  },
  computed: {
    ...mapState({
      photoToShowInPhotosContainer: state => state.photoToShowInPhotosContainer,
      numPhotosRetrievedBySearch: state => state.numPhotosRetrievedBySearch,
      paramsToDoSearchRequestMutation: state => state.paramsToDoSearchRequestMutation
    })
  },
  data () {
    return {
      loading: {
        isLoading: false,
        fullPage: true
      }
    }
  },
  methods: {
    getPhotosToShowUrl () {
      return require(`../../../api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}`) // Local.
      // return `http://pascal-evano.org/album_photo_antoine_2/api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}` // For prod. Do it dynamically.
    },
    doSearchWithPagination (numInPagination) {
      this.loading.isLoading = true
      const params = {initialDate: this.paramsToDoSearchRequestMutation.initialDate, endDate: this.paramsToDoSearchRequestMutation.endDate, category: this.paramsToDoSearchRequestMutation.category, firstSearchOrPagination: 'pagination', numPageForPagination: numInPagination}
      axios.get(`${AsynRequestsParams.BASE_URL}${AsynRequestsParams.searchAction}`, {params})
        .then((response) => {
          this.$store.commit('setImageDataInPhotoContainerMutation', response.data[0])
          this.loading.isLoading = false
        })
        .catch(() => {
          this.loading.isLoading = false
          alert('Une erreur est survenue')
        })
    }
  }
}

</script>

<style lang="scss" scoped src="./photosContainer.scss"></style>
