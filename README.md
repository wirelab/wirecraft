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

### Creating project
1. `git clone https://github.com/wirelab/wirecraft.git [projectname]`
2. `cd [projectname]` into the project
3. Create database using your favorite DBMS like [Sequel Pro](https://www.sequelpro.com/) or [MySQL Workbench](https://www.mysql.com/products/workbench/) __or__ use the commands below.
    - `mysql -u [username]` (add `-p` if you have a password)
    - `create database [database-name];`
4. Create brand new git
    - `rm .git`
    - `git init`
    - `git branch -m develop`
    - Create git repository on github
    - `git remote add origin <url>`
    - `git push origin develop`
    
### Installing
1. Run `composer install`
2. Run `npm install`
3. Setup the environment file
    - Run `cp .env.example .env` to create the environment file. 
4. Run `./craft setup` 
    - Use as CMS username: `wirelab`
    - Generate a password using 1password or another password generator
5. Run `npm run serve` and wait until it opens in your browser

Then, we need to install all the plugins we use into your new project.
1. Go to `http://localhost:1423/admin` and login using your credentials you set up earlier.
2. Click `Settings -> Plugins`
3. Install all plugins

#### Setting up your project
To setup the rest of your project, checkout the [Tutorials](https://github.com/wirelab/wirecraft/wiki/Tutorials)

### Common and known issues
When encountering issues while setting up, or later on in the project, please checkout the wiki page with [Known Issues](https://github.com/wirelab/wirecraft/wiki/Known-Issues).
   
## Protecting a staging environment
This boilerplate contains a way of protecting the staging, without using htaccess.

To set it up, first:
1. The environment has to be set to staging
2. A password needs to be generated, running `./craft site-module/setup/staging-password` will generate and configure a password.

You can then access the staging in two different ways:
1. Send the client a url that contains the password as a param, this is secure enough as this is mostly to keep the Google bot away:
`https://foo.bar/?stagingPassword=VALUE_HERE`. The client doesn't have to do anything and a cookie will be set.
2. If it isn't provided trough the url, the client gets redirected to a page to fill it in.

 
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
* Craft Plugins 
    * Entry instructions
    * Super table
    * SEO
    * Redactor
* Webpack (for compiling css and js)
    * ES6 functionality
    * SCSS
    * Copying static assets ( standard fonts and icons )
    * Live server with hot reload
    
_By Wirelab_
