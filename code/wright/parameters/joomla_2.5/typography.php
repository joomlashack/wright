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

jimport('joomla.html.html');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Typography options
 *
 * @package     Wright
 * @subpackage  Parameters
 * @since       2.0
 */
class JFormFieldTypography extends JFormFieldList
{
	public $type = 'Typography';

	/**
	 * Typography options
	 *
	 * @return  array  Options
	 */
	protected function getOptions()
	{
		$options = array();

		$class = ( $this->element['class'] ? 'class="' . $this->element['class'] . '"' : 'class="inputbox"' );

		$stacks = array( 'JDEFAULT' => 'TPL_JS_WRIGHT_FIELD_DEFAULT',
							'Arial' => 'sans-serif',
							'Baskerville' => 'serif',
							'Cambria' => 'serif',
							'Century Gothic' => 'sans-serif',
							'Consolas' => 'monospace',
							'Copperplate Light'  => 'serif',
							'Courier New' => 'monospace',
							'Franklin Gothic' => 'sans-serif',
							'Futura' => 'sans-serif',
							'Garamond' => 'serif',
							'Geneva' => 'sans-serif',
							'Georgia' => 'serif',
							'Gill Sans' => 'sans-serif',
							'Helvetica' => 'sans-serif',
							'Impact' => 'sans-serif',
							'Lucida Sans' => 'sans-serif',
							'Palatino' => 'serif',
							'Tahoma' => 'sans-serif',
							'Times' => 'serif',
							'Trebuchet MS' => 'sans-serif',
							'Verdana' => 'sans-serif'
				);

		foreach ($stacks as $stack => $style)
		{
			$val	= strtolower(str_replace(' ', '', $stack));
			$text	= JText::_($stack) . ' - ' . JText::_($style);
			$options[] = JHTML::_('select.option', $val, ucfirst($text));
		}

		return $options;
	}
}
