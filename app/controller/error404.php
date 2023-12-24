<?php

/**
 * Error404
 * 
 * Error 404 controller
 * 
 */

class Error404 extends App
{

	/**
	 * index
	 * 
	 * Main error page
	 * 
	 */
	function index()
	{
		header("HTTP/1.0 404 Not Found");
		$this->load_view('error404');
	}
}
