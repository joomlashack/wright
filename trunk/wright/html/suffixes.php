<?php
defined('_JEXEC') or die('Restricted access');

/* Parses an stacked suffix
 * suffix: stacked suffix (string)
 * icon: output icon (|icon|<icon>)
 * icon position: optional icon position (|icon|<icon position>|<icon>)
 * gridwidth: fixed grid width (|gridwidth|<width>)
 * specialClasses: array with special template classes (user defined)
 * specialClassesResult: array with results of special classes
 */

function parse_suffix(&$suffix, &$icon, &$iconposition, &$gridwidth, $specialClasses, &$specialClassesResult) {	
	$icon = "";
	$iconposition = "";
	$gridwidth = "";
	$specialClassesResult = Array();
	
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

	// identify special classes
	if (isset($specialClasses)) {
		foreach ($specialClasses as $class) {
			$i = preg_match("/^(.*)\|" . $class . "\|([^\|]*)(.*)/", $suffix, $ar);
			if ($i) {
				$specialClassesResult[$class] = ($ar[2]);
				$suffix = $ar[1] . $ar[3];
			}
		}
	}

	if (strlen($suffix) > 0) {
		if ($suffix[0] == "|") $suffix = substr($suffix,1);
		if ($suffix[strlen($suffix)-1] == "|") $suffix = substr($suffix,0,strlen($suffix)-1);
	}
}
