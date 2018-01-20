skybox
======

Immersive viewer for equirectangular panoramas based on Canvas/WebGL (http://threejs.org) and Flash (http://pan0.net).

It works on desktop & mobile. It will first try to load the panorama using WebGL/Canvas and if it fails it will load it using flash. 

*********************************************************
*You can see it working here: http://vr.andeandaran.com*

configuration/installation
--------------------------

You'll need an Apache Server running at least PHP 5.6, 'short tags' must be enabled.

Download code and open MY_constants.php located at /app/config, add your Flickr api key, your 500px api key and your Imgur client ID and save file as 'constants.php'.

```php
define ('FL_KEY', '--------YOUR FLICKR API KEY--------');

define ('PX500_KEY', '--------YOUR FLICKR API KEY--------');

define ('IMGUR_CLIENT_ID', '--------YOUR IMGUR CLIENT ID--------');

```

folder structure/contents
---------------

```
project   
│
└─── app (MVC)
|     └─── config (constants & routes)  
|     └─── controller (controllers)  
|     └─── core (MVC core files)  
|     └─── libraries (cache library)  
|     └─── model (models)  
|     └─── view (views)    
└───resources (public content)
|     └─── css (css)  
|     └─── data (preloadade panoramas json)  
|     └─── embed (flash viewer files)  
|     └─── img (forntend images)  
|     └─── js (js files)  
|     |    └─── vendor (js plugins/frameworks)    
|     └─── textures (preloadede panorama images)

```


custom MVC disclaimer
---------------------

The project uses a custom MVC. 
It was developed by the end of 2013 and it is inspired in codeigniter 2.0 so it follows some of its principles. 
I did not use Codeigniter or Symfony because I wanted to keep this project simple, lightweight and take advantage of the MVC principle.

It's just a proof of concept I did to learn the basics of boulding an MVC from scratch so it lacks lots of functionalities found on real MVCs out there

It includes 
- basic routing (/app/config/routes.php)
- models
- views 
- controllers
- cache system (file based, could be changed to use memcached)

It lacks
- error handling
- class loaders are quite simple
- inheritance and DI is not the main feature 


tasklist
--------

* [ ] redesign frontend
* [ ] update three.js version (using:58 - curren:90)
* [ ] add support for mobile sensors (accelerometer)
* [ ] geolocate panoramas (using openStreetMap)
* [ ] add MySQL databases to MVC & use a database instead of JSON files? Namespaces? better Error Control/exception handling? Unit Testing?... maybe use a real MVC framework :P ?


known bugs
--------

* pressing back (using the interface button) on one of the panoramas shown on the home page returns a "404 Not Found page"
