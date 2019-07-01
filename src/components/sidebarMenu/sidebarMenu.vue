<template>
  <section class="sidebar-menu">
    <div class="sidebar-menu__little">
      <i class="fas fa-camera icons" title="Ajoute des photos" @click="onAddPhoto()"></i>
      <i class="fas fa-search icons" title="Cherche des photos" @click="onSearchPhoto()"></i>
    </div>
    <div
      class="sidebar-menu__extended"
      :class="{'only-4-tablet-and-desktop': !sideBarIsExtended}"
      v-if="!minimizeSidebarMenu"
    >
      <i class="fas fa-chevron-left icons minimize-icon only-4-tablet-and-desktop" @click="minimizeSideBar()" title="Diminuer le menu lateral"></i>
      <search-photos :visible="searchPhotoMenuIsVisible"></search-photos>
      <add-photos :visible="addPhotoMenuIsVisible"></add-photos>
    </div>
  </section>
</template>

<script>

import searchPhotos from '../searchPhotos/searchPhotos'
import addPhotos from '../addPhotos/addPhotos'
import { mapState } from 'vuex'
export default {
  name: 'sidebarMenu',
  components: {
    searchPhotos,
    addPhotos
  },
  data () {
    return {
      searchMenu: false,
      addMenu: false,
      minimizeSidebarMenu: true,
      addPhotoMenuIsVisible: false,
      searchPhotoMenuIsVisible: false
    }
  },
  computed: {
    ...mapState({
      sideBarIsExtended: state => state.sideBarIsExtended
    })
  },
  methods: {
    onAddPhoto () {
      if (!this.addMenu) {
        this.$store.commit('turnToInitialImageMutation')
        this.$store.commit('turnToInitialNumPhotosRetrievedBySearchMutation')
      }
      if (this.minimizeSidebarMenu) {
        this.addPhotoMenuIsVisible = true
      } else {
        this.searchPhotoMenuIsVisible = false
        this.addPhotoMenuIsVisible = true
      }
      this.extendSideBar()
      this.searchMenu = false
      this.addMenu = true
    },
    onSearchPhoto () {
      if (!this.searchMenu) {
        this.$store.commit('turnToInitialImageMutation')
        this.$store.commit('setText4ChoosePhotoLabelMutation', 'Clique pour choisir une photo (*) :')
      }
      if (this.minimizeSidebarMenu) {
        this.searchPhotoMenuIsVisible = true
      } else {
        this.addPhotoMenuIsVisible = false
        this.searchPhotoMenuIsVisible = true
      }
      this.extendSideBar()
      this.searchMenu = true
      this.addMenu = false
    },
    minimizeSideBar () {
      this.minimizeSidebarMenu = true
      this.addPhotoMenuIsVisible = false
      this.searchPhotoMenuIsVisible = false
    },
    extendSideBar () {
      this.minimizeSidebarMenu = false
      this.$store.commit('sideBarIsExtendedMutation', true)
    }
  }
}
</script>

<style lang="scss" scoped src="./sidebarMenu.scss"></style>
