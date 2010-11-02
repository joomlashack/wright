<?php // $Id: datetime.php 19 2010-08-03 01:24:09Z jeremy $
defined('_JEXEC') or die('Restricted access');

class JElementMerger extends JElement
{
	var	$_name = 'Merger';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$template = array_shift(JRequest::getVar('cid'));
		jimport('joomla.utilities.simplexml');
		$master = new JSimpleXML();
		$master->loadFile(JPATH_ROOT.DS.'templates'.DS.$template.DS.'wright'.DS.'settings.xml');

		array_merge($this->_parent->_xml['_default']->_children, $master->document->_children);

		print_r($master);
		print_r('<hr>');
		print_r($this->_parent->_xml['_default']);
		print_r($this->_parent);
		return true;
	}
}