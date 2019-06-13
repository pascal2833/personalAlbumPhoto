<template>
  <div v-if="visible">
    <h2 class="no-margin">Ici, tu peux chercher tes photos :)</h2>
    <form @submit.prevent="submit">
      <label class="labels-4-inputs" for="photoDateInputStart">Debut de la periode (*) :</label>
      <template>
        <date-pick
          v-model="form.initialDate"
          class="main-inputs"
          id="photoDateInputStart"
          :displayFormat="'DD.MM.YYYY'"
        >
        </date-pick>
      </template>
      <label class="labels-4-inputs" for="photoDateInputEnd">Fin de la periode (*) :</label>
      <template>
        <date-pick
          v-model="form.endDate"
          class="main-inputs"
          id="photoDateInputEnd"
          :displayFormat="'DD.MM.YYYY'"
        >
        </date-pick>
      </template>
      <!--///-->
      <label class="labels-4-inputs" for="photoCategoriesInput">Categorie (*) :</label>
      <select class="main-inputs" id="photoCategoriesInput" v-model="form.categoriesSelected">
        <option>Toutes les photos</option>
        <option>Les potos</option>
        <option>La famille</option>
        <option>La famille et les potos</option>
        <option>Autres</option>
      </select>
      <button
        class="main-submit-button"
        type="submit"
      >
        Cherche les photos !!!
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
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import axios from 'axios'
import { AsynRequestsParams } from '../../services/Asyn_requests_params'
export default {
  name: 'searchPhotos',
  components: {
    DatePick,
    Loading
  },
  props: {
    visible: {
      type: Boolean
    }
  },
  data: function () {
    return {
      form: {
        initialDate: '1976-03-22',
        endDate: '2019-12-06',
        categoriesSelected: ''
      },
      loading: {
        isLoading: false,
        fullPage: true
      }
    }
  },
  methods: {
    submit () {
      const params = {initialDate: this.form.initialDate, endDate: this.form.endDate, category: this.form.categoriesSelected}
      console.log(params)
      axios.get(`${AsynRequestsParams.BASE_URL}${AsynRequestsParams.searchAction}`, {params})
        .then((response) => console.log(response))
        .catch((error) => console.error(error))
    }
  }
}
</script>
