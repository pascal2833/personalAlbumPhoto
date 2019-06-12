export const deleteImageMutation = (state) => {
  state.photoToShowInPhotosContainer.src = ''
  state.photoToShowInPhotosContainer.imageFile = ''
}
