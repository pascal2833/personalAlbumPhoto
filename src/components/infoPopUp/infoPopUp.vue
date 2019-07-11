<template>
<div
  class="info-pop-up"
  v-if="imageFile !== ''"
>
  <i
    class="fas fa-times icons close-icon"
    title="Ferme la pop-up"
    @click="closeInfoPopUp()"
  >
  </i>
  <p><span class="info-pop-up__title">Categorie : </span>{{info.category}}</p>
  <p><span class="info-pop-up__title">Date : </span>{{info.photoDate}}</p>
  <p><span class="info-pop-up__title">Titre: </span>{{info.title}}</p>
  <p><span class="info-pop-up__title">Description: </span>{{info.description}}</p>
</div>

</template>

<script>
import { mapState } from 'vuex'
export default {
  name: 'infoPopUp',
  props: {
    info: {
      type: Object
    }
  },
  computed: {
    ...mapState({
      imageFile: state => state.photoToShowInPhotosContainer.imageFile
    })
  },
  methods: {
    closeInfoPopUp () {
      this.$emit('closeInfoPopUpEvent')
    }
  }
}
</script>

<style lang="scss" scoped src="./infoPopUp.scss"></style>
