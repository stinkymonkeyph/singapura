<?php 

// Default namespace used
use Core\Singapura\Router as Route;
use Core\Singapura\View;

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
	var_dump($_SESSION['csrf_tokens']);
});

// Get data routing
Route::get('/cat/lover/{id}/{data}', function()
{
	$data = Core\Request::get_data();
	echo $data['id'] .'<br>';
	echo $data['data'] .'<br>';
});

?>