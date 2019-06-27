export const turnToInitialImageMutation = (state) => {
  state.photoToShowInPhotosContainer = {
    firstSearchOrPagination: '',
    id: null, // From response / back.
    imageFile: '',
    src: '', // imageCodedIn64 (to be able to visualize photo uploaded before send other informations)
    title: '',
    description: '',
    date: '',
    category: '',
    creation_date: '', // From response / back.
    horizontalOrVertical: ''
  }
}
