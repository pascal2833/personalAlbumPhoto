// const folderWithPhotosToShow = '../../../api/PhotosToShow/'
export const state = {
  photoDownloaded: false,
  photoToShowInPhotosContainer: {
    imageFile: '', // TODO: put a default one.
    src: '', // imageCodedIn64
    name: '', // Done in back part, with id/table.
    title: 'Titre a choisir apres',
    description: 'description a faire apres',
    date: 'A remplir apres',
    category: 'A choisir apres',
    creation_date: 'Va se remplir automatiquement apres',
    horizontalOrVertical: ''
  }
}
