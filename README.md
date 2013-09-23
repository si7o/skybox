skybox
======

Immersive viewer for equirectangular panoramas based on Canvas/WebGL (http://threejs.org) and Flash (http://pan0.net).

It ~~works~~ should work on desktop & mobile. If flash is not present on your computer/device, it will try to load panorama using WebGL or Canvas depending on your browser capabilities.

*********************************************************
*You can see it working here: http://vr.rollerblading.es*

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

