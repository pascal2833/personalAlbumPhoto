export const state = {
  sideBarIsExtended: false,
  text4ChoosePhotoLabel: 'Clique pour choisir une photo (*) :',
  paramsToDoSearchRequestMutation: {
    initialDate: '',
    endDate: '',
    category: []
  },
  numPhotosRetrievedBySearch: 0,
  currentNumeroForPhotosPagination: 1,
  photoDownloaded: false,
  photoToShowInPhotosContainer: {
    firstSearchOrPagination: '',
    id: null, // From response / back.
    imageFile: '',
    src: '', // imageCodedIn64 (to visualize photo uploaded)
    title: '',
    description: '',
    date: '',
    category: '',
    creation_date: '', // From response / back.
    horizontalOrVertical: ''
  }
}
