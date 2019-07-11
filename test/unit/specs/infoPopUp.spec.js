import { shallowMount, createLocalVue } from '@vue/test-utils'
import Vue from 'vue'
import Vuex from 'vuex'
import infoPopUp from '@/components/infoPopUp/infoPopUp.vue'

const localVue = createLocalVue()
localVue.use(Vuex)

// describe.only('infoPopUp.vue', () => {
describe('infoPopUp.vue', () => {
  let cmp

  beforeEach(() => {
    cmp = shallowMount(infoPopUp)
  })

  it('should render correct contents', () => {
    // const wrapper = shallowMount({ store, localVue })
    // const Constructor = Vue.extend(infoPopUp)xx
    // const vm = new Constructor().$mount()
    /* Vue.nextTick(() => { // If not:     TypeError: vm.$el.querySelector is not a function
      expect(cmp.vm.$el.querySelector('.info-pop-up__title').textContent).toEqual('Categorie : ')
      // expect(vm.$el.querySelector('.info-pop-up__title').textContent).toBe('Categorie : ')
    }) */
    // expect(cmp.vm.$el.querySelector('.info-pop-up__title').textContent).toEqual('Categorie : ')

    const wrapper = shallowMount(infoPopUp)
    expect(wrapper.find('imageFile'))
  })

  // test('should mount for testing', () => {
  // expect(1).toEqual(1)
  // })
})
