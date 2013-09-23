var Cookie = {
	/** create(name, value, days)
	 *
	 * Sets a cookie
	 *  
	 * @param name - string - cookie name
	 * @param value - string - cookie value
	 * @param days - int - expires for the cookie (days)
	 * 
	 */
	create:function(name, value, days) 
	{
		if (days) 
		{
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else 
			var expires = "";
			
		document.cookie = name+"="+value+expires+"; path=/";
	},
	
	/** get(name)
	 *
	 * Loads a cookie
	 *  
	 * @param name - string - cookie name
	 * 
	 */
	get:function(name) 
	{
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') 
				c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) 
				return c.substring(nameEQ.length,c.length);
		}
		return null;
	},
	
	/** remove(name)
	 *
	 * deletes a cookie
	 *  
	 * @param name - string - cookie name	
	 * 
	 */
	remove: function(name)
	{
		this.create(name,"",-1);
	}
}
