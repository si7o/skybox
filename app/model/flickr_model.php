<?php

class Flickr_model extends App{
	public function getAllPhotos ($page=1){
		$ttl=1800;
		$key= 'photoshome_'.$page;
		
		$cache = $this->cache->get($key,$ttl);
		
		if (!$cache)
		{			
			$flickr_all_photos_url = FL_API_URL.
					'?method=flickr.photos.search'.
					'&api_key='.FL_KEY.
					'&tags=equirectangular%2C360x180%2C180x360'.
					//'&license=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8'.
					'&privacy_filter=1'.
					//'&safe_search=1'.
					'&media=photos'.
					'&extras=path_alias%2Cowner_name%2Co_dims%2Curl_n'.
					'&page='.$page.
					'&format=json'.
					'&per_page=50'.
					'&nojsoncallback=1';
			
			
			$flickr_all_photos_group_url = FL_API_URL.
					'?method=flickr.photos.search'.
					'&api_key='.FL_KEY.
					//'&tags=equirectangular%2C360x180%2C180x360'.
					'&group_id=44671723%40N00'.
					'&privacy_filter=1'.
					//'&safe_search=1'.
					'&media=photos'.
					'&extras=path_alias%2Cowner_name%2Co_dims%2Curl_n'.
					'&page='.$page.
					'&format=json'.
					'&per_page=50'.
					'&nojsoncallback=1';
			
			$content = file_get_contents($flickr_all_photos_url);
			$flickr_all_photos = json_decode($content);
			
			if ($flickr_all_photos && $flickr_all_photos->photos->total>0)
				$this->cache->set($content,$key,$ttl);
		}
		else
		{
			$flickr_all_photos = json_decode($cache);
		}
		return $flickr_all_photos->photos->photo;
		
	}

	public function getPhotosHome ($page=1){
		$ttl=3600;
		$key= 'photoshome_'.$page;
		
		$cache = $this->cache->get($key,$ttl);
		
		if (!$cache)
		{			
			$flickr_all_photos_url = FL_API_URL.
					'?method=flickr.photos.search'.
					'&api_key='.FL_KEY.
					'&tags=equirectangular%2C360x180%2C180x360'.
					//'&license=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8'.
					'&privacy_filter=1'.
					//'&safe_search=1'.
					'&media=photos'.
					'&extras=path_alias%2Cowner_name%2Co_dims%2Curl_n'.
					'&page='.$page.
					'&format=json'.
					'&per_page=50'.
					'&nojsoncallback=1';
			
			
			$flickr_all_photos_group_url = FL_API_URL.
					'?method=flickr.photos.search'.
					'&api_key='.FL_KEY.
					//'&tags=equirectangular%2C360x180%2C180x360'.
					'&group_id=44671723%40N00'.
					'&privacy_filter=1'.
					//'&safe_search=1'.
					'&media=photos'.
					'&extras=path_alias%2Cowner_name%2Co_dims%2Curl_n'.
					'&page='.$page.
					'&format=json'.
					'&per_page=50'.
					'&nojsoncallback=1';
			
			$all = json_decode(file_get_contents($flickr_all_photos_url));
			$group = json_decode(file_get_contents($flickr_all_photos_group_url));			
			$all = $all->photos->photo;
			$group = $group->photos->photo;
			
			$users = array();
			$ids = array();
			
			$flickr_all_photos_tmp = array();
			$flickr_all_photos = array();
			
			foreach ($group as $photo)
			{
				if(!in_array($photo->id, $ids))
				{
					$ids[] = $photo->id;
					$flickr_all_photos_tmp[]=$photo;
				}
				
			}
			
			foreach ($all as $photo)
			{
				if(!in_array($photo->id, $ids))
				{
					$ids[] = $photo->id;
					$flickr_all_photos_tmp[]=$photo;
				}
			}
			
			foreach ($flickr_all_photos_tmp as $photo)
			{
				if(!in_array($photo->pathalias, $users))
				{
					$users[] = $photo->pathalias;
					$flickr_all_photos[]=$photo;
				}
			}
			
			$content = json_encode($flickr_all_photos);
			
			if($flickr_all_photos && count($flickr_all_photos))
				$this->cache->set($content,$key,$ttl);
		}
		else
		{
			$flickr_all_photos = json_decode($cache);
		}			
				
		//debug($flickr_all_photos); die;
		
		return $flickr_all_photos;
		
		
	}
	
	public function getUserPhotos ($username){
		$ttl=600;
		$key= 'userphotos_'.$username;
		
		$cache = $this->cache->get($key,$ttl);
		
		if (!$cache)
		{
			//if it is not an nsid, we try to get it
			if( !strpos($username,'@'))
			{
				
				$user_url = FL_API_URL.
					'?method=flickr.urls.lookupUser'.
					'&api_key='.FL_KEY.
					'&url=http://www.flickr.com/photos/'.$username.
					'&format=json'.
					'&nojsoncallback=1';
					
				$user = json_decode(file_get_contents($user_url));
				$nsid = $user->user->id ;
			}
			else 
			{
				$nsid=$username;
			}
			
			if($nsid)
			{			
				$flickr_user_photos_url = FL_API_URL.
						'?method=flickr.photos.search'.
						'&user_id='.$nsid.
						'&api_key='.FL_KEY.
						'&tags=equirectangular%2C360x180%2C180x360'.
						//'&license=1%2C2%2C3%2C4%2C5%2C6%2C7%2C8'.
						'&privacy_filter=1'.
						//'&safe_search=1'.
						'&media=photos'.
						'&extras=path_alias%2Cowner_name%2Co_dims%2Curl_n'.
						'&page=1'.
						'&format=json'.
						'&nojsoncallback=1';
				
				$content = file_get_contents($flickr_user_photos_url);
				$flickr_user_photos = json_decode($content);
				
			}
			
			if($flickr_user_photos && (int)$flickr_user_photos->photos->total > 0)
				$this->cache->set($content,$key,$ttl);
		}
		else
		{
			$flickr_user_photos = json_decode($cache);
		}
		return $flickr_user_photos->photos;
	}
	
	public function getPhoto ($photo_id){
		$ttl=600;
		$key= 'photodata_'.$photo_id;
		
		$cache = $this->cache->get($key);
		
		if (!$cache)
		{		
			// photo info //
	        $flickr_info_url = FL_API_URL.
	                    '?method=flickr.photos.getInfo'.
	                    '&api_key='.FL_KEY.
	                    '&format='.FL_FORMAT.
	                    '&photo_id='.$photo_id.
	                    '&nojsoncallback=1';
	        
	        $flickr_info = json_decode(file_get_contents($flickr_info_url));
			
			
			// photo sizes //
	        $flickr_sizes_url = FL_API_URL.
	                    '?method=flickr.photos.getSizes'.
	                    '&api_key='.FL_KEY.
	                    '&format='.FL_FORMAT.
	                    '&photo_id='.$photo_id.
	                    '&nojsoncallback=1';
	        
	        $flickr_sizes = json_decode(file_get_contents($flickr_sizes_url));
			
			$res = new stdClass();			
			$res->info = $flickr_info;
			$res->sizes = $flickr_sizes;
			
			if ($flickr_info && $flickr_sizes)
				$this->cache->set(json_encode($res),$key,$ttl);			
		} 
		else
		{
			$res = json_decode($cache);
		}		
		return $res;
	}
		
}
