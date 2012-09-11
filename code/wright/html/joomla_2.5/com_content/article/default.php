<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
if (!function_exists("wright_joomla_content_article")) :
	
	function wright_joomla_content_article($buffer) {
		$buffer = preg_replace('/<dd class="category-name">/Ui', '<dd class="category-name"><i class="icon-folder-close"></i>', $buffer);
		$buffer = preg_replace('/<dd class="create">/Ui', '<dd class="create"><i class="icon-calendar"></i>', $buffer);
		$buffer = preg_replace('/<dd class="modified">/Ui', '<dd class="modified"><i class="icon-edit"></i>', $buffer);
		$buffer = preg_replace('/<dd class="published">/Ui', '<dd class="published"><i class="icon-table"></i>', $buffer);
		$buffer = preg_replace('/<dd class="createdby">/Ui', '<dd class="createdby"><i class="icon-user"></i>', $buffer);
		$buffer = preg_replace('/<dd class="hits">/Ui', '<dd class="hits"><i class="icon-signal"></i>', $buffer);
		$buffer = preg_replace('/<dd class="parent-category-name">/Ui', '<dd class="hits"><i class="icon-folder-close"></i>', $buffer);
	    $buffer = preg_replace('/<ul class="actions">/Ui', '<ul class="btn-group actions">', $buffer);
		$buffer = preg_replace('/<li class="print-icon">/Ui', '<li class="btn print-icon">', $buffer);
		$buffer = preg_replace('/<li class="email-icon">/Ui', '<li class="btn email-icon">', $buffer);
		$buffer = preg_replace('/<ul class="pagenav">/Ui', '<ul class="pagenav pagination">', $buffer);
		$buffer = preg_replace('/ class="button"/Ui', ' class="button btn " style="margin-left:5px;" ', $buffer);
		return $buffer;
	}

endif;

ob_start("wright_joomla_content_article");
require('components/com_content/views/article/tmpl/default.php');
ob_end_flush();
?>