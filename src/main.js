import Vue from 'vue'
import Vuex from 'vuex'
import App from './App'
import router from './router'
import vuexStore from './vuex/store'

Vue.config.productionTip = false
Vue.use(Vuex)

const store = new Vuex.Store(vuexStore)
/* eslint-disable no-new */
// let router = null

// router = configRouter(VueRouter)
new Vue({
  el: '#app',
  store,
  router,
  template: '<App/>',
  components: {App}
})
