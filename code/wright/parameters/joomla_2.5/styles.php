<?php // $Id: datetime.php 19 2010-08-03 01:24:09Z jeremy $
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldStyles extends JFormFieldList
{
	public $type = 'Styles';

	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		$version = explode('.', JVERSION);
		$subversion = (int)$version[1];
		$filesFound = false;

		while (!$filesFound && $subversion >= 0) {
	        $version = $version[0].$subversion;

			$styles = JFolder::files(JPATH_ROOT.'/templates'.'/'.$this->form->getValue('template').'/css', 'joomla' . $version . '-([^\.]*)\.css');

	        if (!count($styles)) {
	        	$subversion--;
	        }
	        else
	        	$filesFound = true;
		}

        if (!count($styles)) {
	        return array(JHTML::_('select.option', '', JText::_('No styles are provided for this template'), true));
        }

		foreach ($styles as $style)
		{
			if (!preg_match('/-responsive.css$/', $style)) {
				$item = substr($style, 9, strpos($style, '.css') - 9);
				$val	= $item;
				$text	= ucfirst($item);
				$options[] = JHTML::_('select.option', $val, JText::_($text));
			}
		}

		return $options;
    }
}
