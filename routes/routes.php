<?php 

// Default namespace used

use Core\Router as Route;
use Core\View;

// Declare all routes below

// Sample Route using controller@function

Route::get('/list/cat', 'CatController@list_cat');

// Sample Route using a call back function
Route::get('/', function(){
	return View::render('body');
});

Route::get('/test/form', function()
{
	return View::render('form');
});

// Sample Route using a call back function to get all
// post data request
Route::post('/test/form', function()
{
	$data = Core\Request::post_data();
	
	foreach($data as $key => $value)
	{
		echo $key .' = '. $value . '<br>' ;
	}
	@session_start();
	var_dump($_SESSION['csrf_tokens']);

});

?>