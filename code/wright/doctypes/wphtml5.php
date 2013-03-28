<?php 

//require_once('default.php');

class HtmlAdapterWpHtml5 {

	protected $tags = array(	'doctype' =>	'/<doctype>/i',
								'html' =>		'/<html(.*)?>/i',
								'htmlComments' =>	'/<!--.*?-->/i',
								'body' => '/<body(.*)?>/i',
								'nav' => '/<nav(.*)>(.*)<\/nav>/isU',
								'sections' => '/<section(.*)>(.*)<\/section>/isU',
								'asides' => '/<aside(.*)>(.*)<\/aside>/isU',
								'footer' => '/<footer(.*)>(.*)<\/footer>/isU',
								'header' => '/<header(.*)>(.*)<\/header>/isU',
								'toolbar' => '/<div(.*)id="toolbar">(.*)<\/div>/isU',
						);

	public function getTags() {
		return $this->tags;
	}


	public function getDoctype($matches) {
		return '<!DOCTYPE html>';
	}

	public function getHtml($matches) {
		return '<html>';
	}

	public function getHtmlComments($matches) {
		return '';
	}	

	public function getBody($matches) {
		return $matches[0];
	}

	public function getNav($matches) {
		return $matches[0];
	}

	public function getSections($matches) {
		return $matches[0];
	}

	public function getAsides($matches) {
		return $matches[0];
	}

	public function getFooter($matches) {
		return $matches[0];
	}

	public function getHeader($matches) {
		return $matches[0];
	}

	function getToolbar($matches) {
		return $matches[0];
	}
 
}