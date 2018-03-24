<?php 

use Core\Router as Route;

/**
	Declare all routes below
**/

Route::get('/devil', ['HelloController@hello_world', 'devil']);


?>