<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR viewer</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/resources/css/general.css" type="text/css" />
		
		<script src="/resources/js/comun.js"></script>
		<script src="/resources/js/Detector.js"></script>
		<script src="/resources/js/Pano.js"></script>
		<script src="/resources/js/sharer.js"></script>
	</head>
	<body class="home">
	   <h2 class="titulo">
	       VR Viewer
	   </h2> 
	   
	   <div class="about">
           An equirectangular panorama viewer based on Canvas, WebGL (<a href="http://threejs.org" target="_blank">threejs.org</a>) & Flash (<a href="http://pan0.net" target="_blank">pan0.net</a>)
           <br /> Works on desktop & mobile.
           <div> 
            <strong>Use it with your own equirectangular Images:</strong>
            <ul class="services">
               <li>
                   <span>For Flickr</span>                   
               </li> 
               <li>
                   <span>For imgur</span>
               </li>
               <li>
                   <span>For files hosted elsewhere</span>
               </li>
            </ul>
            <div class="generate">
               <p>Copy the photo url and paste it into this box:</p>               
               
               <input name="photo_url" id="photo_url" type="text" value=""/>
               <span id="btn_generar_url" > get url </span>
               <span id="url_sharer"> </span>
            </div>           
           </div>
       </div>
	   	   
	   <ul class="listado_panoramicas">
	   		<? foreach ($panos as $pano) :?>
	       
	       	<li>
	       		<a href="/pano/<?=$pano['id'].'/'.title_to_uri($pano['nombre'])?>/">
	           		<span><?=$pano['nombre']?></span>	           	
	        		<img src="/resources/textures/<?=$pano['img']?>_300.jpg" />
	           	</a>
	       	</li>
	       
           <?endforeach;?>
	   </ul>
	   
	   
	</body>
</html>