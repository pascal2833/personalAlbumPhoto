<template>
  <div class="add-photos">
    <label class="add-photos__labels">Titre de la photo : (*)</label>
    <input class="add-photos__inputs" type="text" placeholder="Titre de la photo" v-model="photoTitle">
    <label class="add-photos__labels">Date de la photo : (*)</label>
    <template>
      <date-pick v-model="date" class="add-photos__inputs"></date-pick>
    </template>
    <label class="add-photos__labels">Categorie : (*)</label>
    <select class="add-photos__inputs multiselect" v-model="categoriesSelected" multiple>
      <option disabled>Choisi une ou plusieurs categories</option>
      <option>Toutes les photos</option>
      <option>Les potos</option>
      <option>La famille</option>
      <option>La famille et les potos</option>
      <option>Autres</option>
    </select>
    <label class="add-photos__labels">Description :</label>
    <textarea  class="add-photos__inputs" cols="30" rows="10" v-model="description" placeholder="Si tu veux, tu peux entrer une description"></textarea>
    <button @click="createPhoto" class="add-photos__submit-button" type="submit">Valide ma Kounich !!!</button>
  </div>
</template>

<script>
import DatePick from 'vue-date-pick'
import axios from 'axios'
import 'vue-date-pick/dist/vueDatePick.css'
export default {
  name: 'addPhotos',
  components: {
    DatePick
  },
  data: function () {
    return {
      photoTitle: '',
      date: this.getActualDate(),
      category: '',
      description: ''
    }
  },
  methods: {
    getActualDate: () => {
      const actualDate = new Date()
      const year = actualDate.getFullYear()
      const month = actualDate.getMonth() + 1
      const day = actualDate.getDate()
      return `${year}-${month}-${day}`
    },
    createPhoto () {
      axios.post('http://pascal-evano.org/album_photo_antoine_2/api/photos/create.php', {
        name: 'fotos1',
        title: this.photoTitle,
        description: this.description
      })
        .then(function (response) {
          console.log(response)
        })
        .catch(function (error) {
          console.log(error)
        });
    }
  }
}

</script>

<style lang="scss" scoped src="./addPhotos.scss"></style>
