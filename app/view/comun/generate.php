<div class="generate" id="share_box"> 	
	<p class='title'>Share your panorama(s)</p>
	<span class="close" onclick="Sharer.hideGeneratePano();">X</span>
   	<p>
   	   To share your onw equirectangular panoramas, paste the URL in the box below.
   	   <br />
   	   <strong>URLs supported</strong>
   	   <ul class="services">
           <li>Flickr user page (it will show images tagged as 'equirectanguar' from the user)</li>
           <li>Flickr photo page</li>
           <li>Imgur images</li>
		   <li>Path to an image hosted on another server</li>              
       </ul>
   	</p>

   
	<div class="form">           
       	<input name="photo_url" id="photo_url" type="text" value=""/>	               
       	<span id="btn_generar_url" > get url </span>
       	<br />
    </div> 	            
   	<div id="msg"></div>
   	<span id="url_sharer"></span>
   	<br />
   	<ul class="services extra">
       <li>Images have to be equirectangular (360x180º)</li>
       <li>If you want to link to your Flickr image, check image permissions</li>               
    </ul>
</div> 