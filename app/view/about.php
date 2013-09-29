<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR viewer - about</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/resources/css/general.css" type="text/css" media='screen'/>
		
		<script src="/resources/js/jquery.min.js"></script> 
		
		<script src="/resources/js/comun.js"></script>
		<script src="/resources/js/Detector.js"></script>
		<script src="/resources/js/Cookie.js"></script>
		<script src="/resources/js/Config.js"></script>
		<script src="/resources/js/sharer.js"></script>
	</head>
	<body class="home">
	   
	   <?=$menu?>   
	   
	   <div class="about centered">
	   	   <p class="desc">	
	           I wanted a web based equirectangular panorama viewer that worked on all devices. I found none, so decieded to build mine.
	           This panorama viewer is based on Canvas, WebGL (<a href="http://threejs.org" target="_blank">threejs.org</a>) & Flash (<a href="http://pan0.net" target="_blank">pan0.net</a>) and should work on desktop & mobile (as long as you are using a 21st century browser ;) ).           	      
           </p>
           <p class="desc">
           	   It started as simple panorama viewer (for 'local' files) and then added support to show panoramas from flickr, imgur and files hosted on other servers.
           	   <br />
           	   If you think there is something missing or not working propperly, please, <a href="https://github.com/si7o/skybox/issues" target="_blank">report an issue</a>
           </p>
           <p class="desc">
           	   Source is available at <a href="https://github.com/si7o/skybox" target="_blank">https://github.com/si7o/skybox</a>
           </p>
           <div> 
           	
           <p class="desc">
           	   To share your onw equirectangular panoramas, paste the URL in the box below.
           	   <br />
           	   <strong>URLs supported</strong>
           	   <ul class="services">
	               <li>Flickr user page (it will show images tagged as 'equirectanguar' from the user)</li>
	               <li>Flickr photo page</li>
	               <li>Imgur images</li>
				   <li>Path to an image hosted on another server</li>              
	           </ul>
           </p>
            
            <div class="generate">                
               <input name="photo_url" id="photo_url" type="text" value=""/>	               
               <span id="btn_generar_url" > get url </span>
               <br />
               <span id="msg"></span>
	           <span id="url_sharer"></span>
               <br />
            </div>  
            
            <ul class="services">
               <li>Images have to be equirectangular (360x180º)</li>
               <li>If you want to link to your Flickr image, check image permissions</li>               
            </ul>
           </div>
       </div>
	   <?=$config?>
	</body>
	<script language="JavaScript">
		window.onload = function () {
			Config.init();		    
			Sharer.init();
		};
		
	</script>
</html>