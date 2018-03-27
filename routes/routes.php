<?php 

use Core\Router as Route;
use Core\View;

/**
	Declare all routes below
**/

Route::get('/', function()
{
	return View::render('body');
});


?>