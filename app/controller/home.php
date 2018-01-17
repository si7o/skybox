<?php

/**
 * Home
 * 
 * Controller for main pages
 * 
 */

class Home extends App{
        /**
         * Home 
         * 
         * initializaes controller
         */
        function Home () 
        {
                parent::__construct();	
        }
        
        /**
         * index
         * 
         * Homepage. Loads & displays home page
         * 
         */
        function index() {
                $this->load_model('json_model');

                $data['selected']='home';
                $data['panos'] = $this->json_model->load_panos();
                $data['menu'] = $this->load_view('comun/menu', $data, true);
                $data['config'] = $this->load_view('comun/config', null, true);
                $data['generate'] = $this->load_view('comun/generate', null, true); 

                $this->load_view('home', $data);
        }
        
        /**
         * about
         * 
         * Loads and displays "about" page
         * 
         */
        function about() {
                $data['selected']='about';
                $data['menu'] = $this->load_view('comun/menu', $data, true);
                $data['config'] = $this->load_view('comun/config', null, true);
                $data['generate'] = $this->load_view('comun/generate', null, true); 

                $this->load_view('about', $data);
        }
}
