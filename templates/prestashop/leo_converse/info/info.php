<?php
/**
 * $THEMEDESC
 * 
 * @version		$Id: file.php $Revision
 * @package		modules
 * @subpackage	$Subpackage.
 * @copyright	Copyright (C) Jan 2012 leotheme.com <@emai:leotheme@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
 */  
if( !class_exists('LeoThemeInfo') ){ 
	class LeoThemeInfo{
		
		/**
		 *
		 */
	public static function onGetInfo( $output=array() ){
		$output["patterns"] = array();
		$path = _PS_ALL_THEMES_DIR_. _THEME_NAME_."/img/patterns";
			
		$regex = '/(\.gif)|(.jpg)|(.png)|(.bmp)$/i';
	
		if( !is_dir($path) ){ return $output; }
		
		$dk =  opendir ( $path );
		$files = array();
		while ( false !== ($filename = readdir ( $dk )) ) {
			if (preg_match ( $regex, $filename )) {
				$files[] = $filename;	
			}
		}  
	 	$output["patterns"] = $files;
	 
		return $output;
	}
	
	/**
	 *
	 */
	public static function onRenderForm( $html, $thmskins ){
		
		$baseURL =  _PS_BASE_URL_.__PS_BASE_URI__."themes/"._THEME_NAME_."/img/patterns/";

		$pt = '';
		
	
		 
		
		$html .= $pt;
		return $html;
	}
	
	public static function onUpdateConfig(  ){
		$leobgpattern = (Tools::getValue('leobgpattern')); 
		Configuration::updateValue('leobgpattern', $leobgpattern);
	}
	
	public static function onProcessHookTop( $params ){
		$params["LEO_BGPATTERN"] = Configuration::get('leobgpattern');
		return $params; 
	}
}	

}
?>