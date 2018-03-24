<?php 

/** 
	Autoload classes
	/core/autoloader.php
**/

require __DIR__.'/../core/autoloader.php';

use App\Controller\HelloController;
use Core\Router;


/**
	Handle Request
**/

Router::get_route($_SERVER['REQUEST_URI']);
Router::get_path();




?>