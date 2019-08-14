<?php
class Inx_Apiimpl_Loader {
	
	private static $_path = null;
	
	public static function registerAutoload() {
		$sCurrPath = get_include_path();
		$sAppendDir = PATH_SEPARATOR . dirname(dirname(__FILE__) );
		if (strpos($sCurrPath, $sAppendDir) === false)
	        set_include_path($sCurrPath . $sAppendDir);
	    $aSplFunctions = spl_autoload_functions();    
	    
		if (
		    function_exists('__autoload') 
		    && (
		        false === $aSplFunctions 
		        || !in_array('__autoload', $aSplFunctions))
		    ) {
			spl_autoload_register('__autoload');
		}
		
		if (false === $aSplFunctions || !in_array('inx_autoload', $aSplFunctions))
		    spl_autoload_register('inx_autoload');
	}
}

function inx_autoload($sClasseName) {
	
	$inx_path = dirname(dirname(__FILE__));
	
	$arr = explode('_', $sClasseName);
	$filename = array_pop($arr) . '.php';
	$dirname='';
	foreach ($arr as $i=>$dir) {
		if ($i!==0) {
			$dirname .= $dir . DIRECTORY_SEPARATOR;
		}
	}
	
	$path = $inx_path . DIRECTORY_SEPARATOR . $dirname . $filename;
	if (file_exists($path)) {
		require_once $path;
	}
}
