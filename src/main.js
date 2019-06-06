import Vue from 'vue'
import Vuex from 'vuex'
import App from './App'
import router from './router'
import vuexStore from './vuex/store'
import Vuelidate from 'vuelidate'

Vue.config.productionTip = false
Vue.use(Vuex)

Vue.use(Vuelidate)

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
