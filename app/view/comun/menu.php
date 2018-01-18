<div id="menu_bar">	
	<div id="menu" class="centered">
   		<h2 class="titulo">
       		<a href="/">
       			VR Viewer
       		</a>	
   		</h2> 
   		<ul>
   			<li><a class="flickr<?=isset($selected)&&$selected=='flickr'?' selected':''?>" href="/flickr" >for Flickr</a></li>
                        <li><a class="px500<?=isset($selected)&&$selected=='500px'?' selected':''?>" href="/500px" >for 500px</a></li>
   			<li id="btn_about"><a class="about<?=isset($selected)&&$selected=='about'?' selected':''?>" href="/about" >about</a></li>   			
   			<li><a class="git" href="https://github.com/si7o/skybox" target="_blank">github</a></li>   			
   			<li id="btn_config"><a  class="conf" href="#" >config</a></li>	 	
   		</ul>
	</div>	   
</div>