<?php // $Id: datetime.php 19 2010-08-03 01:24:09Z jeremy $
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldColumns extends JFormField
{
	public $type = 'Columns';

	function getInput()
	{
		$doc = JFactory::getDocument();
		$doc->addScript(str_replace('/administrator/', '/', JURI::base()).'templates/'.$this->form->getValue('template').'/wright/parameters/assets/columns/columns.js');
		$doc->addStylesheet(str_replace('/administrator/', '/', JURI::base()).'templates/'.$this->form->getValue('template').'/wright/parameters/assets/columns/columns.css');

		$values = explode(';', $this->value);
		foreach ($values as $col)
		{
			$columns[] = explode(':', $col);
		}
		$number = count($values);

		$class = ( $this->element['class'] ? 'class="'.$this->element['class'].'"' : 'class="columns"' );

		$sidebars = ($this->element['sidebars']) ? $this->element['sidebars'] : 2;

		$options = array ();
		for ($i=1; $i <= 12; $i++)
		{
			$val	= $i;
			$text	= $i;
			$options[] = JHTML::_('select.option', $val, JText::_($text));
		}

		$html = '<div class="columns" style="float: left; width: auto;">';

		$html .= '<input type="hidden" name="'.$this->name.'" id="'.$this->name.'" value="'.$this->value.'" />';

		$html .= '<p id="column_info">' . JText::_('Using') . ' <span id="columns_used"></span> ' . JText::_('of') . ' 12 <span id="columns_warning">'.JText::_('The total needs to add up to 12').'</span></p>';

		foreach ($columns as $column)
		{
			$html .= '<div id="column_'.$column[0].'" class="column" style="width: '.floor(100/$number).'%; float: left;  text-align:center;"><span style="display: block; text-align:center;"><a onclick="swapColumns(\''.$column[0].'\', \'left\')">&laquo; Left</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="swapColumns(\''.$column[0].'\', \'right\')">Right &raquo;</a></span><span style="display: block; text-align:center;">' . JText::_(ucfirst($column[0])) . '</span> ' . JHTML::_('select.genericlist',  $options, 'ignore['.$column[0].']', $class, 'value', 'text', $column[1], 'columns_'.$column[0]) . '</div>';
		}

		$html .= '<div style="display: none; clear: both;"></div></div>';

		return $html;
	}
}