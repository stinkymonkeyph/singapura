<?php 

use Core\Router as Route;
use Core\View;

/**
	Declare all routes below
**/

Route::get('/devil', 'CatController@hello_world');

Route::get('/angel', function()
{
	View::render('master');
});


?>