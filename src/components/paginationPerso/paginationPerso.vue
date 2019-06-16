<template>
  <div class="pagination-perso">
    currentNumero: {{currentNumero}}
    <i class="fas fa-backward pagination-perso__icons" @click="gotToFirstNumero(1)"></i>
    <i
      class="fas fa-caret-left pagination-perso__icons little"
      @click="gotToPreviousNumero()"
      :class="{isDisabled: isInFirstNumero}"
    >
    </i>
    <div
      v-for="numero in numNumeros"
      :key="numero.num"
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
    <i class="fas fa-forward pagination-perso__icons" @click="gotTolastNumero(numNumerosToShow)"></i>
  </div>
</template>

<script>
export default {
  name: 'paginationPerso',
  computed: {
    firstNumero () {
      if (this.currentNumero === 1) {
        return 1
      }
      if (this.currentNumero === this.numNumerosToShow) {
        return this.currentNumero - this.numNumerosToShow + 1
      }
      return this.currentNumero - 1
    },
    endPage () {
      return Math.min(this.firstNumero + this.maxVisibleNumbers - 1, this.numNumerosToShow)
    },
    numNumeros () {
      const range = []
      for (let i = this.firstNumero; i <= this.endPage; i += 1) {
        range.push({
          num: i,
          isDisabled: i === this.currentNumero
        })
      }
      return range
    },
    isInFirstNumero () {
      return this.currentNumero === 1
    },
    isInLastNumero () {
      return this.currentNumero === this.numNumerosToShow
    }
  },
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
