export const downloadImageMutation = (state, dataToPass) => {
  state.photoToShowInPhotosContainer.src = dataToPass.imageCodedIn64
  state.photoToShowInPhotosContainer.horizontalOrVertical = dataToPass.verticalOrHorizontalImg
  state.photoToShowInPhotosContainer.imageFile = dataToPass.imageFile
}
