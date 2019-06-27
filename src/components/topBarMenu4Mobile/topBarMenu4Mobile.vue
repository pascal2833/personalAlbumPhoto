<template>
  <div class="top-bar-menu4-mobile">
    <i class="fas fa-camera icons" title="Ajoute des photos" @click="onAddPhoto()"></i>
    <i class="fas fa-search icons" title="Cherche des photos" @click="onSearchPhoto()"></i>
  </div>
</template>

<script>
import searchPhotos from '../searchPhotos/searchPhotos'
import addPhotos from '../addPhotos/addPhotos'
export default {
  name: 'topBarMenu4Mobile',
  components: {
    searchPhotos,
    addPhotos
  }
}
</script>

<style lang="scss" scoped src="./topBarMenu4Mobile.scss"></style>
