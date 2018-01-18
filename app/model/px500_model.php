<?php

class Px500_model extends App{
    
        /**
         * 
         * API calls: 
         *      - search photos: https://github.com/500px/api-documentation/blob/master/endpoints/photo/GET_photos_search.md
         * 
         * @param type $page
         * @return type
         */
	public function getAllPhotos ($page=1){
		$ttl=1800;
		$key= 'photoshome_500px_'.$page;
                $px_search_photos = null;
		
		$cache = $this->cache->get($key,$ttl);
		
		if (!$cache)
		{			
			$px_search_photos = PX500_API_URL.
				'photos/search?consumer_key='.PX500_KEY.
				'&tag=equirectangular'.
                                '&image_size=30'.
                                "&page={$page}";			
			
			$content = file_get_contents($px_search_photos);
			$px_search_photos = json_decode($content);
			
			if ($px_search_photos && $px_search_photos->total_items > 0 )
                        {
				$this->cache->set($content,$key,$ttl);
                        }
		}
		else
		{
			$px_search_photos = json_decode($cache);
		}
		return $px_search_photos;
		
	}	
	
        
        /**
         * getUserPhotos
         * 
         * API calls: 
         *      - user info: https://github.com/500px/api-documentation/blob/master/endpoints/user/GET_users_show.md
         *      - search photos: https://github.com/500px/api-documentation/blob/master/endpoints/photo/GET_photos_search.md
         * 
         * 
         * @param type $username
         * @return type 
         */
	public function getUserPhotos ($username){
		$ttl=600;
		$key= 'userphotos_500px_'.$username;
		$user_id = null;
                $px_user_photos = null;
                
		$cache = $this->cache->get($key,$ttl);
		
		if (!$cache)
		{
			//if it is not an nsid, we try to get it
			if( !is_numeric($username))
			{				
				$user_search_url = PX500_API_URL.
                                    'users/show?consumer_key='.PX500_KEY.
                                    "&username={$username}";
					
				$user_search = json_decode(file_get_contents($user_search_url));
                                if (isset($user_search->user ))
                                {
                                        if ($user_search->user->username === $username)
                                        {
                                                $user_id = $user_search->user->id ;                                                
                                        }                                        
                                }				
			}
                        else
                        {
                                $user_id = $username;
                        }
			
			if($user_id)
			{			
				$px_search_photos = PX500_API_URL.
				'photos/search?consumer_key='.PX500_KEY.
				'&tag=equirectangular'.
                                '&image_size=30'.
                                "&user_id={$user_id}";
				
				$content = file_get_contents($px_search_photos);
				$px_user_photos = json_decode($content);
			}
			
			if($px_user_photos && (int)$px_user_photos->total_items > 0) 
                        {
                                $this->cache->set($content,$key,$ttl);
                        } 
		}
		else
		{
			$px_user_photos = json_decode($cache);
		}
		return $px_user_photos->photos;
	}
	
        /**
         * getPhoto
         * 
         * API calls:
         *      - Photo data: https://github.com/500px/api-documentation/blob/master/endpoints/photo/GET_photos_id.md
         * 
         * @param type $photo_id
         * @return type
         */
	public function getPhoto ($photo_id){
		$ttl=600;
		$key= 'photodata_500px_'.$photo_id;
                $photo_data = null;
		
		$cache = $this->cache->get($key);
		
		if (!$cache)
		{		
			// photo data //
                        $px_photos = PX500_API_URL.
                                "photos/{$photo_id}?consumer_key=".PX500_KEY.
                                "&image_size=1,4,2048,4096";
	        
                        $content = file_get_contents($px_photos);        
                        $photo_data = json_decode($content);
						
			if (isset($photo_data->photo))
                        {
                                $this->cache->set($content,$key,$ttl);	
                        }
						
		} 
		else
		{
			$photo_data = json_decode($cache);
		}		
		return $photo_data;
	}
		
}
