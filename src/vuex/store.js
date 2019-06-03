import * as actions from './actions/'
import * as mutations from './mutations/'
import { state } from './state'

export default {
  state,
  mutations: {
    ...mutations
  },
  actions: {
    ...actions
  },
  getters: {
  }
}
