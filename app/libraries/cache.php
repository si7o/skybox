<?php

/** 
 * Cache
 * 
 * Class for file cache functionality
 * 
 * 
 */
class Cache
{

	/** 
	 * set
	 * 
	 * Creates a cache file containing the content and the expiration date
	 * of the content
	 * 
	 * @param $content  data to save
	 * @param string $key cache key for data
	 * @param int $ttl time to live (seconds)
	 * 
	 */
	public function set($content, $key, $ttl)
	{
		if (CACHE) {
			try {
				$path = $this->get_file_path($key);

				$data = array(time() + $ttl, $content);
				$data = serialize($data);

				$file = fopen($path, "w");
				//we lock the file so no one writes nor reads it while writing
				flock($file, LOCK_EX);

				fwrite($file, $data);

				flock($file, LOCK_UN);
				fclose($file);
			} catch (\Throwable $th) {
				error_log($th->getMessage());
			}
		}
	}

	/** 
	 * get 
	 * 
	 * Loads cache file for a given key an returns
	 *      - content if current date is less than expiration date
	 *      - false if cache has expired
	 *  
	 * @param string $key cache key to retrieve
	 * @return (data) || false
	 */
	public function get($key)
	{
		//$key= $key.$this->extra_key($ttl);
		$path = $this->get_file_path($key);

		if (CACHE && file_exists($path)) {
			$file = @fopen($path, "r");

			if ($file) {
				//we lock the file so it cannot be written while we read
				flock($file, LOCK_SH);

				$data = file_get_contents($path);
				$data = @unserialize($data);

				flock($file, LOCK_UN);
				fclose($file);

				if (!$data || $data[0] < time()) {
					unlink($path);
					return false;
				} else {
					return $data[1];
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/** 
	 * remove 
	 * 
	 * Deletes a cache file given its key
	 * 
	 * @param string $key Cache key to delete 
	 * @return bool TRUE on success, FALSE on error
	 * 
	 */
	public function remove($key)
	{
		$path = $this->get_file_path($key);
		return unlink($path);
	}

	/** 
	 * clearOld 
	 * 
	 * Deletes cache files older than CACHE_DELETE_OLDFILES days
	 * 
	 * @return bool TRUE on success, FALSE on error
	 * 
	 */
	public function clearOld()
	{
		$result = false;

		$files = glob(CACHE_PATH . "*");
		foreach ($files as $file) {
			if (
				is_file($file)
				&& time() - filemtime($file) >= CACHE_DELETE_OLDFILES
			) {
				$result &= unlink($file);
			}
		}

		return $result;
	}

	/** 
	 * get_file_path 
	 * 
	 * gets path to cache file
	 * 
	 * @param string $key 	 
	 * @return string path to file
	 * 
	 */
	private function get_file_path($key)
	{
		return CACHE_PATH . $key;
	}
}
