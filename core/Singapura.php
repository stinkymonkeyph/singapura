<?php

namespace Core;

use Core\Session;
use Core\Router;
use Core\View;
use Core\Helper;
use Core\Error;
use Throwable; 

class Singapura
{
	public function make_app()
	{
		try
		{
			Session::start_session();
			Router::parse_route($_SERVER['REQUEST_URI']); //parse http request
			Router::load_routes(); //load user defined routes
		}
		catch(Throwable $err)
		{
			Error::display_error($err);
		}

		View::render_template(); //render template
	}
}



?>