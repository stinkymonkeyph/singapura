<?php 

class Helper
{
	function link_asset($path)
	{
		echo str_replace('//', '/' ,'/public/'.$path);
	}
}

?>