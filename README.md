# Wirelab Default Craft Installation
This is the wirelab (wirecraft) boilerplate for all our Craft CMS projects. 

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites
Before installing you need the following software installed on your local machine:

 1. Composer ([link](https://getcomposer.org/))
 2. MySQL Server
 3. NodeJS
 4. PHP (7.2+)

### Installing
1. Create the project using either composer or git clone:
    -  Composer: `composer create-project wirelab/wirecraft [projectname]` 
    -  Git: `git clone https://github.com/wirelab/wirecraft.git [projectname]`
2. `cd [projectname]` into the project
3. Create database
   - `mysql -u [username]` (add `-p` if you have a password)
   - `create database [database-name];`
4. Run `./craft setup/index` 
    - Use as CMS username: `wirelab`
    - Generate a password using 1password or another password generator
5. Run `composer update`
6. Run `npm install`
7. Setup the environment file
    - Run `cp .env.example .env` to create the environment file. 
7. Run `npm run dev` and wait until it opens in your browser

#### Setting up your project
First you need to setup your home page.
1. Go to `http://localhost:1423/admin` and login using your credentials you set up earlier.
2. Click `Settings -> Sections -> + New section` to create a new page.
3. In the name field put `Home`. The rest should then automatically fill
4. For section type select `Single`
5. Check the checkmark below the icon of the house to make this your homepage `/`
6. For the template, put in `pages/_home.twig`
7. Create the file `templates/pages/_home.twig` (the file we just specified in the CMS backend) and paste in the following content.
    ```twig
    {% extends 'layouts/_master' %}

    {% block content %}

        Hello world!

    {% endblock %}
    ```
8. Save the file and checkout your new homepage on `http://localhost:1423/`

Then, we need to setup the plugins
1. Go to `http://localhost:1423/admin` and login using your credentials you set up earlier.
2. Click `Settings -> Plugins`
3. Install all plugins

Finally, we need to setup the first asset folder (images)*
1. Go to `http://localhost:1423/admin` and login using your credentials you set up earlier.
2. Click `Settings -> Assets`
3. Click `+ New volume`
4. In Name enter `Images`
5. Check the box (lightswitch) for `Assets have public url`
6. For the base url use `@web/assets/uploads/images`
7. For the file system path use `@webroot/assets/uploads/images`

* The static images are not uploaded into the assets folder. The assets are purely for Craft CMS and are not added to the git

### Common and known issues
There are a few issues while installing the template you need to be careful of. Many of the errors and issues are not very verbose in Craft CMS. So, if you run into things like : `an unknown error has occured` you can first verify that there isn't something wrong with your settings.

#### PHP.ini
There are some settings you need to change in the PHP.ini. The settings you need to change are usually already in the ini file, but as a comment so you can use `CRTL + F` to find the settings.

All the settings are in the `[PHP]` tag unless otherwise specified.

 1. `upload_max_filesize` to at least `32M` (default `2M`)
 2. `memory_limit` to at least `256M` (default `128M`)
 3. `max_execution_time` to at least `120` (default `30`)

Then, you probably will run into the curl certificate issue.
 1. Download and save the certificate file from: https://curl.haxx.se/docs/caextract.html
 2. In the tag `[curl]` change `curl.cainfo="<Absolute full path to file>"`
 3. In the tag `[openssl]` change `openssl.cafile="<Absolute full path to file>"`

Also, make sure you have the following extensions enabled. 
 - `curl`, `fileinfo`, `gd2`, `intl`, `pdo_mysql`

Finally, after making these changes restart your server.

#### Class 'GuzzleHttp\Client' not found
This issue sometimes happens after installing. When you changed all the php.ini settings run another `composer update`. This usually fixes the issue. If it doesn't: start Googling because this always worked for everyone so far. ):

#### MySQL Database connection
When using a newer version of MySQL the authentication method used by MySQL is not supported by Craft CMS. You know you got this issue if after step 4 in the install procedure you can't continue. `./craft setup/index`. Because it won't recognise your Mysql.

 1. Log into mysql using `mysql -u [username] -p`
 2. `SELECT user, plugin FROM mysql.user;`
 3. Verify that the user you used for the database connection in this project (usually root) uses the `mysql_native_password` plugin. If it does, you can stop here.
 4. Change the plugin using: `UPDATE mysql.user SET plugin = 'mysql_native_password' WHERE User = '[username]';` (dont forget to change `[username]` into root or whatever your username is)
 5. Run `FLUSH PRIVILEGES;` to apply your new settings. 
   
## Production build
Run `npm run build` if you are ready for production, this will minify the javascript and css files.



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
