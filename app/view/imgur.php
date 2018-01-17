<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR viewer</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="/resources/css/general.css" type="text/css" />
				
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
	    
		<div id="container"></div>
		
		<?=$menu?>
		<?=$generate?>
		<div id="info">		      
		    <p class="titulo"><?=$title?></p>
		    <p class="desc">
		        <?=$desc?>
		        <br />
		        <a href="<?=$url?>" title="Open in imgur!" target="_blank" class="imgur"> 
                  open in 
                  <span>imgur</span>
                </a>
            </p>
            <div class="bg"></div>
		</div>
		
		<script>
        <?if ( isset($photo_id) && $photo_id && $can_load):?>				
		window.onload = function () {
		    Pano.init('<?=$img?>','file',<?=$equirectangular?>);
		};
		<?else:?>
		  var x = window.confirm('Sorry, this photo can not be shown. \nWould you like to go to imgur now?');
		  if (x)
		  {
		      window.location.href = '<?=$url?>';
		  }
		<?endif?>
		</script> 
	</body>
</html>