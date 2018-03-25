<?php 

namespace Core;

class View 
{

	private static $template_result;

	public static function render($view_file, $data = null)
	{
		ob_start();
		if($data !== null)
			extract($data);
		require_once __DIR__.'/../core/external/template.php'; 
		require_once self::append_view_prefix($view_file);
		flushblocks();  
		self::$template_result = ob_get_clean();
	}

	private static function append_view_prefix($view_file)
	{
		return __DIR__.'/../views/'.$view_file.'.template';
	}

	public static function render_template()
	{
		echo self::$template_result;
	}


}


?>