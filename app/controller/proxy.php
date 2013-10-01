<?php

class Proxy extends App{
	
    function index() {
        $ttl = 600;        
        $url = $_GET['file'];
        $referer = $_GET['referer'];
		error_reporting(E_ALL);
		
		$key = basename($url);
        $cache = $this->cache->get($key);
		
        
		
        if (!$cache)
		{
	        if ($referer) {   
	            $opts = array(
	                   'http'=>array(
	                       'header'=>array("Referer: $referer\r\n")
	                   )
	            );
	            $context = stream_context_create($opts);
	            $file = file_get_contents($url, false, $context);
	        } 
	        else 
	        {
	            $file = file_get_contents($url);
			}
			if($file)
				$this->cache->set($file,$key,$ttl);
		}
		else
		{				
			$file = $cache;
		}
		
		$etag = md5($file);   
		
				     
		if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $etag==$_SERVER['HTTP_IF_NONE_MATCH'])
		{
			header("HTTP/1.1 304 Not Modified");
		}
		else 
		{
			header('Content-type: image/jpeg');
	        header('Edge-Control: cache-maxage='.$ttl.'s');
	        header('Cache-Control: public, max-age='.$ttl);
	        header('Pragma: public');
	        header('Expires: '.gmdate('D, d M Y H:i:s', time()+$ttl).' GMT');
			header('Etag:'. $etag );
	        print_r($file); 
		}        
    }    

	function file($url,$referer=DOMAIN_NAME) {
		//echo "$url - $referer"; die;
        $ttl = 600;
		
		$url= str_replace('|', '/', $url);
		$referer= str_replace('|', '/', $referer);
		
		$key = basename($url);
        $cache = $this->cache->get($key);
		        
        if (!$cache)
		{
	        if ($referer) {   
	            $opts = array(
	                   'http'=>array(
	                       'header'=>array("Referer: $referer\r\n")
	                   )
	            );
	            $context = stream_context_create($opts);
	            $file = file_get_contents($url, false, $context);
	        } 
	        else 
	        {
	            $file = file_get_contents($url);
			}
			if($file)
				$this->cache->set($file,$key,$ttl);
		}
		else
		{				
			$file = $cache;
		}
		
        $etag = md5($file);   
		
        if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && $etag==$_SERVER['HTTP_IF_NONE_MATCH'])
		{
			header("HTTP/1.1 304 Not Modified");
		}
		else 
		{
			header('Content-type: image/jpeg');
	        header('Edge-Control: cache-maxage='.$ttl.'s');
	        header('Cache-Control: public, max-age='.$ttl);
	        header('Pragma: public');
	        header('Expires: '.gmdate('D, d M Y H:i:s', time()+$ttl).' GMT');
			header('Etag:'. $etag );
	        print_r($file); 
		}     
        
    }    
   
}