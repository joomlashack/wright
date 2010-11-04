<?php // $Id: datetime.php 19 2010-08-03 01:24:09Z jeremy $
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldGooglefonts extends JFormFieldList
{
	public $type = 'Googlefonts';

	protected function getInput()
	{
		$class = ( $this->element['class'] ? 'class="'.$this->element['class'].'"' : 'class="inputbox"' );

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
			$html .= ' <input type="checkbox" name="'.$this->name.'_types" class="'.$this->name.'" value="'.$type.'"';
			$html .= (in_array($type, $values)) ? ' checked' : '' ;
			$html .= ' /> '.$type;
		}

		$html .= '<input type="hidden" name="'.$this->name.'" id="'.$this->name.'" value="'.$this->value.'" />';

		return $html;
	}
}

/*
class JElementGooglefonts extends JElement
{
	var	$_name = 'Googlefonts';

	protected function getInput()
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