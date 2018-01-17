<?php
/**
 * Json
 * 
 * Model for loading data from main json file
 * preloaded panoramas
 * 
 */
class Json_model {        
	
        /**
         * load_panos
         * 
         * Loads pano data from panoramicas.json 
         * 
         * @return Array containing all preloaded panoramas data
         */
	public function load_panos (){                
		$file_path = DATA_PATH.'panoramicas.json';
		return (json_decode(file_get_contents($file_path), true));
	}
	
        /**
         * get_pano
         * 
         * Gets panorama data from preloaded panoramas
         * 
         * @param string $id panorama ID taken from panoramicas.json
         * @return Array containing pano data
         */
	public function get_pano ($id){
		$panos = $this->load_panos();	
		
		$pano = null;
		foreach ($panos as $p) 
		{
			if ($p['id'] == $id)
			{
				$pano = $p;
				break;
			}
		}
		
		return $pano;		
	}
}
