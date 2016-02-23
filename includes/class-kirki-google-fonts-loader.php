<?php

class Kirki_Google_Fonts_Loader extends Kirki_Google_Fonts_Manager {

	/**
	 * The generated script
	 */
	private static $script;

	public function __construct() {
		var_dump( parent::$fonts );

		$this->generate_script();
	}

	private function generate_script() {
		// If we don't have any fonts then we can exit.
		if ( empty( parent::$fonts ) ) {
			return;
		}
		$fonts = array();
		foreach ( parent::$fonts as $font => $properties ) {
			$variants = implode( ',', $properties['variants'] );
			$subsets  = implode( ',', $properties['subsets'] );

			$fonts[] = str_replace( ' ', '+', $font ) . ':' . $variants . ':' . $subsets;
		}

		$fonts = '\'' . implode( '\', \'', $fonts ) . '\'';
		self::$script  = 'WebFontConfig = {';
		self::$script .= 'google: { families: [ ' . $fonts . ' ] }';
		self::$script .= '};';
		self::$script .= '(function() {';
		self::$script .= 'var wf = document.createElement(\'script\');';
		self::$script .= 'wf.src = \'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js\';';
		self::$script .= 'wf.type = \'text/javascript\';';
		self::$script .= 'wf.async = \'true\';'
		self::$script .= 'var s = document.getElementsByTagName(\'script\')[0];';
		self::$script .= 's.parentNode.insertBefore(wf, s);';
		self::$script .= '})();';

	}

	public static function get_script() {
		return self::$script;
	}

}

