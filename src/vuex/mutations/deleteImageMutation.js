export const deleteImageMutation = (state) => {
  state.photoToShowInPhotosContainer.src = ''
  state.photoToShowInPhotosContainer.imageFile = 'defaultPhoto.png'
}
