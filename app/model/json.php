<?php

class Json {
	public function Json () {
		
	}
	
	public function load_panos (){
		$file_path = DATA_PATH.'panoramicas.json';
		return (json_decode(file_get_contents($file_path), true));
	}
	
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
