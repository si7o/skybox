<?php

class Flickr extends App{
	function Flickr () {		
		
		$this->load_model('flickr_model');
	}
	
	function index() {
		$data['selected']='flickr';
		$data['menu'] = $this->load_view('comun/menu', $data, true);
		$data['config'] = $this->load_view('comun/config', null, true);
		$data['generate'] = $this->load_view('comun/generate', null, true); 
		
		$photos = $this->flickr_model->getAllPhotos();
		
		$data['photos'] = $photos->photos->photo;
		/*echo '<!--';
		debug($photos);
		echo '-->';*/
		
		$this->load_view('flickr/home', $data);
	}	
	
    function user($username) {
    	
		
		$data['menu'] = $this->load_view('comun/menu', null, true);
		$data['config'] = $this->load_view('comun/config', null, true); 
		$data['generate'] = $this->load_view('comun/generate', null, true); 		
		
		$data['photos'] = $this->flickr_model->getUserPhotos($username);
		
		$data['username']= isset($data['photos']->photo[0]->ownername) && $data['photos']->photo[0]->ownername? $data['photos']->photo[0]->ownername:$username;
		
		//debug($data['photos']); die;
		$this->load_view('flickr/user', $data);
    }

	function photo($photo_id) {
		
		
		$data['menu'] = $this->load_view('comun/pano_menu', null, true);
		$data['config'] = $this->load_view('comun/config', null, true);
		$data['generate'] = $this->load_view('comun/generate', null, true); 
		
		$flickr = $this->flickr_model->getPhoto($photo_id);
		
		$data['username'] = $flickr->info->photo->owner->path_alias?$flickr->info->photo->owner->path_alias:$flickr->info->photo->owner->nsid;
        $data['can_load'] = $flickr->info->photo->usage->canshare || false;
        $data['photo_id'] = $photo_id;
        $data['title']= $flickr->info->photo->title->_content;
        $desc = strip_tags($flickr->info->photo->description->_content);
        if (strlen($desc)>200)
            $desc=substr($desc, 0,200).'...';
        $data['desc'] = $desc;
        $data['url'] = $flickr->info->photo->urls->url[0]->_content;
        
                
        $sizes = array();
        foreach( $flickr->sizes->sizes->size as $img )
        {
            if ( $img->width>=1024 )
            {
                $sizes['img_'.$img->width]=$img;
            }
        }
        $elem_tmp = array_shift(array_values($sizes));
        
        $data['equirectangular'] = ( $elem_tmp->width/$elem_tmp->height == 2?'true':'false' );
        
        
        $data['sizes'] = json_encode($sizes);
        
        //debug($data); die;        
        
        $this->load_view('flickr/photo', $data);
    }
	   

    function file(){
    	
		$data['menu'] = $this->load_view('comun/pano_menu', null, true);
		$data['config'] = $this->load_view('comun/config', null, true);
		
        $img_url=$_GET['path'];
        
        $image_size = getimagesize($img_url);
        if ($image_size){
            $data['can_load'] = true;
            $data['photo_id'] = $img_url;
            $data['title']= 'Remote File.';
            $data['desc']= '<a href="'.$img_url.'" target="_blank">'.$img_url.'</a>';
            
            $data['img'] = $img_url;
			
        	$data['width'] = $image_size[0];
            $data['equirectangular'] = ( $image_size[0]/$image_size[1] == 2?'true':'false' );
            
            $this->load_view('file', $data);
        } else {
            
        }
    }

    function proxyImage() {
        $ttl = 600;
        
        $url = $_GET['file'];
        $referer = $_GET['referer'];
        
        header('Content-type: image/jpeg');
        header('Edge-Control: cache-maxage='.$ttl.'s');
        header('Cache-Control: public, max-age='.$ttl);
        header('Pragma: public');
        header('Expires: '.gmdate('D, d M Y H:i:s', time()+$ttl).' GMT');
        
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
        
        print_r($file);
        
    }
    
     /** @deprecated
     * 
     * 
     */
    function getFlickrImage($photo_id,$maxSize){
                    
        $flickr_sizes_url = FL_API_URL.
                    '?method=flickr.photos.getSizes'.
                    '&api_key='.FL_KEY.
                    '&format='.FL_FORMAT.
                    '&photo_id='.$photo_id.
                    '&nojsoncallback=1';
        
        $flickr_sizes = json_decode(file_get_contents($flickr_sizes_url));
        
        //debug($flickr_sizes); die;
        
        // TODO: recorrer array a la inversa y coger el primero que sea menor o igual
        foreach( $flickr_sizes->sizes->size as $img )
        {
            if ( (integer)$img->width<=(integer)$maxSize && $img->height*2 == $img->width )
            {
                $img_url=$img->source;
            }
        }
        
        if (isset($img_url) && $img_url )
        {
            $ttl = 600;
            
            header('Content-type: image/jpeg');
            header('Edge-Control: cache-maxage='.$ttl.'s');
            header('Cache-Control: public, max-age='.$ttl);
            header('Pragma: public');
            header('Expires: '.gmdate('D, d M Y H:i:s', time()+$ttl).' GMT');
            
            $img = $this->proxy($img_url, DOMAIN_NAME."pano/flickr/$photo_id");
            print_r($img);
        }       
    }   

    /** @deprecated
     * 
     * 
     */
    private function proxy($url,$referer = false)
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
        
          
        return $file;  
    }
}