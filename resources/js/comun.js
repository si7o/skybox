/** log(txt)
 *
 * Logs message to console 
 * 
 * @param txt - string/object
 *  
 */
function log(txt) 
{
	if(typeof(console)!='undefined')
		console.log(txt);
}

/** loadScript(url)
 *
 * Loads a js file
 * 
 * @param url - string - path to js file
 *  
 */
function loadScript(url)
{
    // adding the script tag to the head as suggested before
   var head = document.getElementsByTagName('head')[0];
   var script = document.createElement('script');
   script.type = 'text/javascript';
   script.src = url;
/*
   // then bind the event to the callback function 
   // there are several events for cross browser compatibility
   script.onreadystatechange = callback;
   script.onload = callback;
*/
   // fire the loading
   head.appendChild(script);
}

