<?php 

use Core\Router as Route;

/**
	Declare all routes below
**/

Route::get('/devil', 'CatController@hello_world');

Route::get('/angel', function()
{
	echo "Im an angel cat";
});


?>