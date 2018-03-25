<?php 

/** 
	Autoload classes
	/core/autoloader.php
**/

require __DIR__.'/../core/autoloader.php';

/**
	Handle Request
**/

Core\Router::parse_route($_SERVER['REQUEST_URI']);
include __DIR__.'/../routes/routes.php';


?>