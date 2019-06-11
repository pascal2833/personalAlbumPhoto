<template>
  <section class="sidebar-menu">
    <div class="sidebar-menu__little">
      <i class="fas fa-chevron-right icons" @click="extendSideBar()" v-if="minimizeSidebarMenu"></i>
      <i class="fas fa-search icons"></i>
      <i class="fas fa-camera icons"></i>
    </div>
    <!--"-->
    <div class="sidebar-menu__extended" v-if="!minimizeSidebarMenu">
      <i class="fas fa-chevron-left icons minimize-icon" @click="minimizeSideBar()"></i>
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
      minimizeSidebarMenu: true
    }
  },
  methods: {
    minimizeSideBar () {
      this.minimizeSidebarMenu = true
    },
    extendSideBar () {
      this.minimizeSidebarMenu = false
    }
  }
}
</script>

<style lang="scss" scoped src="./sidebarMenu.scss"></style>
