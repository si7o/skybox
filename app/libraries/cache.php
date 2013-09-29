<?php

/** CACHE_FILE
 * 
 * 
 * 
 */
class Cache  {
	
	
	public function set($content,$key,$ttl)
	{
			
		if (CACHE)
		{
			$key= $key.$this->extra_key($ttl);
					
			$fileLocation = CACHE_PATH . $key;
			$file = fopen($fileLocation,"w");
			fwrite($file,$content);
			fclose($file);
		}
	} 
	
	public function get($key,$ttl) 
	{
		$key= $key.$this->extra_key($ttl);
		$path = CACHE_PATH.$key;
		
		if (CACHE && file_exists($path))
		{
			return file_get_contents($path);
		}
		else 
		{
			return false;
		}
		
	}	
	
	
	private function extra_key($ttl)
	{
		$now = date('Y_m_d_H_i');
		switch ($ttl) {
			case 60:	//1 min
				return $now;
				break;
			case 600:	//10 min
				return substr($now, 0, -1);
				break;							
			default: //1 hour
				return substr($now, 0, -3);
				break;
		}
		
	}	 
}
