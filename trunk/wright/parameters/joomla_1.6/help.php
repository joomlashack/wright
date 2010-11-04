<?php // $Id: rebrand.php 8 2010-11-03 18:07:23Z jeremy $
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');

class JFormFieldHelp extends JFormField
{
	protected $type = 'Help';

	protected function getInput($name, $value, &$node, $control_name)
	{
		

		JHTML::_('behavior.modal');
		$template = $_GET['cid'][0];
		$html = '<a class="modal" href="'.JURI::root().'templates/'.$template.'/wright/help" rel="{\'handler\': \'iframe\', \'size\': {x: 800, y:600}}">'.JText::_('Documentation').'</a>';

		// Refresh CSS cache since we are editing params
		JFile::delete(JPATH_ROOT.DS.'templates'.DS.$template.DS.'css'.DS.$template.'.css');

		return $html;
	}
}