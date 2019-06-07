<template>
  <section
    class="sidebar-menu"
    @mouseover="hoverOnSideBarMenu = true"
    @mouseleave="hoverOnSideBarMenu = false"
  >
    <div class="sidebar-menu__little">
      <i class="fas fa-search"></i>
      <i class="fas fa-camera"></i>
    </div>
    <!--v-if="hoverOnSideBarMenu"-->
    <div class="sidebar-menu__extended" v-if="hoverOnSideBarMenu">
      <search-photos></search-photos>
      <add-photos></add-photos>
    </div>
  </section>
</template>

<script>

import searchPhotos from '../searchPhotos/searchPhotos'
import addPhotos from '../addPhotos/addPhotos'
export default {
  name: 'sidebarMenu',
  components: {
    searchPhotos,
    addPhotos
  },
  data () {
    return {
      hoverOnSideBarMenu: false
    }
  }
}
</script>

<style lang="scss" scoped src="./sidebarMenu.scss"></style>
