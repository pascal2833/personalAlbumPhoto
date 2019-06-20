<template>
  <div class="edit-photo-modale-mask" v-if="show">
    <div class="edit-photo-modale-container">
      <i
        class="fas fa-times icons close-icon"
        title="Ferme la modale"
        @click="closeEditModale()"
      >
      </i>
      <form @submit.prevent="submit" enctype="multipart/form-data" class="edit-photo-modale-container__form">
        <label class="labels-4-inputs" for="editPhotoTitleInput">Titre de la photo :</label>
        <input
          class="main-inputs"
          type="text"
          @keyup="keyUpTitle($event.target.value)"
          :value="photoToShowInPhotosContainer.title"
          id="editPhotoTitleInput"
        >
        <div class="gnalFormErrorMessage" v-if="!$v.photoToShowInPhotosContainer.title.maxLength">
          Le titre ne peut pas avoir plus de 50 characteres.
        </div>
        <div class="gnalFormErrorMessage" v-if="!$v.photoToShowInPhotosContainer.title.required">
          Le titre est obligatoire.
        </div>
        <label class="labels-4-inputs">Date de la photo :</label>
        <template>
          <date-pick
            v-model="photoToShowInPhotosContainer.date"
            class="main-inputs"
            id="editPhotoDateInput"
            :displayFormat="'YYYY-MM-DD'"
            @input="changeDate($event)"
          >
          </date-pick>
        </template>
        <label class="labels-4-inputs" for="editPhotoCategoriesInput">Categorie :</label>
        <multiselect
          id="editPhotoCategoriesInput"
          :value="photoToShowInPhotosContainer.category"
          @input="changeCategory($event)"
          :options="options4Multiselect"
          :searchable="false"
          :close-on-select="true"
          :show-labels="false"
          :multiple="false"
        >
        </multiselect>
        <label class="labels-4-inputs" for="editPhotoDescriptionInput">Description :</label>
        <textarea
          class="main-inputs text-area"
          cols="40" rows="5"
          :value="photoToShowInPhotosContainer.description"
          @input="changeDescription($event.target.value)"
          id="editPhotoDescriptionInput"
        >
    </textarea>
        <div class="gnalFormErrorMessage" v-if="!$v.photoToShowInPhotosContainer.description.maxLength">
          La description ne peut pas avoir plus de 200 characteres.
        </div>
        <button
          class="main-submit-button"
          type="submit"
        >
          Editer la photo
        </button>
    </form>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import DatePick from 'vue-date-pick'
import 'vue-date-pick/dist/vueDatePick.css'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import { maxLength, minLength, required } from 'vuelidate/lib/validators'
import axios from 'axios'
import { AsynRequestsParams } from '../../services/Asyn_requests_params'
import Multiselect from 'vue-multiselect'
export default {
  name: 'editPhotoModale',
  components: {
    DatePick,
    Loading,
    Multiselect
  },
  computed: {
    ...mapState({
      photoToShowInPhotosContainer: state => state.photoToShowInPhotosContainer
    })
  },
  props: {
    show: {
      type: Boolean
    }
  },
  data: function () {
    return {
      options4Multiselect: ['Les potos', 'La famille', 'La famille et les potos', 'Vacances', 'Belles photos', 'Autres'],
      loading: {
        isLoading: false,
        fullPage: true
      }
    }
  },
  validations: {
    photoToShowInPhotosContainer: {
      title: {
        maxLength: maxLength(50),
        minLength: minLength(1),
        required
      },
      description: {
        maxLength: maxLength(200)
      }
    }
  },
  methods: {
    changeDate (value) {
      this.$store.commit('editPhotoMutation', { toEdit: 'date', value })
    },
    changeCategory (value) {
      this.$store.commit('editPhotoMutation', { toEdit: 'category', value })
    },
    changeDescription (value) {
      this.$store.commit('editPhotoMutation', { toEdit: 'description', value })
    },
    closeEditModale () {
      this.$emit('closeEditModalEvent')
    },
    keyUpTitle (text) {
      this.$store.commit('editPhotoMutation', { toEdit: 'title', value: text })
    },
    submit () {
      this.$v.form.$touch()
      if (!this.$v.form.$error) {
        this.loading.isLoading = true
        const formData = new FormData()
        formData.append('title', this.photoToShowInPhotosContainer.title)
        formData.append('date', this.photoToShowInPhotosContainer.date)
        formData.append('category', this.photoToShowInPhotosContainer.category)
        formData.append('description', this.photoToShowInPhotosContainer.description)
        const url = `${AsynRequestsParams.BASE_URL}${AsynRequestsParams.editAction}`
        axios.post(url, formData)
          .then(response => {
            if (response.status === 200) {
              this.loading.isLoading = false
              alert('la photo a ete editee')
            } else {
              this.loading.isLoading = false
              alert('La photo n\'a pas pu etre editee. Verifier que tout est correct')
            }
          })
          .catch(() => {
            this.loading.isLoading = false
            alert('La photo n\'a pas pu etre editee. Verifier que tout est correct (il s\'agit peut etre aussi d\'une erreur de notre part ...)')
          })
      }
    }
  }
}
</script>

<style lang="scss" scoped src="./editPhotoModale.scss"></style>
