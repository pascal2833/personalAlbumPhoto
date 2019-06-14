<template>
  <section class="sidebar-menu">
    <div class="sidebar-menu__little">
      <i class="fas fa-camera icons" title="Ajoute des photos" @click="showAddPhotoMenuOrNot()"></i>
      <i class="fas fa-search icons" title="Cherche des photos" @click="showSearchPhotoMenuOrNot()"></i>
    </div>
    <!--"-->
    <div class="sidebar-menu__extended" v-if="!minimizeSidebarMenu">
      <i class="fas fa-chevron-left icons minimize-icon" @click="minimizeSideBar()" title="Diminuer le menu lateral"></i>
      <search-photos :visible="searchPhotoMenuIsVisible"></search-photos>
      <add-photos :visible="addPhotoMenuIsVisible"></add-photos>
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
      minimizeSidebarMenu: true,
      addPhotoMenuIsVisible: false,
      searchPhotoMenuIsVisible: false
    }
  },
  methods: {
    showAddPhotoMenuOrNot () {
      this.$store.commit('deleteImageMutation')
      if (this.minimizeSidebarMenu) {
        this.addPhotoMenuIsVisible = true
      } else {
        this.searchPhotoMenuIsVisible = false
        this.addPhotoMenuIsVisible = true
      }
      this.extendSideBar()
    },
    showSearchPhotoMenuOrNot () {
      if (this.minimizeSidebarMenu) {
        this.searchPhotoMenuIsVisible = true
      } else {
        this.addPhotoMenuIsVisible = false
        this.searchPhotoMenuIsVisible = true
      }
      // this.searchPhotoMenuIsVisible = !this.searchPhotoMenuIsVisible
      this.extendSideBar()
    },
    minimizeSideBar () {
      this.minimizeSidebarMenu = true
      this.addPhotoMenuIsVisible = false
      this.searchPhotoMenuIsVisible = false
    },
    extendSideBar () {
      this.minimizeSidebarMenu = false
    }
  }
}
</script>

<style lang="scss" scoped src="./sidebarMenu.scss"></style>
