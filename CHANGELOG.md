== v0.8.0
  * Refactor MVC
  * Improve documentation

== v0.7.2
  * add some messages when no images found in flickr
  * minor chages to css
  
== v0.7.1
  * cache ttl can be wathever you need
  * added file locks for cache system

== v0.7
  * MVC core changes
  * removed *your pano* page
  * factorized views
  * minor changes to js,css,html
  * added CACHE system
  	* saves json files for flickr calls
  	* 1min, 10min & 1hour caches  
  * added Flickr functionality
  	* show latest 50 photos from flickr tagged as equirectangular / 360x180 / 180x360
  	* show all photos from a user tagged as equirectangular / 360x180 / 180x360
  	* changed views location
  	* separate controller for flickr
  

== v0.6.1
  * CSS/JS minor changes


== v0.6
  * Responsive improvements
  * Added configuration
  	* Lets the user decide between auto/flash/webgl/canvas mode
  	* saves configuration using a cookie
  * Share image button added to panorama
  * PHP views refactoring

== v0.5.1:
  * Custom 404 page
  
== v0.5:
  * Minor CSS changes
  * Home layout changes  
  * Improve responsive design
  * MVC bugs fixed
  	* default route when uri is not in routes.php
  	* allow return of view output
  * New view for the menu
  * New page for sharing your panorama
  * Error handling (max image size vs real image size) when loading file from Imgur / elsewhere and WebGL is used

== v0.4.2:
  * Error handling when loading images from flickr/imgur/elsewhere
    * load images using a proxy for cross-browser issues
    * check external image proportions before rendering panorama
    
== v0.4.1:
  * Let users view their panoramas using the viewer    

== v0.4:
  * Load images from Flickr

== v0.3:
  * Load images from Imgur

== v0.2:
  * Load external images
  

== v0.1.2:
  * Error handling with WebGL/Canvas
    * heck max-image-width supported when WebGL is used
    * Load image depending on browser/device capabilities
  * Optimize WebGL & Canvas Mesh
  
    
== v0.1:
  * Custom MVC framework

== v0.0.3:
  * Create list of panoramas (JSON file)
  * Add image preloader 

== v0.0.2:
  * Add flash support (pan0.net)
  * Add mobile compatibility 

== v0.0.1:
  * Canvas/WebGL viewer
