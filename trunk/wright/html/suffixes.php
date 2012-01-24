<?php
defined('_JEXEC') or die('Restricted access');

function parse_suffix(&$suffix, &$icon, &$iconposition, &$gridwidth) {
	$icon = "";
	$iconposition = "";
	$gridwidth = "";
	
	// identify icon
	$i = preg_match("/^(.*)\|icon\|(left\||right\|)?([^\|]*)(.*)/", $suffix, $ar);
	if ($i) {
		$icon = ($ar[3]);
		$iconposition = ($ar[2] == "" ? "right" : substr($ar[2],0,strlen($ar[2])-1));
		$suffix = $ar[1] . $ar[4];
	}
	// identify gridwidth
	$i = preg_match("/^(.*)\|gridwidth\|([1-6]{1})(.*)/", $suffix, $ar);
	if ($i) {
		$gridwidth = $ar[2];
		$suffix = $ar[1] . $ar[3];
	}
	if ($suffix[0] == "|") $suffix = substr($suffix,1);
	if ($suffix[strlen($suffix)-1] == "|") $suffix = substr($suffix,0,strlen($suffix)-1);
}
