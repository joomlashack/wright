<?php
// Wright v.3 Override: Joomla 2.5.14
/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_content/helpers/route.php';

$extraclass = ($this->params->get('presentation_style')=='plain' ? " well" : "");  // Wright v.3: Added well class

?>
<?php if ($this->params->get('show_articles')) : ?>
<div class="contact-articles<?php echo $extraclass; // Wright v.3: Added well class ?>">

	<ol class="nav nav-list">  <?php // Wright v.3: Added nav nav-list classes ?>
		<?php foreach ($this->item->articles as $article) :	?>
			<li>
				<?php echo JHtml::_('link', JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug)), '<i class="icon-file icons-list"></i>' . /* Wright v.3: Added icon */ htmlspecialchars($article->title, ENT_COMPAT, 'UTF-8')); ?>
			</li>
		<?php endforeach; ?>
	</ol>
</div>
<?php endif; ?>
