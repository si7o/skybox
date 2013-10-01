var Pano = {		
	infoVisible : true, 
	
  	/** 
  	 * 
  	 * 	init(filename,type,equirectangular,sizes)
	 *
	 *  Initializes the panorama for flash, webgl or canvas.
	 * 
	 * @param filename : file or photo id
	 * @param type: normal / flickr / file
	 * @param equirectangular : true/false
	 * @param sizes: flickr sizes or image width
	 * 
	 */		
	init: function(filename,type,equirectangular,sizes) {		
		var self = this;		
		
		self.type = type;
		self.photo = filename;
		self.sizes = sizes || null;		
		self.equirectangular = equirectangular;
		self.file = '/resources/textures/'+filename,		
		self.container = document.getElementById( 'container' );
		self.ocultar = document.getElementById( 'btn_ocultar' );
		self.mode = document.getElementById( 'mode' );
		self.loader = document.getElementById( 'loader' );
		
		Config.init();
		Sharer.init();
		
		self.addListenersInfo();			
		
		if (self.equirectangular){
			// IF IT IS AN EQUIRECTANGULAR IMAGE, load viewer
			// max texture size 
			if (Detector.userAgent == 'pc'){
				self.maxTextureSize = 6000;
			} else if (Detector.userAgent=='mobile'){
				self.maxTextureSize = 2048;
			}	
			
			// mode
			switch (Config.mode){
				case 'flash':
					self.mode.innerHTML = 'Flash';
					self.loadFlash();
					break;
				case 'webgl':
					self.mode.innerHTML = 'WebGL';		
					var gl;		
					var myCanvas = document.createElement( 'canvas' );
					
					// Try to grab the standard context. If it fails, fallback to experimental
					gl = myCanvas.getContext("canvas") || myCanvas.getContext("experimental-webgl");
					self.maxTextureSize = gl.getParameter(gl.MAX_TEXTURE_SIZE);	
					
					//check image size
					if (typeof(self.sizes)!='array' && self.maxTextureSize < self.sizes ) {
						//WebGL wont be able to hadle the image, we warn the user and try with canvas
						alert('Image is too big. Browser may crash.');
						
						if( Detector.canvas) 
						{
							self.mode.innerHTML = 'Canvas';
							self.loadCanvas();
						}
						
					} else {
						self.loadWebGL();
					}	
					break;
				case 'canvas':
					self.mode.innerHTML = 'Canvas';
					self.loadCanvas();
					break;
				default:
					self.container.innerHTML ='Su navegador no soporta WebGL, Canvas ni flash. <br /> Por favor actualice su navegador';
			}
			
		} 
		else
		{
			log('Not equirectangular');
			// if it is  NOT AN EQUIRECTANGULAR IMAGE, load the image
			var img = new Image;
			switch(self.type){
				case 'flickr':
					img.src=sizes.img_1024.source;
					break;
				case 'file':
					img.src=self.photo;
					break;
			}
			
			img.onload = function(){
			  self.hideLoader();
			};
			self.container.appendChild(img);
		}
		
		
	},
	
	// params for canvas and webGL
	fov : 70,
	isUserInteracting : false,
	onMouseDownMouseX : 0, 
	onMouseDownMouseY : 0,
	lon : 0, 
	onMouseDownLon : 0,
	lat : 0, 
	onMouseDownLat : 0,
	phi : 0, 
	theta : 0,	
	
	/**
	 * loadCanvas ()
	 * 
	 * Initializes canvas mode
	 * 
	 */
	loadCanvas: function() {
		log('Pano:loadCanvas');
		var self = this;	
		var mesh;
		
		self.setFile();			
		
		self.hw = Math.sqrt(self.container.offsetWidth*self.container.offsetWidth + self.container.offsetHeight*self.container.offsetHeight);	

		self.camera = new THREE.PerspectiveCamera( self.fov, self.container.offsetWidth / self.container.offsetHeight, 1, 1100 );
		
		self.camera.target = new THREE.Vector3( 0, 0, 0 );
	
		self.scene = new THREE.Scene();
	
		mesh = new THREE.Mesh( 
					new THREE.SphereGeometry( 60, 30 , 20 ), 
					new THREE.MeshBasicMaterial( { 
						map: THREE.ImageUtils.loadTexture( 
							self.file,
							new THREE.UVMapping(),
							function() {
								self.hideLoader();								
							} ,
							function() {
								self.notPublic();
							}
						), 
						overdraw: true} 
					) 
		);
		
		mesh.scale.x = -1;
		self.scene.add( mesh );
		
		var myCanvas = document.createElement( 'canvas' );
		myCanvas.innerHTML = 'Your Browser does not support canvas. Update your browser or download a 21st century one ;)';
		
		self.renderer = new THREE.CanvasRenderer({canvas:myCanvas});
		self.renderer.setSize( self.container.offsetWidth, self.container.offsetHeight );
	
		self.container.appendChild( self.renderer.domElement );
		
		self.addListeners();
		self.animate();
				
	},
	
	/**
	 * loadWebGL ()
	 * 
	 * Initializes WebGL mode
	 * 
	 */
	loadWebGL: function (){
		log('Pano:loadWebGL');
		var self = this;	
		var mesh;		
		
		self.setFile();
		
		self.camera = new THREE.PerspectiveCamera( self.fov, self.container.offsetWidth / self.container.offsetHeight, 1, 1100 );
		
		self.camera.target = new THREE.Vector3( 0, 0, 0 );
	
		self.scene = new THREE.Scene();
	
		mesh = new THREE.Mesh( 
			new THREE.SphereGeometry( 360, 60, 20 ), 
			new THREE.MeshBasicMaterial( { 
				map: THREE.ImageUtils.loadTexture( 
					self.file, 
					new THREE.UVMapping(),
					function() {
						self.hideLoader();
					},
					function() {
						self.notPublic();
					}										
				) 
			} ) 
		);
		
		
		
		mesh.scale.x = -1;
		self.scene.add( mesh );
	
		self.renderer = new THREE.WebGLRenderer();
		self.renderer.setSize( self.container.offsetWidth, self.container.offsetHeight );
	
		self.container.appendChild( self.renderer.domElement );
		
		self.addListeners();
		self.animate();
		
	},	
	
	/**
	 * loadFlash ()
	 * 
	 * Initializes Flash mode
	 * 
	 */
	loadFlash: function() {	
		log('Pano:loadFlash');
		var self = this;
		
		self.hideLoader();
		self.setFile();	
							      
		var flashvars = {					
			allowFullScreen : true,		
			wmode : "transparent",
			panoSrc : self.file,
			allowFullScreen : true,
			tesselation : 40,
			bgcolor : '#FFFFFF'
		}, params = {
			allowFullScreen : true,		
			wmode : "transparent",
			panoSrc : self.file,
			allowFullScreen : true,
			tesselation : 40,
			bgcolor : '#FFFFFF'
		}, attributes = {};		
		
		swfobject.embedSWF("/resources/embed/pan0.swf", "container", "100%", "100%", "9.0.115", "/resources/embed/expressInstall.swf", flashvars,params, attributes);
				
	},
	
	/**
	 * setFile ()
	 * 
	 * sets the image that will be loaded depending on device capabilities
	 * 
	 */
	setFile: function() {
		var self = this,
			size;
		
		//there are ONLY 3 sizes: 1024 / 2048 / 4000		
		if (self.maxTextureSize>=4000) 
			size = 4000;
		else if (self.maxTextureSize>=2048) 
			size = 2048;
		else if (self.maxTextureSize>=1024) 
			size = 1024;
		else
			alert(self.maxTextureSize);		
		
		switch (self.type) {
			case 'flickr':
				/*var photo_id = document.getElementById( 'photo_id' );*/
				
				var imgsrc = '';
				for(var k in self.sizes) {
				   if (self.sizes[k].width<=self.maxTextureSize)
				   	imgsrc=	self.sizes[k].source;
				}
				
				self.file = '/proxy?file='+imgsrc+'&referer='+window.location.href;
				//self.file = '/proxy/file/'+imgsrc.replace(new RegExp('/', 'g'), '|')+'/referer/'+window.location.href.replace(new RegExp('/', 'g'), '|')+'/';
				//log (self.file);
				
				
				//self.file = '/proxyFlickrImage/'+self.photo+'/'+self.maxTextureSize;				
				break;
			case 'file':
				self.file = '/proxy?file='+self.photo+'&referer='+window.location.href;				
				break;
			default:
				self.file = self.file+'_'+size+'.jpg';
		}	
	},
	
	/**
	 * hideLoader ()
	 * 
	 * Hides loading message
	 * 
	 */
	hideLoader: function() {
		var self = this;
		
		self.loader.style.display = 'none';
	},
	
	/**
	 * notPublic ()
	 * 
	 * When image is not equirectangular
	 * 
	 */
	notPublic: function() {
		var self = this;
		
		self.hideLoader();
		alert('Sorry. The image is private, you have to go visit '+url+' .')
	},
	
	/**
	 * notEquirectangular ()
	 * 
	 * When image is not equirectangular
	 * 
	 */
	notEquirectangular: function() {
		var self = this;
		
		self.hideLoader();
		self.container.parentNode.removeChild(self.container);
	},
	
	/**
	 * addListeners ()
	 * 
	 * sets the listeners for canvas and webgl modes
	 * 
	 */
	addListeners: function (){
		var self = this;	
				
		document.addEventListener( 'mousedown',	function(e) {self.onDocumentMouseDown(e);}	, false );
		document.addEventListener( 'mousemove', 	function(e) {self.onDocumentMouseMove(e);}	, false );
		document.addEventListener( 'mouseup', 	function(e) {self.onDocumentMouseUp(e);}	, false );
		
		document.addEventListener( 'mousewheel', 	function(e) {self.onDocumentMouseWheel(e);}	, false );
		document.addEventListener( 'DOMMouseScroll', function(e) {self.onDocumentMouseWheel(e);}, false);		
		
		self.container.addEventListener( 'touchstart', 	function(e) {self.onDocumentTouchStart(e);}	, false );
		self.container.addEventListener( 'touchmove', 	function(e) {self.onDocumentTouchMove(e);}	, false );		
		
		window.addEventListener( 'resize', 	function(e) {self.onWindowResize();},	false );
	},
	
	/**
	 * addListenersInfo ()
	 * 
	 * Listeners for the info box
	 * 
	 */
	addListenersInfo: function (){
		var self = this;	
		
		if (Detector.userAgent=='pc')
		{
			$('#btn_ocultar').click(function () {				
				if(self.infoVisible){
					$('#info').animate({top : '-'+($('#info').outerHeight() - 5 )},200);
					//this.innerHTML = '+';
					
				} else {
					//this.innerHTML = '-';
					$('#info').animate({top : '0'});
				}				
				self.infoVisible = !self.infoVisible;
			});
		} 
		else
		{
			var div_info = document.getElementById( 'info' );
			
			self.ocultar.addEventListener('click', function (e) {
				if(self.infoVisible){
					//this.innerHTML = '+';					
					div_info.style.top = '-'+ (div_info.offsetHeight -5)+'px';
				} else {
					//this.innerHTML = '-';
					div_info.style.top = 0;
				}
				
				self.infoVisible = !self.infoVisible;
			}, false);
		}	
		
		
	},
	
	/****************************************
	 ****          LISTENER FUNCTIONS
	 *****************************************/ 
	onWindowResize: function() {
		var self = this;	
		
		self.camera.aspect = self.container.offsetWidth / self.container.offsetHeight;
		self.camera.updateProjectionMatrix();
		self.renderer.setSize( self.container.offsetWidth, self.container.offsetHeight );
	},
	
	onDocumentMouseDown : function( event ) {
		var self = this;	
			
		event.preventDefault();
	
		self.isUserInteracting = true;
	
		self.onPointerDownPointerX = event.clientX;
		self.onPointerDownPointerY = event.clientY;
	
		self.onPointerDownLon = self.lon;
		self.onPointerDownLat = self.lat;	
	},
	
	onDocumentMouseMove : function( event ) {
		var self = this;		
	
		if ( self.isUserInteracting ) {
	
			self.lon = ( self.onPointerDownPointerX - event.clientX ) * 0.2 + self.onPointerDownLon;
			self.lat = ( event.clientY - self.onPointerDownPointerY ) * 0.2 + self.onPointerDownLat;
		}
	},
	
	onDocumentMouseUp : function( event ) {
		var self = this;			
	
		self.isUserInteracting = false;	
	},
	
	onDocumentMouseWheel : function( event ) {
		var self = this;	
		
		// WebKit
		if ( event.wheelDeltaY && self.fov>=30 && self.fov<=110) {
			self.fov -= event.wheelDeltaY * 0.05;
	
		// Opera / Explorer 9
		} else if ( event.wheelDelta && self.fov>=30 && self.fov<=110) {
			self.fov -= event.wheelDelta * 0.05;
			
		// Firefox
		} else if ( event.detail && self.fov>=30 && self.fov<=110) {
			self.fov += event.detail * 1.0;
		}
		
		if (self.fov<30) 
		  	self.fov = 30;
		else if (self.fov>110) 
		  	self.fov = 110;
		else
		{
			self.camera.fov = self.fov;
			self.camera.updateProjectionMatrix();
		}		
	},
	
	onDocumentTouchStart : function( event ) {
		var self = this;	
		
		event.preventDefault();
		
	
		if ( event.touches.length == 1 ) {
	
			event.preventDefault();
	
			self.onPointerDownPointerX = event.touches[ 0 ].pageX;
			self.onPointerDownPointerY = event.touches[ 0 ].pageY;
	
			self.onPointerDownLon = self.lon;
			self.onPointerDownLat = self.lat;
	
		}
		
		if ( event.touches.length == 2 ) {	
			event.preventDefault();					
			
			var a =	Math.abs(event.touches[ 0 ].pageX - event.touches[ 1 ].pageX);
			var b =	Math.abs(event.touches[ 0 ].pageY - event.touches[ 1 ].pageY);		
			
			self.hIni = Math.sqrt(a*a + b*b);				
		}
	},
	
	onDocumentTouchMove : function( event ) {
		var self = this;		
		
		event.preventDefault();
	
		if ( event.touches.length == 1 ) {	
			event.preventDefault();
	
			self.lon = ( self.onPointerDownPointerX - event.touches[0].pageX ) * 0.2 + self.onPointerDownLon;
			self.lat = ( event.touches[0].pageY - self.onPointerDownPointerY ) * 0.2 + self.onPointerDownLat;
	
		}
		
		if ( event.touches.length == 2 ) {	
			event.preventDefault();
				
			var deg, dist;					
			
			var a =	Math.abs(event.touches[ 0 ].pageX - event.touches[ 1 ].pageX);
			var b =	Math.abs(event.touches[ 0 ].pageY - event.touches[ 1 ].pageY);
						
			self.hFin = Math.sqrt(a*a + b*b);	
			
			//self.mode.innerHTML = self.hIni+'-'+self.hFin;	
			dist = self.hIni-self.hFin;	
			if (Math.abs(dist)>30)
			{
				deg = ((dist)/self.hw)*4;
			
				self.fov = self.camera.fov + deg;			
				
				if (self.fov>=30 && self.fov <=110  )
				{
					self.camera.fov = self.fov;
					self.camera.updateProjectionMatrix();	
				}	
			}
				
		}	
	},
	
	/****************************************
	 ****       ThreeJS renderers
	 *****************************************/ 
	animate : function() {
		var self = this;	
		
		requestAnimationFrame( function( ) { self.animate();} );
		self.render();
	},
	
	render : function() {
		var self = this;	
		
	
		self.lat = Math.max( - 85, Math.min( 85, self.lat ) );
		self.phi = THREE.Math.degToRad( 90 - self.lat );
		self.theta = THREE.Math.degToRad( self.lon );
	
		self.camera.target.x = 500 * Math.sin( self.phi ) * Math.cos( self.theta );
		self.camera.target.y = 500 * Math.cos( self.phi );
		self.camera.target.z = 500 * Math.sin( self.phi ) * Math.sin( self.theta );
	
		self.camera.lookAt( self.camera.target );
		self.renderer.render( self.scene, self.camera );	
	}		
};
