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
		
		<div class="centered">		   	   
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
		   
		   <div id="about" class="about">
		   	   <p class="desc">	
		           An equirectangular panorama viewer based on Canvas, WebGL (<a href="http://threejs.org" target="_blank">threejs.org</a>) & Flash (<a href="http://pan0.net" target="_blank">pan0.net</a>)
		           <br /> Works on desktop & mobile.
	           </p>
	           <div> 
	            <strong>Use it with your own equirectangular Images:</strong>
	            <ul class="services">
	               <li>
	                   For Flickr                   
	               </li> 
	               <li>
	                   For imgur
	               </li>
	               <li>
	                   For files hosted elsewhere
	               </li>
	            </ul>
	            <div class="generate">
	               Copy the photo url and paste it into this box:               
	               <br />
	               <input name="photo_url" id="photo_url" type="text" value=""/>
	               <span id="btn_generar_url" > get url </span>
	               <br />
	               <span id="msg"></span>
	               <span id="url_sharer"></span>
	               <br />
	            </div>           
	           </div>
	       </div>
	   </div>
	</body>
</html>