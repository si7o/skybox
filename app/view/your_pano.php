<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR viewer</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/resources/css/general.css" type="text/css" media='screen'/>
		
		<script src="/resources/js/jquery.min.js"></script> 
		
		<script src="/resources/js/comun.js"></script>
		<script src="/resources/js/Detector.js"></script>
		<script src="/resources/js/Pano.js"></script>
		<script src="/resources/js/sharer.js"></script>
	</head>
	<body class="home">
	   
	   <?=$menu?>   
	   
	   <div class="about centered">
	   	   <p class="desc">	
	           An equirectangular panorama viewer based on Canvas, WebGL (<a href="http://threejs.org" target="_blank">threejs.org</a>) & Flash (<a href="http://pan0.net" target="_blank">pan0.net</a>)
	           <br /> Works on desktop & mobile.
           </p>
           <div> 
            <strong>To view your equirectangular images paste the link to your image or Flickr/Imgur photo URL into this box:</strong>
            
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
	   
	</body>
</html>