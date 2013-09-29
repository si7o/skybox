<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR viewer | Flickr</title>
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
	<body class="home home_flickr">
		
		<?=$menu?>
		
		<div class="centered">		   	   
		   <ul class="listado_panoramicas">
		   		<? foreach ($photos as $photo) :?>
		        <?if (isset($photo->o_width) && ($photo->o_width/$photo->o_height==2)):?>
		       	<li>
		       		<a href="/flickr/photos/<?=$photo->pathalias?$photo->pathalias:$photo->owner?>/<?=$photo->id?>/">
		           		<span class="flickr_list"><?=$photo->title?></span>	          	
		        		<img src="<?=$photo->url_n?>" />
		           	</a>
		           	<div class="by">by <a class="user" href="/flickr/photos/<?=$photo->pathalias?$photo->pathalias:$photo->owner?>/"><?=$photo->ownername?></a> on <a class="flickr" href="http://www.flickr.com/photos/<?=$photo->pathalias?$photo->pathalias:$photo->owner?>/<?=$photo->id?>/" target="_blank">Flickr</a> </div>
		       	</li>
		       	<?endif;?>
		       
	           <?endforeach;?>
		   </ul>
		   
		   <?=$config?>
		   
		   <div id="about" class="about flickr">
		   	   <h3>Flickr</h3>	
		   	  	<h4>equirectangular panoramas</h4>
		   	   	<small></small>
		   	      
		   	   	<p class="desc">	
		       	    You are watching photos from Flickr tagged as 'equirectangular'. 
		           	<br />If you want to share your panoramas, paste/type your <strong>Flickr user page</strong> or a <strong>photo page</strong> in the box below.
		        	<br />Works on desktop & mobile.
	           	</p>
	       		<div> 
		            <strong>If you paste your flickr page, only photos tagged as 'equirectangular' will be shown</strong>
		            
		            <div class="generate">
		               	Your flickr url:               
		               	<br />
		               	<div class="form">           
					       	<input name="photo_url" id="photo_url" type="text" value=""/>	               
					       	<span id="btn_generar_url" > get url </span>					       	
					    </div> 	            
					   	<div id="msg"></div>
					   	<span id="url_sharer"></span>
					   	<br />		              
		            </div>             
		        </div>
	       </div>
	   </div>
	</body>
	
	<script language="JavaScript">
		window.onload = function () {
			Config.init();		    
			Sharer.init();
		};
		
	</script>
</html>