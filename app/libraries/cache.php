<?php

/** CACHE_FILE
 * 
 * 
 * 
 */
class Cache  {
	
	/** set (content, key, ttl)
	 * 
	 * Creates a cache file
	 * 
	 * @param content: data to save
	 * @param key: string
	 * @param ttl: int - seconds to cache
	 * 
	 */
	public function set($content,$key,$ttl)
	{
		if (CACHE)
		{			
			$path = $this->get_file_path($key);
			$data = array(time()+$ttl,$content);
			$data = serialize($data);
			
			$file = fopen($path,"w");
			//we lock the file so no one writes nor reads it
			flock($file,LOCK_EX);
			
			fwrite($file,$data);
			
			flock($file,LOCK_UN);
			fclose($file);
		}
	} 
	
	/** set (key)
	 * 
	 * loads a file from cache
	 * 
	 * @param key: string
	 * 
	 * @return (data)
	 */
	public function get($key) 
	{
		//$key= $key.$this->extra_key($ttl);
		$path = $this->get_file_path($key);
		
		if (CACHE && file_exists($path))		
		{
			$file = fopen($path,"r");
			
			if($file)
			{
				//we lock the file so it cannot be written while we read
				flock($file,LOCK_SH);	
				
				$data = file_get_contents($path);
				$data = @unserialize($data);
				
				flock($file,LOCK_UN);
				fclose($file);
	
				if (!$data || $data[0]<time())
				{
					unlink($path);
					return false;
				} 
				else 
				{
					return $data[1];
				}
			} else {
				return false;
			}
			
		}
		else 
		{
			return false;
		}
		
	}
	
	/** remove (key)
	 * 
	 * Deletes a cache file
	 * 
	 */
	public function remove($key)
	{
		$path = $this->get_file_path($key);
		unlink($path);
        return true;
	}	
	
	/** get_file_path (key)
	 * 
	 * gets path to cache file
	 * 
	 * @return (string) path to file
	 * 
	 */
	private function get_file_path($key)
	{
		return CACHE_PATH.$key;
	}
			 
}
