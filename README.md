# Wirelab Default Craft Installation

## Build instructions
1. `composer create-project roy-veldman/wirecraft [projectname]`
2. `cd` into the project
3. create database
   - `mysql -u [username]` (add `-p` if you have a password)
   - `create database [database-name];`
4. run `./craft setup/index`
5. run `composer update`
6. run `npm install`
7. run `npm run dev`
8. Login to the back-end
   - Setup the homepage
   - Go to settings -> plugins, and install the plugins
   - Create Assets in the uploads folder `@web/assets/uploads/{images}`
   
* Created an uploads folder for all the images and files you set-up in craft, this folder does not get pushed so you won't have any conflicts with local and production. The static images that are hardcoded or static icons are in the actual image or icons folder, these can be pushed.
   
### Production build
run `npm run build` if you are ready for production, this will minify the javascript and css files.
   
## Starting instructions
If you created a homepage on the back-end of craft, whether is a single page or a structure you can start with the code below.
* Example of the filename `pages/_entry.twig`

```twig
{% extends 'layouts/_master' %}

{% block content %}

      {# content comes here #} 

{% endblock %}
```

## Additional information

#### VueJS
* VueJs is already standard in the boilerplate, if you want to make use of it, follow the following steps:
* Inside app.js
```
import Vue from 'vue'

new Vue({
    el: [targetElement]
});
```
* Inside JS folder
    * create components folder
    * create `.vue` files
* In the `.vue` files you can also access the global variables from your scss files, if you want to add or change this go into `webpack.common.js` and configure the `configureCssLoader()`

#### Jquery
* If you want to use Jquery on your project (which i don't recommend), follow the steps below
* All these changes are in the `webpack.common.js`

```javascript
// At the top of the file add the webpack variable
const webpack = require('webpack'); 

// Inside the plugins add the following plugin, 
// Add this below the CopyWebpackPlugin
new webpack.ProvidePlugin({
    $: 'jquery',
    jQuery: 'jquery'
})
```

### Boilerplate information
* Craft CMS (clean install)
* Basic folder structure
    * Src folder with JS and SCSS
    * Starting files ( `app.scss` / `app.js` )
    * Standard mobile mixin ( already includes in `app.scss` ) 
    * Layout folder with `_master.twig` file, which contains basic layout file ( css and js includes aswell as seo plugin )
* Craft Module
    * Cache busting (gives the css and js files a version number)
* Craft Plugins 
    * Entry instructions
    * Super table
    * SEO
    * Redactor
* Webpack (for compiling css and js)
    * ES6 functionality
    * SCSS
    * VueJS
    * File-loader
    * Babel
    * Copying static assets ( standard fonts and icons )
    * Minify CSS and JS on production ( prefix included! )
    * Live server with hot reload
    * Clean files plugin ( removes unused css and js files from assets folder )


_By Roy Veldman_