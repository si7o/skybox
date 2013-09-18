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
