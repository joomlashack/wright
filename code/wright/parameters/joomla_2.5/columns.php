<?php
/**
 * @package     Wright
 * @subpackage  Parameters
 *
 * @copyright   Copyright (C) 2005 - 2015 Joomlashack. Meritage Assets.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// Restrict Access to within Joomla
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

/**
 * Columns field
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldColumns extends JFormField
{
	public $type = 'Columns';

	/**
	 * Creates the columns input
	 *
	 * @return  JFormField  Formatted input
	 */
	function getInput()
	{
		$doc = JFactory::getDocument();
		$doc->addScript(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $this->form->getValue('template') . '/wright/parameters/assets/columns/columns.js');
		$doc->addStylesheet(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $this->form->getValue('template') . '/wright/parameters/assets/columns/columns.css');

		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			$doc->addStylesheet(str_replace('/administrator/', '/', JURI::base()) . 'templates/' . $this->form->getValue('template') . '/wright/parameters/assets/basicbootstrap.css');
		}
		else
		{
			$doc->addStyleDeclaration('.columns.row-fluid [class*="span"] { margin-left: 0 }');
		}

		$values = explode(';', $this->value);

		foreach ($values as $col)
		{
			$columns[] = explode(':', $col);
		}

		$number = count($values);

		$class = ( $this->element['class'] ? 'class="' . $this->element['class'] . '"' : 'class="columns"' );

		$sidebars = ($this->element['sidebars']) ? $this->element['sidebars'] : 2;

		$options = array ();

		for ($i = 1; $i <= 12; $i++)
		{
			$val	= $i;
			$text	= $i;
			$options[] = JHtml::_('select.option', $val, JText::_($text));
		}

		$html = '<p id="column_info">' . JText::_('TPL_JS_WRIGHT_FIELD_COLUMNS_USING') . ' <span id="columns_used"></span> ' . JText::_('TPL_JS_WRIGHT_FIELD_COLUMNS_OF') . ' 12 <span id="columns_warning">' . JText::_('TPL_JS_WRIGHT_FIELD_COLUMNS_WARNING') . '</span></p>';

		$html .= '<div class="columns row-fluid">';

		$html .= '<input type="hidden" name="' . $this->name . '" id="' . $this->name . '" value="' . $this->value . '" />';

		foreach ($columns as $column)
		{
			$html .= '<div id="column_' . $column[0] . '" class="col span' . $column[1] . '" style="text-align:center;"><span style="display: block; text-align:center;"><a onclick="swapColumns(\'' . $column[0] . '\', \'left\')"><i class="icon-arrow-left"></i></a><a onclick="swapColumns(\'' . $column[0] . '\', \'right\')"><i class="icon-arrow-right"></i></a></span><span style="display: block; text-align:center;">' . JText::_('TPL_JS_WRIGHT_FIELD_COLUMN_' . strtoupper($column[0])) . '</span> ' .
				JHtml::_('select.genericlist',  $options, 'ignore[' . $column[0] . ']', $class . ' onchange="changeColumns();"', 'value', 'text', $column[1], 'columns_' . $column[0]) . '</div>';
		}

		$html .= '<div style="display: none; clear: both;"></div></div>';

		return $html;
	}
}
