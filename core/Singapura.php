<?php

namespace Core;
use Throwable; 

class Singapura
{
	public function make_app()
	{
		try
		{
			new Session();

			$request = new Request();
			$request->get_request(); // parse request

			$router = new Router($request); //init router
			$router->load_routes(); // load user routes
		
		}
		catch(Throwable $err)
		{
			Error::display_error($err);
		}

		View::render_template(); //render template
	}
}



?>