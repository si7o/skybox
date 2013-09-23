var Config = {
	cName: 'vr',
	mode: 'auto',
	
	/** init
	 * 
	 * Initializes object
	 * 
	 */
	init: function ()
	{		
		var self = this;
		
		self.configBox = document.getElementById('config');
		
		self.loadConfig();
		self.setListeners();
		self.setMode();
	},
	
	/** setListeners()
	 * 
	 * Sets listeners
	 * 
	 */
	setListeners: function ()
	{
		var self = this;
		document.getElementById( 'btn_save_config' ).addEventListener('click',function (e) {self.saveConfig();});
		document.getElementById( 'btn_config' ).addEventListener('click',function (e) {self.toggleConfig(); return false;});
		
		var conf = document.getElementsByName('v_mode');
		for(var k=0;k<conf.length;k++)
		{
			conf[k].addEventListener('click', function(e) {self.optionClick(this, conf);});
       	}
		
	},
	
	/** loadConfig()
	 * 
	 * Loads config from cookie or sets default
	 * 
	 */
	loadConfig: function ()
	{
		var self = this;
		
		self.mode = Cookie.get(self.cName);
				
		if (!self.mode) 
			self.mode = 'auto';
		
		var conf = document.getElementsByName('v_mode');
		
		for(var k=0;k<conf.length;k++)
		{
			if( conf[k].dataset.value!='auto' &&  !Detector[conf[k].dataset.value])
			{
				//conf[k].disabled = true;
				conf[k].className = 'disabled';
			}				
				
          	else if(conf[k].dataset.value == self.mode)
          	{
            	conf[k].className = 'selected';
          	}
       }
	},
	
	/** optionClick(elem, elems)
	 * 
	 * Handler called when user clicks an option
	 * 
	 * @param elem
	 * @param elems
	 * 
	 */
	optionClick: function (elem, elems) 
	{
		var self = this;
		
		if(elem.className=='')
		{
			for(var k=0;k<elems.length;k++)
			{
				if (elems[k].className=='selected')
					elems[k].className='';
			}
			elem.className='selected'
			self.mode=elem.dataset.value;
			
		}
	},
	
	/** saveConfig()
	 * 
	 * Saves configuration
	 * 
	 */
	saveConfig: function (){
		var self = this;
		
		
        if (self.mode!='auto')
			Cookie.create(self.cName,self.mode,10);
		else
			Cookie.remove(self.cName);
			
		document.getElementById( 'btn_save_config' ).innerHTML='Saved! <small>closing this...</small>';
		setTimeout(self.hide,1000);
	},
	
	/** setMode()
	 * 
	 * Sets the panorama mode
	 * 
	 */
	setMode: function() {
		var self = this;
		switch(self.mode){
			case 'auto':
				self.mode=Detector.getDefaultMode();
				break;
			case 'flash':
				if(!Detector.flash)
					self.mode=Detector.getDefaultMode();				
				break
			case 'webgl':
				if(!Detector.webgl)
					self.mode=Detector.getDefaultMode();
				break;
			case 'canvas':				
				if(!Detector.webgl)
					self.mode=Detector.getDefaultMode();
				break;
			default:
				self.mode=Detector.getDefaultMode();
		}
	},
	
	/** toggleConfig()
	 *
	 * Toggles between hide & show 
	 * 
	 */
	toggleConfig: function() 
	{
		var self = this;
		if(self.configBox.style.display=='none' || self.configBox.style.display=='')
			self.show();
		else
			self.hide();
		
	},
	
	/** show()
	 * 
	 * Shows config window
	 * 
	 */
	show: function() 
	{
		var self = this;
		
		document.getElementById( 'btn_save_config' ).innerHTML='Save Config';
		
		if (Detector.userAgent=='pc')
		{			
			$('div.config').fadeIn(250);
		}
		else
		{
			self.configBox.style.display='table';
		}
	},
	
	/** hide()
	 * 
	 *  Hides config window
	 * 
	 */
	hide: function ()
	{
		var self = this;
			
		if (Detector.userAgent=='pc')
		{			
			$('div.config').fadeOut('fast');
		}
		else
		{
			self.configBox.style.display='none';
		}	
		
	}
}