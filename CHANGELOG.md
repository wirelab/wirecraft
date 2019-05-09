# Changelog

## 1.1.3 - 2019-02-12
## Added
- Added author and license to `composer.json`

## 1.1.2 - 2019-02-04
## Update
- Updated packages
- Added VueJS standard in the webpack
- Updated `README.md`
- Added ProjectConfig in the `general.php` file so database get's synced from local to acceptance and production.

## 1.1.1 - 2019-01-18
## Update
- Craft updated to `3.1`
- Created a uploads folder for files (this folder does not get pushed)

## 1.1.0 - 2019-01-11
## Added
- The production build now minify both css and javascript files.
- Added `npm run build` info to the `README.md` file
- Added information how to add `Jquery` or `VueJs` to your project
- Added information what is inside this boilerplate, at the bottom of the `README.md`

## 1.0.9 - 2019-01-11
## Added
- added auto prefixer for css, using `postcss-loader` and added the `postcss.config.js` file

## 1.0.8 - 2019-01-10
## Added & Updated
- added .gitkeep files to pages & components folder in scss, so it will be pushed to git.
- updated `master.twig` to `_master.twig`
- updated `README.md` with new instructions under the heading `Starting Instructions`

## 1.0.7 - 2019-01-10
## Added
- updated the date 1.0.6 version was released, to the correct date.
- cache buster added to css and javascript files
- alternate languages set in the `master.twig`
- file loader added in `webpack.common.js` and in the `package.json` file

## 1.0.6 - 2019-01-10
### Changed
- Removed step 5 (cp .env file) from the README.md, because craft already makes this on install
- Updated the steps in the README.md, added `npm install`
- Updated the .gitignore so it pushes the storage folder but nothing inside it (to prevent error)
- Added import for the mixins file in scss
- Added semi columns at the end of the webpack functions

## 1.0.5 - 2018-12-19
### Changed
- Updated composer.json

## 1.0.4 - 2018-12-19
### Added
- Mixins to scss with standard responsive mixin

## 1.0.3 - 2018-12-17
### Changed
- Added underscore to the master.twig file
- Update readme, added info for env file

## 1.0.2 - 2018-12-17
### Changed
- Can't have uppercases in `composer.json` so set to camel casing

## 1.0.1 - 2018-12-17
### Changed
- Added version number, etc. to `composer.json`

## 1.0.0 - 2018-12-17
### Added
- Initial release