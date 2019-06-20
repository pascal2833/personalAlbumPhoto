<template>
<div class="info-pop-up" v-if="photoToShowInPhotosContainer.imageFile !== 'defaultPhoto.png'">
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
      photoToShowInPhotosContainer: state => state.photoToShowInPhotosContainer
    })
  }
}
</script>

<style lang="scss" scoped src="./infoPopUp.scss"></style>
