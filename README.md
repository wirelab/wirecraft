# Wirelab Default Craft Installation
This is the wirelab (wirecraft) boilerplate for all our Craft CMS projects. 

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites
Before installing you need the following software installed on your local machine:

 1. Composer ([link](https://getcomposer.org/))
 2. MySQL Server
 3. NodeJS (v12)
 4. PHP (7.2+)

### Installing
1. Create the project using either composer or git clone:
    -  Composer: `composer create-project wirelab/wirecraft [projectname]` 
    -  Git: `git clone https://github.com/wirelab/wirecraft.git [projectname]`
2. `cd [projectname]` into the project
3. Create database
   - `mysql -u [username]` (add `-p` if you have a password)
   - `create database [database-name];`
4. Run `composer install`
5. Run `./craft setup/index` 
    - Use as CMS username: `wirelab`
    - Generate a password using 1password or another password generator
6. Run `composer update`
7. Run `npm install`
8. Setup the environment file
    - Run `cp .env.example .env` to create the environment file. 
9. Run `npm run dev` and wait until it opens in your browser

Then, we need to install all the plugins we use into your new project.
1. Go to `http://localhost:1423/admin` and login using your credentials you set up earlier.
2. Click `Settings -> Plugins`
3. Install all plugins

#### Setting up your project
To setup the rest of your project, checkout the [Tutorials](https://github.com/wirelab/wirecraft/wiki/Tutorials)

### Common and known issues
When encountering issues while setting up, or later on in the project, please checkout the wiki page with [Known Issues](https://github.com/wirelab/wirecraft/wiki/Known-Issues).
   
## Production build
Run `npm run build` if you are ready for production, this will minify the javascript and css files.

_TODO link to the deployment page on our wiki_

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


_By Wirelab_
