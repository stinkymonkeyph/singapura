<?php

namespace Core;

use Core\Session;
use Core\Router;
use Core\View;
use Core\Helper;

class Singapura
{
	public static function make_app()
	{
		Session::start_session();
		Router::parse_route($_SERVER['REQUEST_URI']); //parse http request
		Router::load_routes(); //load user defined routes
		View::render_template(); //render template
	}
}



?>