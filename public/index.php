<?php 

/** 
	Autoload classes
	/core/autoloader.php
**/

require __DIR__.'/../core/autoloader.php';

/**
	Helper Class Comes with Handy Methods
**/
//require __DIR__.'/../core/helper.php';
use Core\Helper;
/**
	Handle Request
**/

Core\Router::parse_route($_SERVER['REQUEST_URI']);
include __DIR__.'/../routes/routes.php';

/** 
	Render Template
**/
Core\View::render_template();


?>