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

		$styles = JFolder::files(str_replace('administrator'.DS, '', JPATH_THEMES.DS.$this->form->getValue('template').DS.'css'), 'style-(.*)?\.css');

		foreach ($styles as $style)
		{
			$item = substr($style, 6, strpos($style, '.css') - 6);
			$val	= $item;
			$text	= ucfirst($item);
			$options[] = JHTML::_('select.option', $val, JText::_($text));
		}
/*
		// Initialize some field attributes.
		$filter			= (string) $this->element['filter'];
		$exclude		= (string) $this->element['exclude'];
		$stripExt		= (string) $this->element['stripext'];
		$hideNone		= (string) $this->element['hide_none'];
		$hideDefault	= (string) $this->element['hide_default'];

		// Get the path in which to search for file options.
		$path = (string) $this->element['directory'];
		if (!is_dir($path)) {
			$path = JPATH_ROOT.'/'.$path;
		}

		// Prepend some default options based on field attributes.
		if (!$hideNone) {
			$options[] = JHtml::_('select.option', '-1', JText::_('JOPTION_DO_NOT_USE'));
		}
		if (!$hideDefault) {
			$options[] = JHtml::_('select.option', '', JText::_('JOPTION_USE_DEFAULT'));
		}

		// Get a list of files in the search path with the given filter.
		$files = JFolder::files($path, $filter);

		// Build the options list from the list of files.
		if (is_array($files)) {
			foreach($files as $file) {

				// Check to see if the file is in the exclude mask.
				if ($exclude) {
					if (preg_match(chr(1).$exclude.chr(1), $file)) {
						continue;
					}
				}

				// If the extension is to be stripped, do it.
				if ($stripExt) {
					$file = JFile::stripExt($file);
				}

				$options[] = JHtml::_('select.option', $file, $file);
			}
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
 * */

		return $options;
	}
}


/*
class JElementStyles extends JElement
{
	var	$_name = 'Styles';

	function fetchElement($name, $value, &$node, $control_name)
	{
		jimport('joomla.filesystem.folder');
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="inputbox"' );

		$styles = JFolder::files(str_replace('administrator'.DS, '', JPATH_THEMES.DS.$_GET['cid'][0].DS.'css'), 'style-(.*)?\.css');

		$options = array ();
		foreach ($styles as $style)
		{
			$item = substr($style, 6, strpos($style, '.css') - 6);
			$val	= $item;
			$text	= ucfirst($item);
			$options[] = JHTML::_('select.option', $val, JText::_($text));
		}

		return JHTML::_('select.genericlist',  $options, ''.$control_name.'['.$name.']', $class, 'value', 'text', $value, $control_name.$name);
	}
}*/