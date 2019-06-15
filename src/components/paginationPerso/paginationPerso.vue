<template>
  <div class="pagination-perso">
    <i class="fas fa-backward pagination-perso__icons" @click="clickOnGoToFirst()"></i>
    <i class="fas fa-caret-left pagination-perso__icons little"></i>
    <div v-for="page in pages" :key="page.num" class="pagination-perso__numeros">
      {{page.num}}
    </div>
    <i class="fas fa-caret-right pagination-perso__icons little"></i>
    <i class="fas fa-forward pagination-perso__icons"></i>
  </div>
</template>

<script>
import axios from 'axios'
import { AsynRequestsParams } from '../../services/Asyn_requests_params'
export default {
  name: 'paginationPerso',
  props: {
    numNumerosToShow: {
      type: Number
    },
    totalData: {
      type: Number
    },
    numElementsToShowAtTheSameTime: {
      type: Number,
      default: 5
    },
    maxVisibleNumbers: {
      type: Number,
      default: 3
    }
  },
  data () {
    return {
      currentPage: 1
    }
  },
  computed: {
    startpage () {
      if (this.currentPage === 1) {
        return 1
      }
      if (this.currentPage === this.numNumerosToShow) {
        return this.numNumerosToShow - this.maxVisibleNumbers + 1
      }
      return this.currentPage - 1
    },
    endPage () {
      return Math.min(this.startpage + this.maxVisibleNumbers - 1, this.numNumerosToShow)
    },
    pages () {
      const range = []
      for (let i = this.startpage; i <= this.endPage; i += 1) {
        range.push({
          num: i,
          isDisabled: i === this.currentPage
        })
      }
      return range
    }
  },
  methods: {
    clickOnGoToFirst () {
      this.getData(1)
        .then((response) => {
          console.log(response)
        })
        .catch(() => {
          alert('Il n\'y a pas de photos correspondant aux criteres de recherche ou une erreur est survenue')
        })
    },
    getData (numData) {
      const param = {indexPhotoToRetrieve: numData}
      return axios.get(`${AsynRequestsParams.BASE_URL}${AsynRequestsParams.getDataAfterSearchAction}`, { param })
    }
  }
}
</script>

<style lang="scss" scoped src="./paginationPerso.scss"></style>
