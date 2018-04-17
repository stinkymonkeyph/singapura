<?php

namespace Core;
use Throwable; 

class Singapura
{
	public function make_app()
	{
		try
		{
			new Session(); //start new session

			$request = new Request();
			$request->get_request(); // get request

			$router = new Router($request); //initialize router
			$router->load_routes(); // load user routes		
		}
		catch(Throwable $err)
		{
			Error::catch_error($err);
		}

		View::render_template(); //render template
	}
}


?>