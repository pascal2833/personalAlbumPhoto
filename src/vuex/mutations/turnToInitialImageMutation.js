export const turnToInitialImageMutation = (state) => {
  state.photoToShowInPhotosContainer = {
    firstSearchOrPagination: '',
    id: null, // From response / back.
    imageFile: 'defaultPhoto.png', // To visualize photo from server. This is the default one.
    src: '', // imageCodedIn64 (to visualize photo uploaded)
    title: '',
    description: '',
    date: '',
    category: '',
    creation_date: '', // From response / back.
    horizontalOrVertical: ''
  }
}
