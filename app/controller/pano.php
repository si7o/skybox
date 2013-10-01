<?php

class Pano extends App{
	function Pano () {
		parent::__construct();	
	}
	
	function viewer($id, $uri='') {
		$this->load_model('json');
		
		$data = $this->json->get_pano($id);
		$data['menu'] = $this->load_view('comun/pano_menu', null, true);
		$data['config'] = $this->load_view('comun/config', null, true);
		$data['generate'] = $this->load_view('comun/generate', null, true); 
		
		$this->load_view('pano', $data);
	}
    
    function imgur($photo_id){
        
		
		$data['menu'] = $this->load_view('comun/pano_menu', null, true);
		$data['config'] = $this->load_view('comun/config', null, true);
		$data['generate'] = $this->load_view('comun/generate', null, true); 
		
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
    	
		$data['menu'] = $this->load_view('comun/pano_menu', null, true);
		$data['config'] = $this->load_view('comun/config', null, true);
		$data['generate'] = $this->load_view('comun/generate', null, true); 
		
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
            $this->load_view('error404');
        }
    }    
}