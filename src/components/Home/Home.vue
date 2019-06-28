<template>
    <div class="home">
      <template>
        <sidebar-menu></sidebar-menu>
      </template>
      <template>
        <photos-container></photos-container>
      </template>
    </div>
</template>

<script>

import sidebarMenu from '../sidebarMenu/sidebarMenu'
import photosContainer from '../photosContainer/photosContainer'
export default {
  name: 'Home',
  components: {
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
