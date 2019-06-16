export const state = {
  paramsToDoSearchRequestMutation: {},
  numPhotosRetrievedBySearch: 0,
  photoDownloaded: false,
  photoToShowInPhotosContainer: {
    firstSearchOrPagination: '',
    id: null, // from response / back.
    imageFile: 'defaultPhoto.png', // To visualize photo from server. This is the default one.
    src: '', // imageCodedIn64 (to visualize photo uploaded)
    title: 'Titre a choisir apres',
    description: 'description a faire apres',
    date: 'A remplir apres',
    category: 'A choisir apres',
    creation_date: 'Va se remplir automatiquement apres',
    horizontalOrVertical: ''
  }
}
