<?php 

namespace Core;
use Exception;

class View 
{

	private static $template_result;

	public function render($view_file, $data = null, $type = null)
	{
		ob_start();
		
		if($data !== null)
			extract($data);

		require_once __DIR__.'/../core/external/template.php'; 
		require_once __DIR__.'/../core/templatewrapper.php';
		if($type === null)
			require_once self::append_view_prefix($view_file);
		else if($type === 'error')
			require_once self::append_error_view_prefix($view_file);

		flushblocks();  
		self::$template_result = ob_get_clean();
	}

	public function render_error($errors)
	{
		self::render('error',$errors, 'error');
	}

	private function append_view_prefix($view_file)
	{
		$directory = __DIR__.'/../views/'.
					 str_replace('.', '/', $view_file).'.php';
		if(!self::view_exist($directory))
			throw new Exception("View Error: View file does not exists");
		return $directory;
	}

	private function view_exist($view_file)
	{
		return file_exists($view_file);
	}

	private function append_error_view_prefix($view_file)
	{
		return __DIR__.'/error/'.$view_file.'.php';
	}

	public function render_template()
	{
		echo self::$template_result;
	}

}


?>