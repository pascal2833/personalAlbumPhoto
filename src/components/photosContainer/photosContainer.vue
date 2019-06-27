<template>
  <section class="photos-container">
    <h1 class="photos-container__text-if-no-image titles" v-if="photoToShowInPhotosContainer.src === ''">
      Télécharge et cherche des photos
    </h1>
    <div class="photos-container__image-container" v-if="photoToShowInPhotosContainer.src !== ''">
      <div class="icons-container" v-if="photoInfo.title">
        <i
          class="fas fa-info-circle icon --info icons"
          title="Info de cette photo"
          @click="onInfo(photoToShowInPhotosContainer.id)"
        >
        </i>
        <i
          class="far fa-edit icon --edit icons"
          title="Editer cette photo"
          @click="onEdit(photoToShowInPhotosContainer.id)"
        >
        </i>
        <edit-photo-modale
          :show="showEditPhotoModale"
          @closeEditModalEvent="removeEditPhotoModal()"
        >
        </edit-photo-modale>
        <i
          class="far fa-trash-alt icon --delete icons"
          title="Eleminer cette photo"
          @click="onDelete(photoToShowInPhotosContainer.id)"
        >
        </i>
      </div>
      <template class="info-pop-up" v-if="showInfoMethod()">
        <info-pop-up
          :info="photoInfo"
          :show="showInfoData"
          @closeInfoPopUpEvent="removeInfoPhotoPopUp()"
        >
        </info-pop-up>
      </template>
      <img
        :class="photoToShowInPhotosContainer.horizontalOrVertical"
        class="images-to-show"
        :src="photoToShowInPhotosContainer.src ? photoToShowInPhotosContainer.src : getPhotosToShowUrl()"
        alt="Ajoute ou cherche des photos ..."
      >
    </div>
    <div class="pagination-container">
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
      :is-full-page="loading.fullPage"
    >
    </loading>
  </section>
</template>

<script>
import { mapState } from 'vuex'
import paginationPerso from '../paginationPerso/paginationPerso'
import axios from 'axios'
import { AsynRequestsParams } from '../../services/Asyn_requests_params'
import Loading from 'vue-loading-overlay'
import infoPopUp from '../infoPopUp/infoPopUp'
import editPhotoModale from '../editPhotoModale/editPhotoModale'
export default {
  name: 'photosContainer',
  components: {
    paginationPerso,
    Loading,
    infoPopUp,
    editPhotoModale
  },
  computed: {
    ...mapState({
      photoToShowInPhotosContainer: state => state.photoToShowInPhotosContainer,
      numPhotosRetrievedBySearch: state => state.numPhotosRetrievedBySearch,
      paramsToDoSearchRequestMutation: state => state.paramsToDoSearchRequestMutation,
      currentNumero: state => state.currentNumeroForPhotosPagination
    }),
    photoInfo () {
      return {
        photoDate: this.photoToShowInPhotosContainer.date,
        title: this.photoToShowInPhotosContainer.title,
        description: this.photoToShowInPhotosContainer.description,
        category: this.photoToShowInPhotosContainer.category
      }
    }
  },
  data () {
    return {
      loading: {
        isLoading: false,
        fullPage: true
      },
      showInfoData: false,
      showEditPhotoModale: false
    }
  },
  methods: {
    showAlert (text) {
      this.$swal(text)
    },
    showAdviceAlertWhenDelete (idPhoto) {
      this.$swal({
        title: `Es tu sur d'effacer cette photo ?`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui !'
      }).then((result) => {
        if (result.value) {
          this.loading.isLoading = true
          axios.get(`${AsynRequestsParams.BASE_URL}${AsynRequestsParams.deleteAction}?id=${idPhoto}`)
            .then(() => {
              this.loading.isLoading = false
              this.$swal('La photo a bien ete effacee !')
              // Pass to next photo:
              const params = {initialDate: this.paramsToDoSearchRequestMutation.initialDate, endDate: this.paramsToDoSearchRequestMutation.endDate, firstSearchOrPagination: 'firstSearch', numPageFromPagination: 1, category: this.paramsToDoSearchRequestMutation.category}
              this.$store.commit('setGlobalNumForPagination', 1)
              return axios.get(`${AsynRequestsParams.BASE_URL}${AsynRequestsParams.searchAction}`, {params})
                .then((response) => {
                  this.$store.commit('keepParamsToDoSearchRequestMutation', params)
                  this.$store.commit('setNumPhotosRetrievedBySearchMutation', response.data.length)
                  this.$store.commit('setImageDataInPhotoContainerMutation', response.data[0])
                })
                .catch(() => { // We removed the last photo so show initial data:
                  this.$store.commit('turnToInitialImageMutation')
                })
            })
            .catch(() => {
              this.showAlert('Une erreur est survenue, la photo n\'a pas pu etre eleminee')
            })
        }
      })
    },
    removeEditPhotoModal () {
      this.showEditPhotoModale = false
    },
    removeInfoPhotoPopUp () {
      this.showInfoData = false
    },
    onInfo () {
      this.showInfoData = !this.showInfoData
    },
    onEdit () {
      this.showEditPhotoModale = true
    },
    onDelete (idPhoto) {
      this.showAdviceAlertWhenDelete(idPhoto)
    },
    showInfoMethod () {
      return this.showInfoData
    },
    getPhotosToShowUrl () {
      // return require(`../../../api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}`) // Local.
      return `http://pascal-evano.org/album_photo_antoine_2/api/PhotosToShow/${this.$store.state.photoToShowInPhotosContainer.imageFile}` // For prod. Do it dynamically.
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
          this.showAlertl('Une erreur est survenue')
        })
    }
  }
}

</script>

<style lang="scss" scoped src="./photosContainer.scss"></style>
