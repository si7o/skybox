<?php
	class Home extends App{
		function Home () {
			parent::__construct();	
		}
		
		function index() {
			$this->load_model('json');
			
			$data['panos'] = $this->json->load_panos();
			$this->load_view('home', $data);
			
		}
	}
