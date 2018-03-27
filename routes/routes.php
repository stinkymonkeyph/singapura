<?php 

/**
	Default namespace used
**/
use Core\Router as Route;
use Core\View;

/**
	Declare all routes below
**/

/**
	Sample Route using controller@function

**/

Route::get('list/cat', 'CatController@list_cat');

/**
	Sample Route using a call back function
**/

Route::get('/', function(){
	return View::render('body');
});


?>