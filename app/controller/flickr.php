<?php

class Flickr extends App
{

        /**
         * Flickr
         * 
         * Initialices the controller
         * 
         * It loads the model used in all controller functions
         * 
         */
        function __construct()
        {
                $this->load_model('flickr_model');
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

                $data['selected'] = 'flickr';
                $data['menu'] = $this->load_view('comun/menu', $data, true);
                $data['config'] = $this->load_view('comun/config', null, true);
                $data['generate'] = $this->load_view('comun/generate', null, true);

                $photos = $this->flickr_model->getAllPhotos();

                $data['photos'] = $photos->photos->photo;

                $this->load_view('flickr/home', $data);
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

                $data['menu'] = $this->load_view('comun/menu', null, true);
                $data['config'] = $this->load_view('comun/config', null, true);
                $data['generate'] = $this->load_view('comun/generate', null, true);

                $data['photos'] = $this->flickr_model->getUserPhotos($username);

                $data['username'] = isset($data['photos']->photo[0]->ownername) && $data['photos']->photo[0]->ownername ? $data['photos']->photo[0]->ownername : $username;

                $this->load_view('flickr/user', $data);
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

                $data['menu'] = $this->load_view('comun/pano_menu', null, true);
                $data['config'] = $this->load_view('comun/config', null, true);
                $data['generate'] = $this->load_view('comun/generate', null, true);

                $flickr = $this->flickr_model->getPhoto($photo_id);

                if (isset($flickr->info->photo)) {
                        //thumbnail to show when sharing the URL
                        $data['thumbnail'] = "http://farm{$flickr->info->photo->farm}.staticflickr.com/{$flickr->info->photo->server}/{$flickr->info->photo->id}_{$flickr->info->photo->secret}_m.jpg";
                }

                $data['username'] = $flickr->info->photo->owner->path_alias ? $flickr->info->photo->owner->path_alias : $flickr->info->photo->owner->nsid;
                $data['can_load'] = $flickr->info->photo->usage->canshare || false;
                $data['photo_id'] = $photo_id;
                $data['title'] = $flickr->info->photo->title->_content;
                $desc = strip_tags($flickr->info->photo->description->_content);
                if (strlen($desc) > 200) {
                        $desc = substr($desc, 0, 200) . '...';
                }
                $data['desc'] = $desc;
                $data['url'] = $flickr->info->photo->urls->url[0]->_content;
                $data['self_url'] = DOMAIN_NAME . "flickr/photos/" . $data['username'] . "/" . $photo_id . "/";

                //we get all sizes bigger than 1024px        
                $sizes = array();
                foreach ($flickr->sizes->sizes->size as $img) {
                        if ($img->width >= 1024) {
                                $sizes['img_' . $img->width] = $img;
                        }
                }
                // last image size is the biggest one. We use it for display
                $elem_tmp = array_shift(array_values($sizes));

                $data['equirectangular'] = ($elem_tmp->width / $elem_tmp->height == 2 ? 'true' : 'false');
                $data['sizes'] = json_encode($sizes);

                $this->load_view('flickr/photo', $data);
        }
}
