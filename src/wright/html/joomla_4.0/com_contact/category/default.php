<?php
// Wright v.4 Override: Joomla 4.0
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$this->subtemplatename = 'items';
echo JLayoutHelper::render('joomla.content.category_default', $this);