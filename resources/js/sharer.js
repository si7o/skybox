var Sharer = {
	/** init()
	 *
	 * Initializes object
	 *  
	 */
	init: function(){
		var self = this;

		self.inputBox = document.getElementById( 'photo_url' );
		self.resultBox = document.getElementById( 'url_sharer' ); 
		self.msgBox = document.getElementById( 'msg' );
		self.generateBtn = document.getElementById( 'btn_generar_url' );
		
		self.addEvents();
	},
	
	/** addEvents()
	 *
	 * Sets events & event handlers
	 *  
	 */
	addEvents: function () {
		var self = this;
		/*
		self.inputBox.onkeyup = function(){			
			self.createUrl();
		};
		*/
		self.inputBox.onclick = function(){			
			this.select();
		};
		self.inputBox.onkeypress = function(e){			
			if (e.keyCode == 13) {
		        self.createUrl();
		    }
		};
		/*
		self.inputBox.onchange = function(){			
			self.createUrl();
		};
		*/		
		self.generateBtn.onclick = function(){
			self.createUrl();
		};
	},
	
	/** createUrl()
	 *
	 * Tries to create the url for the panorama
	 *  
	 */
	createUrl: function () {
		var self = this;
		
		var url_photo = self.inputBox.value;
		if (url_photo) {
			if (match = url_photo.match(/flickr.com\/photos\/[^\/]+\/([0-9]+)/))
			{
				url_pano = 'http://'+window.location.host+'/pano/flickr/'+match[1];
				self.showURL(url_pano);
			} 
			else if(match = url_photo.match(/imgur.com\/(\w+)/))
			{
				url_pano = 'http://'+window.location.host+'/pano/imgur/'+match[1];
				self.showURL(url_pano);
			}
			else if(match = url_photo.match(/jpeg|jpg|png|bmp/))
			{
				url_pano = 'http://'+window.location.host+'/pano/file?path='+url_photo;
				self.showURL(url_pano);
			} 
			else 
			{
				self.showMessage('Invalid URL');
			}
				
		} else {
			self.showMessage('');
		}		
	},
	
	/** showMessage(txt)
	 *
	 * Shows a message into an html element
	 *  
	 * @param txt - string - message
	 */
	showMessage: function (txt){
		var self = this;
		
		self.msgBox.innerHTML=txt;
		
	},
	
	/** showURL(url)
	 *
	 * Displays the url of into an html element
	 *  
	 * @param url - string - url of the panorama
	 */
	showURL: function (url){
		var self = this;
		
			
		self.resultBox.innerHTML='Your panorama URL is: <br /> <a class="" href="'+url+'" target="_blank" >'+url+'</a><span class="close" onclick="Sharer.hideURL();">X</span>'; 
		if (Detector.userAgent=='pc')
		{
			$('#url_sharer').fadeIn(250);
		}
		else
		{
			self.resultBox.style.display='table';
			self.msgBox.innerHTML='';
		}
	
	},
	
	/** hideURL()
	 *
	 * Hides the html element where the url is shown
	 *  
	 */
	hideURL: function(){
		var self = this;
		
		if (Detector.userAgent=='pc')
		{
			$(self.resultBox).fadeOut('fast');
		}
		else
		{
			self.resultBox.style.display='none';
			self.msgBox.innerHTML='';
		}						
		
	}
	
};

window.onload = function(){
	Sharer.init();
}
