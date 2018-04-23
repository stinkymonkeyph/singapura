<?php

namespace Core;
use Throwable; 

class Singapura
{

	private $request;
	private $router;

	public function __construct()
	{
			new Session(); //start new session
			$this->$request = new Request(); //create request
			$this->$router = new Router($this->$request); //initialize router
	}
	
	public function make()
	{
		try
		{
			$this->$router->load_routes(); // load user routes		
		}
		catch(Throwable $err)
		{
			Error::catch_error($err);
		}

		View::render_template(); //render template
	}
}


?>