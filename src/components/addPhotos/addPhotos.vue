<template>
  <div class="add-photos" v-if="visible">
    <h2 class="no-margin">Ici, tu peux ajouter ta photo :)</h2>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <download-image></download-image>
      <label class="labels-4-inputs" for="photoTitleInput">Titre de la photo (*) :</label>
      <input class="main-inputs" type="text" placeholder="Titre de la photo" v-model="form.photoTitle" id="photoTitleInput">
      <label class="labels-4-inputs" for="photoDateInput">Date de la photo (*) :</label>
      <template>
        <date-pick
          v-model="form.date"
          class="main-inputs"
          id="photoDateInput"
          :displayFormat="'YYYY-MM-DD'"
        >
        </date-pick>
      </template>
      <label class="labels-4-inputs" for="photoCategoriesInput">Categorie (*) :</label>
      <multiselect
        v-model="value4Multiselect"
        :options="options4Multiselect"
        :searchable="false"
        :close-on-select="false"
        :show-labels="false"
      >
      </multiselect>
      <!--<select class="main-inputs" v-model="form.categoriesSelected" id="photoCategoriesInput">
        <option>Les potos</option>
        <option>La famille</option>
        <option>La famille et les potos</option>
        <option>Autres</option>
      </select>-->
      <label class="labels-4-inputs" for="photoDescriptionInput">Description :</label>
      <textarea
        class="main-inputs text-area"
        cols="30" rows="5"
        v-model="form.description"
        placeholder="Si tu veux, tu peux entrer une description"
        id="photoDescriptionInput"
      >
      </textarea>
      <div class="gnalFormErrorMessage" v-if="$v.form.$error">
        Il manque des choses ...
      </div>
      <div class="gnalFormErrorMessage" v-if="!photoDownloaded">
        Il faut telecharger une photo ...
      </div>
      <button
        class="main-submit-button"
        type="submit"
      >
        Garder la photo !!!
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
import { required } from 'vuelidate/lib/validators'
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
      photoDownloaded: state => state.photoDownloaded,
      imageFile: state => state.photoToShowInPhotosContainer.imageFile
    })
  },
  data: function () {
    return {
      value4Multiselect: '',
      options4Multiselect: ['Les potos', 'La famille', 'La famille et les potos', 'Vacances', 'Belles photos', 'Autres'],
      form: {
        photoTitle: '',
        date: '2019-12-06',
        description: '',
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
      photoTitle: { required },
      date: { required },
      categoriesSelected: { required }
    }
  },
  methods: {
    submit () {
      this.$v.form.$touch()
      if (!this.$v.form.$error && this.photoDownloaded === true) {
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
              alert('la photo a ete enregistree')
            } else {
              this.loading.isLoading = false
              alert('La photo n\'a pas pu etre enregistree. Verifier que tout est correct')
            }
          })
          .catch(() => {
            this.loading.isLoading = false
            alert('La photo n\'a pas pu etre enregistree. Verifier que tout est correct (il s\'agit peut etre aussi d\'une erreur de notre part ...)')
          })
      }
    }
  }
}

</script>

<style lang="scss" scoped src="./addPhotos.scss"></style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
