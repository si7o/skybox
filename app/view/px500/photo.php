<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR viewer | 500px - <?=$username?> - <?=$title?></title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="/resources/css/general.css" type="text/css" />
		<link rel="image_src" href="<?=$thumbnail?>"/>
		
		
		<!-- for Google -->		
		<meta name="description" content="<?=$desc?>  - by <?=$username?> from 500px" />
		<meta name="keywords" content="<?=$title?>" />
		
		<meta name="author" content="<?=$username?>" />
		<meta name="copyright" content="<?=$username?>" />
		<meta name="application-name" content="VR viewer" />
		
		<!-- for Facebook -->          
		<meta property="og:title" content="<?=$title?>" />
		<meta property="og:type" content="article" />
		<meta property="og:image" content="<?=$thumbnail?>" />
		<meta property="og:url" content="<?=$self_url?>" />
		<meta property="og:description" content="<?=$desc?> - by <?=$username?> from 500px" />
		
		<!-- for Twitter -->          
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:title" content="<?=$title?>" />
		<meta name="twitter:description" content="<?=$desc?>  - by <?=$username?> from 500px" />
		<meta name="twitter:image" content="<?=$thumbnail?>" />
				
		<script type="text/javascript" src="/resources/embed/swfobject.js"></script>		
		<script src="/resources/js/vendor/three.min.js"></script>		
		<script src="/resources/js/vendor/jquery.min.js"></script>  
		
		<script src="/resources/js/comun.js"></script>	
		<script src="/resources/js/Detector.js"></script>
		<script src="/resources/js/Cookie.js"></script>
		<script src="/resources/js/Config.js"></script>
		<script src="/resources/js/Pano.js"></script>
		<script src="/resources/js/sharer.js"></script>
	</head>
	<body class="pano">
	    <div id="debug">	    	
	        <div id="mode"></div>
	    </div>
	    
	    <?if (isset($photo_id) && $photo_id && $can_load):?>
	    <div id="loader">	    	
	       	<img src="/resources/img/loading.gif" />
	       	<span>cargando...</span>
	    </div>
	    <?endif?>
	    
	    <?=$config?>
	    <?=$generate?>
		<div id="container"></div>
		
		<?=$menu?>
		
		<div id="info">		      
		    <p>	      
			    <span class="titulo"><?=$title?></span>
			    <span class="desc"><?=$desc?>. </span>
			    <a href="<?=$url?>" title="Open in 500px!" target="_blank" class="px500"> 
			      	open in 
		      		<span>500px</span>
		    	</a>
		    	or
		    	<a href="/500px/<?=$username?>/" title="Show more panoramas from this user" class="more"> 
			      	<strong>more from this user</strong>
		    	</a>
		    </p>           
	        <div class="bg"></div>
	        
	        
		</div>
		
		<script>
        <?if ( isset($photo_id) && $photo_id && $can_load):?>				
		window.onload = function () {
		    Pano.init('<?=$photo_id?>','500px',<?=$equirectangular?>,<?=$sizes?>);
		};
		<?else:?>
		  var x = window.confirm('Sorry, this photo can only be seen in 500px. \nWould you like to go to 500px now?');
		  if (x)
		  {
		      window.location.href = '<?=$url?>';
		  }
		<?endif?>
		</script> 
	</body>
</html>