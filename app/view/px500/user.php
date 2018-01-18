<!DOCTYPE html>
<html lang="en">
	<head>
		<title>VR viewer | 500px - <?=$username?></title>
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
	<body class="home home_px500">
		
		<?=$menu?>
		
		<div class="centered">	
			<?=$config?>
			
			<div id="about" class="about px500">
		   	   	<h3><?=$username?></h3>	
		   	  	<h4>equirectangular panoramas from <a href="http://www.500px.com/<?=$username?>/" target="_blank" class="flickr">500px</a></h4>
		   	   	<small></small>
		   	      
                                <p class="desc">	
                                        You are watching <?=$username?>'s photos from 500px tagged as 'equirectangular'. 
                                        <br />If you want to share your panoramas, paste/type your <strong>500px user page</strong> or a <strong>photo page</strong> in the box below.
                                        <br /><small>Works on desktop & mobile</small>.
                                </p>	       		
                       </div>
	       
	       
	       <?if (isset($photos) && count($photos)>0):?>	   	   
		   <ul class="listado_panoramicas">
                        <?foreach ($photos as $photo) :?>
		        <?if (isset($photo->width) && ($photo->width/$photo->height==2)):?>
		       	<li>
                            <a href="/500px<?= $photo->url?>/">
                                <span class="px500_list"><?= $photo->name ?></span>	          	
                                <img src="<?= $photo->image_url?>" />
                            </a>
                            <div class="by">
                                by <a class="user" href="/500px/<?=$photo->user->username?>/"><?= $photo->user->fullname ?></a> on <a class="px500" href="http://www.500px.com<?= $photo->url?>/" target="_blank">500px</a> 
                            </div>
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
		       		<a href="/500px/" onclick="window.location.reload(true);return false;">Try reloading this page</a>	          	
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