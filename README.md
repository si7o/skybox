skybox
======

Immersive viewer for equirectangular panoramas based on Canvas/WebGL (http://threejs.org) and Flash (http://pan0.net).

It works on desktop & mobile. It will first try to load the panorama using WebGL/Canvas and if it fails it will load it using flash. 

*********************************************************
*You can see it working here: http://vr.andeandaran.com*

configuration
-------------

Open MY_constants.php located at /app/config, add your Flickr api key and yout Imgur client ID and save file as 'constants.php'.

```php
define ('FL_KEY', '--------YOUR FLICKR API KEY--------');

define ('IMGUR_CLIENT_ID', '--------YOUR IMGUR CLIENT ID--------');

```


tasklist
--------

* [ ] geolocate panoramas (using openStreetMap)
* [ ] add MySQL databases to MVC &  use a database instead of JSON files?
* [ ] add support for 500px


known bugs
--------

* pressing back (using the interface button) on one of the panoramas shown on the home page returns a "404 Not Found page"
