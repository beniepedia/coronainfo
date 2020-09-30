<?php 
if (! function_exists('dump'))
{
	function dump(array $array)
	{
		echo '<pre>';
			print_r($array);
		echo '</pre>';
	}

}
 ?>