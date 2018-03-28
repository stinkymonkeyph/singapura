<?php 

/** 
	Autoload classes
	/core/autoloader.php
**/
require __DIR__.'/../core/autoloader.php';

/**
	Helper Class Comes with Handy Methods
	/core/helper.php
**/
use Core\Helper;


// Handle Request

use Core\Router;

Router::parse_route($_SERVER['REQUEST_URI']); //parse http request
Router::load_routes(); //load user defined routes
 
// Render Template

Core\View::render_template();


?>