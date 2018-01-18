<?php
/**
 * Proxy
 * 
 * Proxy controller for loading and caching images from problematic sources
 * 
 *      - Flickr may block API key if detects heavy usage. Better cache files
 *
 */
class Proxy extends App{
	
        /**
         * index
         * 
         * Main Controller function
         * 
         * 
         * Gets param from querystring
         * 
         * @param string $_GET['file'] 
         * @param string $_GET['referer'] 
         * 
         */
        function index() {
            $ttl = 600;        
            $url = $_GET['file'];            
            $referer = $_GET['referer'];
            $key = basename($url);
            
            if (isset($_GET['webp'])&& isset ($_GET['sig']))
            {
                $url .= "&webp=".$_GET['webp']."&sig=".$_GET['sig'];
            }
            
            $cache = $this->cache->get($key);
            if (!$cache)
                    {
                    // if there is a referer we send it when loading the image 
                    // (Flickr will count a view on the user account)
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
                    {
                            $this->cache->set($file,$key,$ttl);
                    }
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

        /**
         * @deprecated since version v0.4.2
         * 
         * file
         * 
         * @param string $url
         * @param string $referer 
         * 
         */
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
                                {
                                        $this->cache->set($file,$key,$ttl);
                                }
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