<template>
    <div class="home">
      <sidebar-menu></sidebar-menu>
      <photos-container></photos-container>
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
