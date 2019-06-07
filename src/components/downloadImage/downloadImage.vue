<template>
  <div>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <label class="add-photos__labels" for="photoUploadInput">Choisi ta photo :(*)</label>
      <input
        id="photoUploadInput"
        type="file"
        @change="uploadPhotos($event.target.files)"
        accept="image/*"
      >
    </form>
  </div>
</template>

<script>
export default {
  name: 'downloadImage',
  methods: {
    uploadPhotos (files) {
      var preview = document.querySelector('img')
      var file = files[0]
      var reader = new FileReader()
      if (file) {
        reader.readAsDataURL(file)
      }
      reader.addEventListener('load', () => {
        preview.src = reader.result
        // const dataUrl = reader.result
      }, false)
    }
  }
}
</script>
