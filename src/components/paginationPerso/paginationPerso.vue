<template>
  <div class="pagination-perso">
    totalData: {{totalData}}
    <br>
    maxNumero: {{maxNumero}}
    lastNumeroToShow: {{lastNumeroToShow}}
    firstNumeroToShow: {{firstNumeroToShow}}
    numNumerosToShow: {{numNumerosToShow}}
    currentNumero: {{currentNumero}}
    <i class="fas fa-backward pagination-perso__icons" @click="gotToFirstNumero(1)"></i>
    <i
      class="fas fa-caret-left pagination-perso__icons little"
      @click="gotToPreviousNumero()"
      :class="{isDisabled: isInFirstNumero}"
    >
    </i>
    <div
      v-for="numero in numerosToShow"
      :key="numero.num"
      :class="{isTheActiveNumero: numero.isTheActiveNumero}"
      class="pagination-perso__numeros"
      @click="clickOnOneNumero(numero.num)"
    >
      {{numero.num}}
    </div>
    <i
      class="fas fa-caret-right pagination-perso__icons little"
      @click="gotToNextNumero()"
      :class="{isDisabled: isInLastNumero}"
    ></i>
    <i class="fas fa-forward pagination-perso__icons" @click="gotTolastNumero(maxNumero)"></i>
  </div>
</template>

<script>
export default {
  name: 'paginationPerso',
  computed: {
    maxNumero () {
      return Math.ceil(this.totalData / this.numElementsToShowAtTheSameTime)
    },
    numNumerosToShow () {
      if (this.totalData <= this.maxVisibleNumbers) {
        return Math.ceil(this.totalData / this.numElementsToShowAtTheSameTime)
      } else { return this.maxVisibleNumbers }
    },
    firstNumeroToShow () {
      if (this.currentNumero === 1) {
        return 1
      }
      if (this.currentNumero === this.maxNumero) {
        return this.currentNumero - this.maxVisibleNumbers + 1
      }
      return this.currentNumero - Math.floor(this.maxVisibleNumbers / 2)
    },
    lastNumeroToShow () {
      if (this.currentNumero < (Math.floor(this.maxVisibleNumbers / 2))) {
        return this.maxVisibleNumbers
      } else return this.currentNumero + Math.floor(this.maxVisibleNumbers / 2)
    },
    numerosToShow () {
      const range = []
      for (let i = this.firstNumeroToShow; i <= (this.firstNumeroToShow + this.numNumerosToShow - 1); i += 1) {
        range.push({
          num: i,
          isTheActiveNumero: i === this.currentNumero
        })
      }
      return range
    },
    isInFirstNumero () {
      return this.currentNumero === 1
    },
    isInLastNumero () {
      return this.currentNumero === this.maxNumero
    }
  },
  props: {
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
      currentNumero: 1
    }
  },
  methods: {
    gotToFirstNumero () {
      this.currentNumero = 1
      this.$emit('clickOnPagination', 1)
    },
    gotTolastNumero (numInPagination) {
      this.currentNumero = numInPagination
      this.$emit('clickOnPagination', numInPagination)
    },
    gotToPreviousNumero () {
      if (!this.isInFirstNumero) {
        this.currentNumero = this.currentNumero - 1
        this.$emit('clickOnPagination', this.currentNumero)
      }
    },
    gotToNextNumero () {
      if (!this.isInLastNumero) {
        this.currentNumero = this.currentNumero + 1
        this.$emit('clickOnPagination', this.currentNumero)
      }
    },
    clickOnOneNumero (numInPagination) {
      this.currentNumero = numInPagination
      this.$emit('clickOnPagination', numInPagination)
    }
  }
}
</script>

<style lang="scss" scoped src="./paginationPerso.scss"></style>
