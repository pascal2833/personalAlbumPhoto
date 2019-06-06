export class AsynRequests {
  static createPhotos (paramsToPass) {
    const url = 'http://pascal-evano.org/album_photo_antoine_2/api/photos/create'
    // axios.post('api/photos/create', paramsToPass) // Replace by this axios call in prod.
    return fetch(url, {
      method: 'POST',
      body: JSON.stringify(paramsToPass)
    })
  }
}
