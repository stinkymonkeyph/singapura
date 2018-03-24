<?php 


/** 
	Autoload classes
	/core/autoloader.php
**/

require __DIR__.'/../core/autoloader.php';

use App\Controller\HelloController;
use Core\Router;

Router::get_route($_SERVER['REQUEST_URI']);

?>