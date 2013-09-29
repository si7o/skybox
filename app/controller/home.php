<?php
	class Home extends App{
		function Home () {
			parent::__construct();	
		}
		
		function index() {
			$this->load_model('json');
			
			$data['selected']='home';
			$data['panos'] = $this->json->load_panos();
			$data['menu'] = $this->load_view('comun/menu', $data, true);
			$data['config'] = $this->load_view('comun/config', null, true);
			$data['generate'] = $this->load_view('comun/generate', null, true); 
			
			$this->load_view('home', $data);
			
		}
		
		function about() {
			$data['selected']='about';
			$data['menu'] = $this->load_view('comun/menu', $data, true);
			$data['config'] = $this->load_view('comun/config', null, true);
			$data['generate'] = $this->load_view('comun/generate', null, true); 
			
			$this->load_view('about', $data);
		}
	}
