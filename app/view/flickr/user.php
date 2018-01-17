<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR viewer | Flickr - <?=$username?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<link rel="stylesheet" href="/resources/css/general.css" type="text/css" media='screen'/>
		
		<script src="/resources/js/vendor/jquery.min.js"></script> 
		
		<script src="/resources/js/comun.js"></script>
		<script src="/resources/js/Detector.js"></script>
		<script src="/resources/js/Cookie.js"></script>
		<script src="/resources/js/Config.js"></script>
		<script src="/resources/js/sharer.js"></script>
		
	</head>
	<body class="home home_flickr">
		
		<?=$menu?>
		
		<div class="centered">	
			<?=$config?>
			
			<div id="about" class="about flickr">
		   	   	<h3><?=$username?></h3>	
		   	  	<h4>equirectangular panoramas from <a href="http://www.flickr.com/photos/<?=$username?>/" target="_blank" class="flickr">Flickr</a></h4>
		   	   	<small></small>
		   	      
		   	   	<p class="desc">	
		       	    You are watching <?=$username?>'s photos from Flickr tagged as 'equirectangular'. 
		           	<br />If you want to share your panoramas, paste/type your <strong>Flickr user page</strong> or a <strong>photo page</strong> in the box below.
		        	<br /><small>Works on desktop & mobile</small>.
	           	</p>	       		
	       </div>
	       
	       
	       <?if (isset($photos) && count($photos)>0):?>	   	   
		   <ul class="listado_panoramicas">
		   		<? foreach ($photos->photo as $photo) :?>
		        <?if (isset($photo->o_width) && ($photo->o_width/$photo->o_height==2)):?>
		       	<li>
		       		<a href="/flickr/photos/<?=$photo->pathalias?$photo->pathalias:$photo->owner?>/<?=$photo->id?>/">
		           		<span class="flickr_list"><?=$photo->title?></span>	          	
		        		<img src="<?=$photo->url_n?>" />
		           	</a>
		           	<div class="by">open in <a class="flickr" href="http://www.flickr.com/photos/<?=$photo->pathalias?$photo->pathalias:$photo->owner?>/<?=$photo->id?>/" target="_blank">Flickr</a> </div>
		       	</li>
		       	<?endif;?>
		       
	           <?endforeach;?>
		   </ul>
		   <?else:?>
		   <ul class="listado_panoramicas">
		       	<li class="error">
		       		Ups! something went wrong
		       		<br />
		       		<small style="font-weight: normal">does <i><?=$username?></i> has images tagged as 'equirectangular'?</small>
		       		<br />
		       		<a href="/flickr/" onclick="window.location.reload(true);return false;">Try reloading this page</a>	          	
		       	</li>
		   </ul>
		   <?endif;?>
		   <?=$generate?>
		   
		   	
	   </div>
	</body>
	
	<script language="JavaScript">
		window.onload = function () {
			Config.init();		    
			Sharer.init();
		};
		
	</script>
</html>