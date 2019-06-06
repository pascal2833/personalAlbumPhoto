<template>
  <div class="add-photos">
    <h2>Ici, tu peux ajouter ta photo :)</h2>
    <form @submit.prevent="submit">
      <download-image></download-image>
      <label class="add-photos__labels" for="photoTitleInput">Titre de la photo :(*)</label>
      <input class="add-photos__inputs" type="text" placeholder="Titre de la photo" v-model="form.photoTitle" id="photoTitleInput">
      <label class="add-photos__labels" for="photoDateInput">Date de la photo :(*)</label>
      <template>
        <date-pick v-model="form.date" class="add-photos__inputs" id="photoDateInput"></date-pick>
      </template>
      <label class="add-photos__labels" for="photoCategoriesInput">Categorie :(*)</label>
      <select class="add-photos__inputs" v-model="form.categoriesSelected" id="photoCategoriesInput">
        <option>Toutes les photos</option>
        <option>Les potos</option>
        <option>La famille</option>
        <option>La famille et les potos</option>
        <option>Autres</option>
      </select>
      <label class="add-photos__labels" for="photoDescriptionInput">Description :</label>
      <textarea
        class="add-photos__inputs text-area"
        cols="30" rows="10"
        v-model="form.description"
        placeholder="Si tu veux, tu peux entrer une description"
        id="photoDescriptionInput"
      >
      </textarea>
      <div class="gnalFormErrorMessage" v-if="$v.form.$error">
        Il manque des choses ...
      </div>
      <button
        class="add-photos__submit-button"
        type="submit"
      >
        Valide ma Kounich !!!</button>
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
// import axios from 'axios'
import 'vue-date-pick/dist/vueDatePick.css'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import { required } from 'vuelidate/lib/validators'
import downloadImage from '../downloadImage/downloadImage'
import { AsynRequests } from '../../services/Asyn_requests'
export default {
  name: 'addPhotos',
  components: {
    DatePick,
    Loading,
    downloadImage
  },
  data: function () {
    return {
      form: {
        photoTitle: '',
        date: '',
        description: '',
        categoriesSelected: '',
        photoDownloaded: null
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
      categoriesSelected: { required },
      photoDownloaded: { required }
    }
  },
  methods: {
    uploadPhotos (fileInfo) {
      this.form.photoDownloaded = new FormData()
    },
    submit () {
      this.$v.form.$touch()
      if (!this.$v.form.$error) {
        this.loading.isLoading = true
        const paramsToPass = {
          title: this.form.photoTitle,
          date: this.form.date,
          category: this.form.categoriesSelected,
          description: this.form.description,
          photoDownloaded: this.form.photoDownloaded
        }
        AsynRequests.createPhotos(paramsToPass)
          .then((response) => {
            // TODO: show success message.
            this.loading.isLoading = false
          })
          .catch((error) => {
            console.log(error) // TODO: show error message.
            this.loading.isLoading = false
          })
      }
    },
    getActualDate: () => {
      const actualDate = new Date()
      const year = actualDate.getFullYear()
      const month = actualDate.getMonth() + 1
      const day = actualDate.getDate()
      return `${year}-${month}-${day}`
    }
  }
}

</script>

<style lang="scss" scoped src="./addPhotos.scss"></style>
