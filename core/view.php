<?php 

namespace Core;

class View 
{

	private static $template_result;

	public static function render($view_file, $data = null, $type = null)
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

	private static function append_view_prefix($view_file)
	{
		$directory = str_replace('.', '/', $view_file);
		return __DIR__.'/../views/'.$view_file.'.php';
	}

	private static function append_error_view_prefix($view_file)
	{
		return __DIR__.'/error/'.$view_file.'.php';
	}

	public static function render_template()
	{
		echo self::$template_result;
	}

}


?>