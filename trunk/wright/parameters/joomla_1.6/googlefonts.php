<?php // $Id: datetime.php 19 2010-08-03 01:24:09Z jeremy $
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Supports an HTML select list of file
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldGooglefonts extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	public $type = 'Googlefonts';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

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

		return $options;
	}
}

/*
class JElementGooglefonts extends JElement
{
	var	$_name = 'Googlefonts';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$class = ( $node->attributes('class') ? 'class="'.$node->attributes('class').'"' : 'class="inputbox"' );

		$fonts = array(		'Cantarell' => array('regular','italic','bold','bolditalic'),
							'Cardo' => array('regular'),
							'Crimson+Text' => array('regular'),
							'Cuprum' => array('regular'),
							'Droid+Sans' => array('regular','bold'),
							'Droid+Sans+Mono' => array('regular'),
							'Droid+Serif' => array('regular','italic','bold','bolditalic'),
							'IM+Fell+DW+Pica' => array('regular','italic'),
							'IM+Fell+DW+Pica+SC' => array('regular'),
							'IM+Fell+DW+Double+Pica' => array('regular','italic'),
							'IM+Fell+DW+Double+Pica+SC' => array('regular'),
							'IM+Fell+DW+English' => array('regular','italic'),
							'IM+Fell+DW+English+SC' => array('regular'),
							'IM+Fell+DW+French+Canon' => array('regular','italic'),
							'IM+Fell+French+Canon+SC' => array('regular'),
							'IM+Fell+Great+Primer' => array('regular','italic'),
							'IM+Fell+Great+Primer+SC' => array('regular'),
							'Inconsolata' => array('regular'),
							'Josefin+Sans+Std+Light' => array('regular'),
							'Lobster' => array('regular'),
							'Molengo' => array('regular'),
							'Neucha' => array('regular'),
							'Neuton' => array('regular'),
							'Nobile' => array('regular','italic','bold','bolditalic'),
							'OFL+Sorts+Mill+Goudy+TT' => array('regular','italic'),
							'Old+Standard+TT' => array('regular','italic','bold'),
							'PT+Sans' => array('regular','italic','bold','bolditalic'),
							'PT+Sans+Caption' => array('regular','bold'),
							'PT+Sans+Narrow' => array('regular','bold'),
							'Philosopher' => array('regular'),
							'Reenie+Beanie' => array('regular'),
							'Tangerine' => array('regular','bold'),
							'Vollkorn' => array('regular','italic','bold','bolditalic'),
							'Yanone+Kaffeesatz' => array('extralight','light','regular','bold'),
				);
		
		$options = array();
		$types = array();
		foreach ($fonts as $font => $styles)
		{
			$types = array_merge($types, $styles);
			$text	= str_replace('+', ' ', $font) . ' - ('.implode(', ', $styles).')';
			$options[] = JHTML::_('select.option', $font, JText::_($text));
		}

		$types = array_unique($types);

		$values = explode(',', $value);

		$html = JHTML::_('select.genericlist',  $options, ''.$control_name.'_'.$name.'_list', $class, 'value', 'text', $values[0], $control_name.$name.'list');

		foreach ($types as $type)
		{
			$html .= ' <input type="checkbox" name="'.$control_name.'_'.$name.'_types" class="'.$name.'" value="'.$type.'"';
			$html .= (in_array($type, $values)) ? ' checked' : '' ;
			$html .= ' /> '.$type;
		}

		$html .= '<input type="hidden" name="'.$control_name.'['.$name.']" id="'.$control_name.'_'.$name.'" value="'.$value.'" />';

		return $html;
	}
}*/