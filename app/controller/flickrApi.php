<?php

class FlickrApi extends App{
    
  /**
   * Flickr
   * 
   * Initialices the controller
   * 
   * It loads the model used in all controller functions
   * 
   */
  function FlickrApi () 
  {		
          $this->load_model('flickr_model');
          header("Content-Type: application/json");
          header("Access-Control-Allow-Origin: *");
  }

  /**
   * index
   * 
   * Main controller function. Loads and displays the latest 
   * Flickr equirectangular panoramas (list)
   * 
   */
  function index() 
  {      
    $latest_photos = $this->flickr_model->getAllPhotos()->photos;
    if ($latest_photos==null) {      
      http_response_code(404);
      die();
    }

    $data['page'] = $latest_photos->page;
    $data['pages'] = $latest_photos->pages;
    $data['perpage'] = $latest_photos->perpage;
    $data['total'] = $latest_photos->total;

    $photos = array();
    foreach( $latest_photos->photo as $p )
    {
      $photo = array();
      $photo['id'] = $p->id;
      $photo['title'] = $p->title;
      $photo['thumbnail'] = $p->url_n;      
      $photo['username']= $p->ownername;
      $photo['owner'] = $p->owner;
      $photo['pathAlias'] = $p->pathalias;
      $photos[] = $photo; 
    }

    $data['photos'] = $photos;
    echo json_encode($data);
  }	

  /**
   * user
   * 
   * Loads and displays the latest Flickr equirectangular panoramas (list)
   * from a given username
   * 
   * @param string $username Flickr username to load photos from     
   * 
   */
  function user($username) 
  {
    $user_data = $this->flickr_model->getUserPhotos($username);

    if ($user_data==null) {      
      http_response_code(404);
      die();
    }

    $data['username']= $user_data->photo[0]->ownername ?? $username;
    $data['owner'] = $user_data->photo[0]->owner ?? '';
    $data['pathAlias'] = $user_data->photo[0]->pathalias ?? '';
    $data['page'] = $user_data->page;
    $data['pages'] = $user_data->pages;
    $data['perpage'] = $user_data->perpage;
    $data['total'] = $user_data->total;

    $photos = array();
    foreach( $user_data->photo as $p )
    {
      $photo = array();
      $photo['id'] = $p->id;
      $photo['title'] = $p->title;
      $photo['thumbnail'] = $p->url_n;
      $photos[] = $photo; 
    }

    $data['photos'] = $photos;

    echo json_encode($data);
  }

  /**
   * photo
   * 
   * Loads and displays a Flickr equirectangular panorama
   * 
   * @param string $photo_id Flickr photo_id to load  
   * 
   */
  function photo($photo_id) 
  {
    $flickr = $this->flickr_model->getPhoto($photo_id);    
    if ($flickr==null) {      
      http_response_code(404);
      die();
    }

    if(isset($flickr->info->photo))
    {
      //thumbnail to show when sharing the URL
      $data['thumbnail']="http://farm{$flickr->info->photo->farm}.staticflickr.com/{$flickr->info->photo->server}/{$flickr->info->photo->id}_{$flickr->info->photo->secret}_m.jpg";
    }				

    $data['username'] = $flickr->info->photo->owner->path_alias ? $flickr->info->photo->owner->path_alias : $flickr->info->photo->owner->nsid;
    $data['canLoad'] = $flickr->info->photo->usage->canshare || false;
    $data['photoId'] = $photo_id;
    $data['title']= $flickr->info->photo->title->_content;
    $data['desc'] = strip_tags($flickr->info->photo->description->_content);
    $data['url'] = $flickr->info->photo->urls->url[0]->_content;
          
    $elem_tmp;
    foreach( $flickr->sizes->sizes->size as $img )
    {
      if ( $img->width <= 1600 )
      {
        $data['sdUrl']=$img->source;
      } else if ( $img->width <= 4096 )
      {
        $data['hdUrl']=$img->source;
        $elem_tmp = $img;
      }
    }
    $data['equirectangular'] = ( $elem_tmp->width/$elem_tmp->height == 2?'true':'false' );      

    echo json_encode($data);
  }
}