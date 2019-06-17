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
          :displayFormat="'YYYY-MM-DD'"
        >
        </date-pick>
      </template>
      <label class="labels-4-inputs" for="photoDateInputEnd">Fin de la periode (*) :</label>
      <template>
        <date-pick
          v-model="form.endDate"
          class="main-inputs"
          id="photoDateInputEnd"
          :displayFormat="'YYYY-MM-DD'"
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
      this.loading.isLoading = true
      const params = {initialDate: this.form.initialDate, endDate: this.form.endDate, category: this.form.categoriesSelected, firstSearchOrPagination: 'firstSearch', numPageFromPagination: 1}
      this.$store.commit('setGlobalNumForPagination', 1)
      axios.get(`${AsynRequestsParams.BASE_URL}${AsynRequestsParams.searchAction}`, {params})
        .then((response) => {
          this.$store.commit('keepParamsToDoSearchRequestMutation', params)
          this.$store.commit('setNumPhotosRetrievedBySearchMutation', response.data.length)
          this.$store.commit('setImageDataInPhotoContainerMutation', response.data[0])
          this.loading.isLoading = false
        })
        .catch(() => {
          this.loading.isLoading = false
          alert('Il n\'y a pas de photos correspondant aux criteres de recherche ou une erreur est survenue')
        })
    }
  }
}
</script>
