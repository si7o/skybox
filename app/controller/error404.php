<?php

class Error404 extends App{
	function Error404 () {
		parent::__construct();	
	}
	
	//
	function index()
	{
		header("HTTP/1.0 404 Not Found");
		$this->load_view('error404');
	}
	
}