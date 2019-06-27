<template>
    <div class="home">
      <template>
        <top-bar-menu4-mobile  class="only-4-mobiles"></top-bar-menu4-mobile>
      </template>
      <template>
        <sidebar-menu class="only-4-tablet-and-desktop"></sidebar-menu>
      </template>
      <template>
        <photos-container></photos-container>
      </template>
    </div>
</template>

<script>

import sidebarMenu from '../sidebarMenu/sidebarMenu'
import photosContainer from '../photosContainer/photosContainer'
import topBarMenu4Mobile from '../topBarMenu4Mobile/topBarMenu4Mobile'
export default {
  name: 'Home',
  components: {
    topBarMenu4Mobile,
    sidebarMenu,
    photosContainer
  },
  data () {
    return {
    }
  }
}
</script>

<style lang="scss" scoped src="./home.scss"></style>
