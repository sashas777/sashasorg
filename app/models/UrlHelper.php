<?php
class App_Model_UrlHelper {
	
	public function friendlyURL($string) {
		$string = preg_replace ( "`\[.*\]`U", "", $string );
		$string = preg_replace ( '`&(amp;)?#?[a-z0-9]+;`i', '-', $string );
		$string = htmlentities ( $string, ENT_COMPAT, 'utf-8' );
		$string = preg_replace ( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $string );
		$string = preg_replace ( array ("`[^a-z0-9]`i", "`[-]+`" ), "-", $string );
		return strtolower ( trim ( $string, '-' ) );
	}
	
	public function url($str) {
		$result = $this->friendlyURL ( $str );
		if (empty ( $result )) {
			$string = $str;
			$string = str_replace ( array ('?', '!', '.', ',', ':', ';', '*', '(', ')', '{', '}', '[', ']', '%', '#', '¹', '@', '$', '^', '-', '+', '/', '\\', '=', '|', '"', '\'', 'à', 'á', 'â', 'ã', 'ä', 'å', '¸', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ú', 'û', 'ý', ' ', 'æ', 'ö', '÷', 'ø', 'ù', 'ü', 'þ', 'ÿ' ), array ('_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'j', 'i', 'e', '-', 'zh', 'ts', 'ch', 'sh', 'shch', '', 'yu', 'ya' ), $string );
			
			$string = preg_replace ( "/_{2,}/", "_", $string );
			$result = strtolower ( trim ( $string, '-' ) );
		
		}
		return $result;
	}
}