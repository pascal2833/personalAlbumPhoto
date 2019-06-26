<template>
  <div class="pagination-perso" v-if="totalData > 1">
    <i
      class="fas fa-backward pagination-perso__icons"
      @click="gotToFirstNumero(1)"
      :class="{isDisabled: isInFirstNumero}"
    >
    </i>
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
    <i
      class="fas fa-forward pagination-perso__icons"
      @click="gotTolastNumero(maxNumero)"
      :class="{isDisabled: isInLastNumero}"
    >
    </i>
  </div>
</template>

<script>
export default {
  name: 'paginationPerso',
  computed: {
    maxNumero () {
      return Math.ceil(this.totalData / this.numElementsToShowAtTheSameTime)
    },
    firstNumeroToShow () {
      if (this.maxNumero <= this.maxVisibleNumbers) {
        return 1
      } else if (this.currentNumero <= (Math.floor(this.maxVisibleNumbers / 2))) {
        return 1
      }
      if (this.currentNumero === this.maxNumero) {
        return this.currentNumero - this.maxVisibleNumbers + 1
      }
      return this.currentNumero - Math.floor(this.maxVisibleNumbers / 2)
    },
    lastNumeroToShow () {
      if (this.maxNumero <= this.maxVisibleNumbers) {
        return this.maxNumero
      } else if (this.currentNumero <= (Math.floor(this.maxVisibleNumbers / 2))) {
        return this.maxVisibleNumbers
      } else if (this.currentNumero >= this.maxNumero - Math.floor(this.maxVisibleNumbers / 2)) {
        return this.maxNumero
      }
      return this.currentNumero + Math.floor(this.maxVisibleNumbers / 2)
    },
    numerosToShow () {
      const range = []
      for (let i = this.firstNumeroToShow; i <= this.lastNumeroToShow; i += 1) {
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
    currentNumero: {
      type: Number
    },
    totalData: {
      type: Number
    },
    numElementsToShowAtTheSameTime: {
      type: Number,
      default: 2
    },
    maxVisibleNumbers: {
      type: Number,
      default: 5
    }
  },
  methods: {
    gotToFirstNumero () {
      this.$emit('clickOnPagination', 1)
    },
    gotTolastNumero (numInPagination) {
      this.$emit('clickOnPagination', numInPagination)
    },
    gotToPreviousNumero () {
      if (!this.isInFirstNumero) {
        this.$emit('clickOnPagination', this.currentNumero - 1)
      }
    },
    gotToNextNumero () {
      if (!this.isInLastNumero) {
        this.$emit('clickOnPagination', this.currentNumero + 1)
      }
    },
    clickOnOneNumero (numInPagination) {
      this.$emit('clickOnPagination', numInPagination)
    }
  }
}
</script>

<style lang="scss" scoped src="./paginationPerso.scss"></style>
