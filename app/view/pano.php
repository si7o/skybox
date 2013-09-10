<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR skateparks</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
		<link rel="stylesheet" href="/resources/css/general.css" type="text/css" />
				
		<script type="text/javascript" src="/resources/embed/swfobject.js"></script>
		<script src="/resources/js/comun.js"></script>
		<script src="/resources/js/three.min.js"></script>		
		<script src="/resources/js/jquery.min.js"></script>  
		<script src="/resources/js/Detector.js"></script>
		<script src="/resources/js/Pano.js"></script>
	</head>
	<body class="pano">
	    <div id="debug">	    	
	        <div id="mode"></div>
	    </div>
	    <div id="loader">	    	
	       	<img src="/resources/img/loading.gif" />
	       	<span>cargando...</span>
	    </div>
	    
		<div id="container"></div>
		
		<div id="botones">
			<a href="/"><div id="btn_atras" class="atras"></div></a>
            <div id="btn_ocultar" class="ocultar"></div>
            <div class="mark"></div>	            
        </div>
		
		<div id="info">		      
		    <p class="titulo"><?=$nombre?></p>
		    <p class="desc"><?=$desc?></p>
		    <div class="bg"></div>
		</div>

		<script>
		window.onload = function () {
		    Pano.init('<?=$img?>','normal',true);
		};
		  
		</script>  
	</body>
</html>