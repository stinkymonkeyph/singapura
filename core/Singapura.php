<?php

namespace Core;
use Throwable; 

class Singapura
{

	private $router;

	public function __construct()
	{
			new Session(); //start new session
			$this->router = new Router(new Request()); //initialize router
	}
	
	public function make()
	{
		try
		{
			$this->router->load_routes(); // load user routes		
		}
		catch(Throwable $err)
		{
			Error::catch_error($err);
		}

		View::render_template(); //render template
	}
}


?>