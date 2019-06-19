<template>
<div class="info-pop-up">
  <p><span class="info-pop-up__title">Date : </span>{{info.photoDate}}</p>
  <p><span class="info-pop-up__title">Titre: </span>{{info.title}}</p>
  <p><span class="info-pop-up__title">Description: </span>{{info.description}}</p>
</div>

</template>

<script>
export default {
  name: 'infoPopUp',
  props: {
    info: {
      type: Object
    }
  }
}
</script>

<style lang="scss" scoped src="./infoPopUp.scss"></style>
