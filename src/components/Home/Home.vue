<template>
    <div class="home">
      <template>
        <sidebar-menu :menu="menu" />
      </template>
      <template>
        <photos-container></photos-container>
      </template>
    </div>
</template>

<script>

import { SidebarMenu } from 'vue-sidebar-menu'
import photosContainer from '../photosContainer/photosContainer'
export default {
  name: 'Home',
  components: {
    SidebarMenu,
    photosContainer
  },
  data () {
    return {
      menu: [
        {
          header: true,
          title: 'Main Navigation'
          // component: componentName
          // visibleOnCollapse: true
          // class:''
          // attributes: {}
        },
        { // item
          href: '/',
          title: 'Dashboard',
          icon: 'fa fa-user'
          /*
          // custom icon
          icon: {
              element: 'span',
              class: 'fa fa-user',
              attributes: {}
          }
          */
          // disabled: true
          // class: ''
          // attributes: {}
          // alias: '/path'
          /*
          badge: {
              text: 'new',
              class: 'default-badge'
              // attributes: {}
              // element: 'span'
          }
          */
        },
        { // item with child
          href: '/charts',
          title: 'Charts',
          icon: 'fa fa-chart-area',
          child: [
            {
              href: '/charts/sublink',
              title: 'Sub Link'
            }
          ]
        }
      ]
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped src="./home.scss"></style>
