<?php // $Id: datetime.php 19 2010-08-03 01:24:09Z jeremy $
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldColorpicker extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Colorpicker';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		$doc = JFactory::getDocument();
		$template = $this->form->getValue('template');
		$doc->addScript(str_replace('/administrator/', '/', JURI::base()).'templates/'.$template.'/wright/parameters/assets/jscolor/jscolor.js');

		$size = ( $this->element['size'] ? 'size="'.$this->element['size'].'"' : '' );
        $value = htmlspecialchars_decode($this->value, ENT_QUOTES);

		$html = '<input type="text" name="'.$this->name.'" id="'.$this->name.'" value="'.$value.'" class="color" '.$size.' /> ';

		return $html;
	}
}

/*
class JElementColorpicker extends JElement
{
	var	$_name = 'Colorpicker';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$doc = JFactory::getDocument();
		$template = $_GET['cid'][0];
		$doc->addScript(str_replace('/administrator/', '/', JURI::base()).'templates/'.$template.'/wright/parameters/assets/jscolor/jscolor.js');

		$size = ( $node->attributes('size') ? 'size="'.$node->attributes('size').'"' : '' );
        $value = htmlspecialchars_decode($value, ENT_QUOTES);

		$html = '<input type="text" name="'.$control_name.'['.$name.']" id="'.$control_name.$name.'" value="'.$value.'" class="color" '.$size.' /> ';

		return $html;
	}
}*/