/**
 *
 * Checks browser compatibility & user agent
 * 
 *  
 * The part refering to Canvas/WebGL made by:
 * @author alteredq / http://alteredqualia.com/
 * @author mr.doob / http://mrdoob.com/ 
 * 
 */

var Detector = {

	canvas: !! window.CanvasRenderingContext2D,
	webgl: ( function () { try { return !! window.WebGLRenderingContext && !! document.createElement( 'canvas' ).getContext( 'experimental-webgl' ); } catch( e ) { return false; } } )(),
	flash: ( function () {
	    var minor = 7;	    
	    var v;
	    if (navigator.plugins && navigator.plugins.length > 0) {
	        var type = 'application/x-shockwave-flash';
	        var mimeTypes = navigator.mimeTypes;
	        if (mimeTypes && mimeTypes[type] && mimeTypes[type].enabledPlugin && mimeTypes[type].enabledPlugin.description) {
	            v = mimeTypes[type].enabledPlugin.description.replace(/^.*?([0-9]+)\.([0-9])+.*$/, '$1,$2').split(',');
	        }
	    }
	    else {
	        var flashObj = null;
	        try { flashObj = new ActiveXObject('ShockwaveFlash.ShockwaveFlash'); } catch (ex) { return false; }
	        if (flashObj != null) {
	            var fV;
	            try { fV = flashObj.GetVariable("$version"); } catch (err) { return false; }
	            v = fV.replace(/^.*?([0-9]+,[0-9]+).*$/, '$1').split(',');
	        }
	    }	
	    console.log(v);    
	    if (v) {
	        var majorVersion = parseInt(v[0], 10);	        
	        //return minor >= parseInt(v[1], 10);
	        return minor <= majorVersion;
	    }
	    return false;
	}
		
		/*function() {
		try {
		  var fo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
		  if(fo) 
		  	return true;
		  else
		  	return false;
		}catch(e){
		  if(navigator.mimeTypes ["application/x-shockwave-flash"] != undefined) 
			return true;
		  else 
		  	return false;
		}
	}*/)(),
	userAgent : (function (){
		var self = this;
		
		if (!self._userAgent) {
			if (navigator.userAgent && navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)|(android)|(webOS)/i)) {
				return 'mobile';
			} else
				return 'pc';
		} 	
		
		return 'pc';		
	})(),
	workers: !! window.Worker,
	fileapi: window.File && window.FileReader && window.FileList && window.Blob,

	getWebGLErrorMessage: function () {

		var element = document.createElement( 'div' );
		element.id = 'webgl-error-message';
		element.style.fontFamily = 'monospace';
		element.style.fontSize = '13px';
		element.style.fontWeight = 'normal';
		element.style.textAlign = 'center';
		element.style.background = '#fff';
		element.style.color = '#000';
		element.style.padding = '1.5em';
		element.style.width = '400px';
		element.style.margin = '5em auto 0';

		if ( ! this.webgl ) {

			element.innerHTML = window.WebGLRenderingContext ? [
				'Your graphics card does not seem to support <a href="http://khronos.org/webgl/wiki/Getting_a_WebGL_Implementation" style="color:#000">WebGL</a>.<br />',
				'Find out how to get it <a href="http://get.webgl.org/" style="color:#000">here</a>.'
			].join( '\n' ) : [
				'Your browser does not seem to support <a href="http://khronos.org/webgl/wiki/Getting_a_WebGL_Implementation" style="color:#000">WebGL</a>.<br/>',
				'Find out how to get it <a href="http://get.webgl.org/" style="color:#000">here</a>.'
			].join( '\n' );

		}

		return element;

	},

	addGetWebGLMessage: function ( parameters ) {

		var parent, id, element;

		parameters = parameters || {};

		parent = parameters.parent !== undefined ? parameters.parent : document.body;
		id = parameters.id !== undefined ? parameters.id : 'oldie';

		element = Detector.getWebGLErrorMessage();
		element.id = id;

		parent.appendChild( element );

	},
	
	getDefaultMode: function()
	{
		if (this.flash)
			return 'flash';
		else if (this.webgl)
			return 'webgl';
		else if (this.canvas)
			return 'canvas';
		else 
			return 'none';
	}

};
