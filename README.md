# albums_photos_antoine_2

##  Done to improve the old one, with photos retrieved only from the front end part. The idea is to retrieve and to cretae them with an API.

## At the moment, it's clearly a WIP... 

### TODO:
- Quit header Access-Control-Allow-Origin: / API files, and put authentification, via cookie (use OAuth?)
- Pass loading like vue mixin.
- From the back end part, send message if photo downloaded is > 4000000k and if format is not good.'
- Make it responsive
- Add transitions / sidebar menu, hamburger, ...
- Improve UI/UX:
  - Typography
  - Colors
  - ...
- Do unit testing!
- Edit modale not OK.
- Alert / are you sure to delete :
  - Improve design
  - Put texts in french
- Quit pagination when turn to add or search!
  - In fact, when we are in search, if turn to click on search, doesn't do anything, same for add.
  - Turn to initial state / photo container and pagination if we pass from add to search o reverse.
- ~~Quit Il faut telecharger une photo ...~~
- ~~Change color text input -> put in dark grey.~~
- ~~Center pagination.~~
~~- Change title button to add file (the default one, put it in french)~~
- ~~When remove photo in add photo, need to remove too photo name choosed before~~ removed.
- ~~When pass to search o add photo, turn photo to default.~~
- ~~Add actual date for end date in find and add by default.~~
~~- Add category in info.~~
  ~~- Add cross to close.~~
- ~~Quit info and coe if we add a photo~~
- ~~Add possibility to remove / edit photo.~~
  ~~- For delete, put modal to confirm before.~~
  - ~~For remove, quit file from folder!~~
- ~~Use alert modal from vue to show message and not alert()~~
- ~~Use multiselect and not single select / categories, to be able to search photos by a combination of keyword and not only one.~~

> A Vue.js project

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report

# run unit tests
npm run unit

# run all tests
npm test
```

For a detailed explanation on how things work, check out the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).
