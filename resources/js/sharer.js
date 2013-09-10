var Sharer = {
	init: function(){
		var self = this;

		self.inputBox = document.getElementById( 'photo_url' );
		self.resultBox = document.getElementById( 'url_sharer' ); 
		self.generateBtn = document.getElementById( 'btn_generar_url' );
		
		self.addEvents();
	},
	addEvents: function () {
		var self = this;
		
		self.inputBox.onkeyup = function(){			
			self.createUrl();
		};
		
		self.inputBox.onclick = function(){			
			this.select();
		};
		
		self.inputBox.onchange = function(){			
			self.createUrl();
		};
		
		self.generateBtn.click = function(){
			self.createUrl();
		};
	},
	createUrl: function () {
		var self = this;
		
		var url_photo = self.inputBox.value;
		if (url_photo) {
			if (match = url_photo.match(/flickr.com\/photos\/[^\/]+\/([0-9]+)/))
			{
				url_pano = 'http://'+window.location.host+'/pano/flickr/'+match[1];
				self.resultBox.innerHTML='Your panorama URL is: <a class="" href="'+url_pano+'" target="_blank" >'+url_pano+'</a>'; 
			} 
			else if(match = url_photo.match(/imgur.com\/(\w+)/))
			{
				url_pano = 'http://'+window.location.host+'/pano/imgur/'+match[1];
				self.resultBox.innerHTML='Your panorama URL is: <a class="" href="'+url_pano+'" target="_blank" >'+url_pano+'</a>'; 
			}
			else if(match = url_photo.match(/jpeg|jpg|png|bmp/))
			{
				url_pano = 'http://'+window.location.host+'/pano/file?path='+url_photo;
				self.resultBox.innerHTML='Your panorama URL is: <a class="" href="'+url_pano+'" target="_blank" >'+url_pano+'</a>'; 
			} 
			else 
			{
				self.resultBox.innerHTML='Invalid URL';
			}
				
		} else {
			self.resultBox.innerHTML='';
		}
		
		
	}
};

window.onload = function(){
	Sharer.init();
}
