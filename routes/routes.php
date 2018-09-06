<?php 

// Default namespace used
use Core\Singapura\Router as Route;
use Core\Singapura\View;


// Sample Route using a call back function
Route::get('/', function(){
	return View::render('body');
});


?>