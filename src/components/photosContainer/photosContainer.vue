<template>
  <div class="photos-container">
    <div class="photos-container__image-container">
      <div class="icons-container" v-if="photoToShowInPhotosContainer.imageFile !== 'defaultPhoto.png'">
        <i class="fas fa-info-circle icon --info icons" title="Info de cette photo" @click="onInfo(showInfoData)"></i>
        <i class="far fa-edit icon --edit icons" title="Editer cette photo"></i>
        <i class="far fa-trash-alt icon --delete icons" title="Eleminer cette photo"></i>
      </div>
      <template class="info-pop-up" v-if="showInfoMethod()">
        <info-pop-up :info="info4InfoPopUp"></info-pop-up>
      </template>
      <img
        :class="photoToShowInPhotosContainer.horizontalOrVertical"
        class="images-to-show"
        :src="photoToShowInPhotosContainer.src ? photoToShowInPhotosContainer.src : getPhotosToShowUrl()"
        alt="Ajoute ou cherche des photos ..."
      >
    </div>
    <div v-if="numPhotosRetrievedBySearch > 1" class="pagination-container">
      <pagination-perso
        :current-numero="currentNumero"
        :total-data="numPhotosRetrievedBySearch"
        :num-elements-to-show-at-the-same-time="1"
        :max-visible-numbers="5"
        @clickOnPagination="doSearchWithPagination($event)"
      >
      </pagination-perso>
    </div>
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
import infoPopUp from '../infoPopUp/infoPopUp'
export default {
  name: 'photosContainer',
  components: {
    paginationPerso,
    Loading,
    infoPopUp
  },
  computed: {
    ...mapState({
      photoToShowInPhotosContainer: state => state.photoToShowInPhotosContainer,
      numPhotosRetrievedBySearch: state => state.numPhotosRetrievedBySearch,
      paramsToDoSearchRequestMutation: state => state.paramsToDoSearchRequestMutation,
      currentNumero: state => state.currentNumeroForPhotosPagination
    }),
    info4InfoPopUp () {
      return {
        photoDate: this.photoToShowInPhotosContainer.date,
        title: this.photoToShowInPhotosContainer.title,
        description: this.photoToShowInPhotosContainer.description
      }
    }
  },
  data () {
    return {
      loading: {
        isLoading: false,
        fullPage: true
      },
      showInfoData: false
    }
  },
  methods: {
    onInfo () {
      this.showInfoData = !this.showInfoData
    },
    showInfoMethod () {
      return this.showInfoData
    },
    getPhotosToShowUrl () {
      return require(`../../../api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}`) // Local.
      // return `http://pascal-evano.org/album_photo_antoine_2/api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}` // For prod. Do it dynamically.
    },
    doSearchWithPagination (numInPagination) {
      this.loading.isLoading = true
      this.$store.commit('setGlobalNumForPagination', numInPagination)
      const params = {initialDate: this.paramsToDoSearchRequestMutation.initialDate, endDate: this.paramsToDoSearchRequestMutation.endDate, category: this.paramsToDoSearchRequestMutation.category, firstSearchOrPagination: 'pagination', numPageFromPagination: numInPagination}
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
