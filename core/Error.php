<?php 

namespace Core;

use Core\View;
use Throwable;

class Error
{
	public static function display_error(Throwable $error)
	{
		$trace = explode("\n", $error->getTraceAsString());
		$class = explode(":", $trace[0]);
		View::render(
			'error', 
			[
				'errors' => $error->getMessage(),
				'class' => $class[2],
				'line' => $error->getLine(),
				'traces' => $trace
			], 
			'error'
		);
	}

}

?>