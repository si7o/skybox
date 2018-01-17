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
	    <div id="loader">	    	
	       	<img src="/resources/img/loading.gif" />
	       	<span>cargando...</span>
	    </div>
	    <?=$config?>
		<div id="container"></div>
		
		<?=$menu?>
		
		<div id="info">	
			<p>	      
		    <span class="titulo"><?=$nombre?></span>
		    <span class="desc"><?=$desc?></span>
		    </p>
		    <div class="bg"></div>
		</div>
		
		<?=$generate?>
		<script>
		window.onload = function () {			
		    Pano.init('<?=$img?>','normal',true);
		};
		  
		</script>  
	</body>
</html>