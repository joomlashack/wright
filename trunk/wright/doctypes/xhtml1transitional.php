<?php

require_once('default.php');

class HtmlAdapterXhtml1Transitional extends HtmlAdapterAbstract
{
	public function getDoctype($matches)
	{
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	}

	public function getHtml($matches)
	{
		$lang = JFactory::getLanguage();
		$code = substr($lang->getTag(), 0, 2);
		$html = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$code.'" lang="'.$code.'"';
		if ($lang->isRTL()) $html .= ' dir="rtl"';
		$html .= '>';
		return $html;
	}
}