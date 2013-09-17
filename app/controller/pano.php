<?php

class Pano extends App{
	function Pano () {
		parent::__construct();	
	}
	
	function viewer($id, $uri='') {
		$this->load_model('json');
		
		$data = $this->json->get_pano($id);
		$this->load_view('pano', $data);		
	}
	
	function yours() {
		$data= array();
		$data['menu'] = $this->load_view('comun/menu', $data, true);
		
		$this->load_view('your_pano',$data);
	}    
    
    function flickr($photo_id) { 
        
        // photo info //
        $flickr_info_url = FL_API_URL.
                    '?method=flickr.photos.getInfo'.
                    '&api_key='.FL_KEY.
                    '&format='.FL_FORMAT.
                    '&photo_id='.$photo_id.
                    '&nojsoncallback=1';
        
        $flickr_info = json_decode(file_get_contents($flickr_info_url));   
        //debug($flickr_info); die;
        
        $data['can_load'] = $flickr_info->photo->usage->canshare || false;
        $data['photo_id'] = $photo_id;
        $data['title']= $flickr_info->photo->title->_content;
        $desc = strip_tags($flickr_info->photo->description->_content);
        if (strlen($desc)>200)
            $desc=substr($desc, 0,200).'...';
        $data['desc'] = $desc;
        $data['url'] = $flickr_info->photo->urls->url[0]->_content;
        
        // photo sizes //
        $flickr_sizes_url = FL_API_URL.
                    '?method=flickr.photos.getSizes'.
                    '&api_key='.FL_KEY.
                    '&format='.FL_FORMAT.
                    '&photo_id='.$photo_id.
                    '&nojsoncallback=1';
        
        $flickr_sizes = json_decode(file_get_contents($flickr_sizes_url));     
        //debug($flickr_sizes); die;
        
        $sizes = array();
        foreach( $flickr_sizes->sizes->size as $img )
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
        
        $this->load_view('flickr', $data);
    }

    function imgur($photo_id){
        
        $imgur_image_url = IMGUR_API_URL.'image'.DS.$photo_id;
    
        //$imgur_image_url = "http://imgur.com/$photo_id";
        
        $opts = array(
               'http'=>array(
                   'header'=>'Authorization: Client-ID '.IMGUR_CLIENT_ID
               )
        );
        $context = stream_context_create($opts);
        $image_data = json_decode(file_get_contents($imgur_image_url, false, $context));
        
        $data['can_load'] = $image_data->success || false;
        $data['photo_id'] = $photo_id;
        $data['title']= $image_data->data->title;
        $desc = strip_tags($image_data->data->description);
        if (strlen($desc)>200)
            $desc=substr($desc, 0,200).'...';
        $data['desc'] = $desc;
        $data['img'] = $image_data->data->link;
        $data['url'] = 'http://www.imgur.com/'.$image_data->data->id;
		$data['width'] = $image_data->data->width;
        
        $data['equirectangular'] = ( $image_data->data->width/$image_data->data->height == 2?'true':'false' );
        
        //debug($image_data); debug($data); die;
        if ($image_data)
            $this->load_view('imgur', $data);
        
    }

    function file(){
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