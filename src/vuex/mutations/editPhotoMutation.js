export const editPhotoMutation = (state, dataToPass) => {
  if (dataToPass.toEdit === 'title') {
    state.photoToShowInPhotosContainer.title = dataToPass.value
  } else if (dataToPass.toEdit === 'date') {
    state.photoToShowInPhotosContainer.date = dataToPass.value
  } else if (dataToPass.toEdit === 'category') {
    state.photoToShowInPhotosContainer.date = dataToPass.value
  } else if (dataToPass.toEdit === 'description') {
    state.photoToShowInPhotosContainer.description = dataToPass.value
  }
}
