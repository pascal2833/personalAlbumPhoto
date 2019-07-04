<template>
  <div class="add-photos" v-if="visible">
    <h3 class="no-margin h3-perso titles">Ajoute une photo.</h3>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <download-image
        @setIfPhotoHasBeenDownloadedOrNotEvent="setIfPhotoHasBeenDownloadedOrNot($event)"
      >
      </download-image>
      <label class="labels-4-inputs" for="photoTitleInput">Titre de la photo (*) :</label>
      <input class="main-inputs" type="text" placeholder="Un super titre !" v-model="form.photoTitle" id="photoTitleInput">
      <div class="gnalFormErrorMessage" v-if="!$v.form.photoTitle.maxLength">
        Le titre ne peut pas avoir plus de 50 characteres.
      </div>
      <label class="labels-4-inputs" for="photoDateInput">Date de la photo (*) :</label>
      <template>
        <date-pick
          v-model="form.date"
          class="main-inputs date_picker"
          id="photoDateInput"
          :displayFormat="'YYYY-MM-DD'"
        >
        </date-pick>
      </template>
      <label class="labels-4-inputs" for="photoCategoriesInput">Categorie (*) :</label>
      <multiselect
        class="multiselect-perso"
        id="photoCategoriesInput"
        v-model="form.categoriesSelected"
        :options="form.options4Multiselect"
        :searchable="false"
        :close-on-select="true"
        :show-labels="false"
        placeholder="Choisi une catégorie"
        :multiple="false"
      >
      </multiselect>
      <label class="labels-4-inputs" for="photoDescriptionInput">Description :</label>
      <textarea
        class="main-inputs text-area"
        cols="30" rows="5"
        v-model="form.description"
        placeholder="Si tu veux, tu peux entrer une description"
        id="photoDescriptionInput"
      >
      </textarea>
      <div class="gnalFormErrorMessage" v-if="!$v.form.description.maxLength">
        La description ne peut pas avoir plus de 200 characteres.
      </div>
      <div class="gnalFormErrorMessage" v-if="$v.form.$error">
        Il manque des choses ou des champs sont mal remplis
      </div>
      <button
        class="main-submit-button"
        type="submit"
      >
        Garder la photo
      </button>
    </form>
    <loading
        :active.sync="loading.isLoading"
        :can-cancel="true"
        :is-full-page="loading.fullPage">
    </loading>
  </div>
</template>

<script>
import DatePick from 'vue-date-pick'
import 'vue-date-pick/dist/vueDatePick.css'
import { mapState } from 'vuex'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import { required, maxLength } from 'vuelidate/lib/validators'
import downloadImage from '../downloadImage/downloadImage'
import axios from 'axios'
import { AsynRequestsParams } from '../../services/Asyn_requests_params'
import Multiselect from 'vue-multiselect'
export default {
  name: 'addPhotos',
  components: {
    DatePick,
    Loading,
    downloadImage,
    Multiselect
  },
  props: {
    visible: {
      type: Boolean
    }
  },
  computed: {
    ...mapState({
      horizontalOrVertical: state => state.photoToShowInPhotosContainer.horizontalOrVertical,
      imageFile: state => state.photoToShowInPhotosContainer.imageFile
    })
  },
  data: function () {
    return {
      form: {
        onePhotoHasBeenDownloaded: '',
        photoTitle: '',
        date: this.getActualDateFormated(),
        description: '',
        options4Multiselect: ['Les potos', 'La famille', 'La famille et les potos', 'Vacances', 'Belles photos', 'Autres'],
        categoriesSelected: ''
      },
      loading: {
        isLoading: false,
        fullPage: true
      }
    }
  },
  validations: {
    form: {
      onePhotoHasBeenDownloaded: { required },
      photoTitle: {
        required,
        maxLength: maxLength(50)
      },
      date: { required },
      categoriesSelected: { required },
      description: {
        maxLength: maxLength(200)
      }
    }
  },
  methods: {
    setIfPhotoHasBeenDownloadedOrNot (yesOrNot) {
      this.form.onePhotoHasBeenDownloaded = yesOrNot
    },
    getActualDateFormated () {
      const actualDate = new Date()
      return `${actualDate.getFullYear()}-${actualDate.getMonth() + 1}-${actualDate.getDate()}`
    },
    showAlert (text) {
      this.$swal(text)
    },
    submit () {
      this.$v.form.$touch()
      if (!this.$v.form.$error) {
        this.loading.isLoading = true
        const formData = new FormData()
        formData.append('imageFile', this.imageFile)
        formData.append('title', this.form.photoTitle)
        formData.append('date', this.form.date)
        formData.append('category', this.form.categoriesSelected)
        formData.append('description', this.form.description)
        formData.append('horizontalOrVertical', this.horizontalOrVertical)
        const url = `${AsynRequestsParams.BASE_URL}${AsynRequestsParams.createAction}`
        axios.post(url, formData)
          .then(response => {
            if (response.status === 201) {
              this.loading.isLoading = false
              this.$store.commit('turnToInitialImageMutation')
              this.$store.commit('setText4ChoosePhotoLabelMutation', 'Clique pour choisir une photo (*) :')
              this.$store.commit('sideBarIsExtendedMutation', false)
              this.showAlert('La photo a ete enregistree')
            } else {
              this.loading.isLoading = false
              this.showAlert('La photo n\'a pas pu etre enregistree. Verifier que tout est correct')
            }
          })
          .catch(() => {
            this.loading.isLoading = false
            this.showAlert('La photo n\'a pas pu etre enregistree. Verifier que tout est correct (il s\'agit peut etre aussi d\'une erreur de notre part ...)')
          })
      }
    }
  }
}

</script>

<style lang="scss" scoped src="./addPhotos.scss"></style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
