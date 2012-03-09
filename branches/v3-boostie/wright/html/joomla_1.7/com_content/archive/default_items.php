<?php
/**
 * @version		$Id: default_items.php 21538 2011-06-14 09:39:42Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$params = &$this->params;
?>

<div class="archive-items">
<?php foreach ($this->items as $i => $item) : ?>

	<div class="row<?php echo $i % 2; ?>">

		<h2>
		<?php if ($params->get('link_titles')): ?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug,$item->catslug)); ?>">
				<?php echo $this->escape($item->title); ?></a>
		<?php else: ?>
				<?php echo $this->escape($item->title); ?>
		<?php endif; ?>
		</h2>

<?php if (($params->get('show_author')) or ($params->get('show_parent_category')) or ($params->get('show_category')) or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date'))  or ($params->get('show_hits'))) : ?>
<div class="article-info-box">
<ul class="article-info">
<li class="article-info-term"><?php echo JText::_('COM_CONTENT_ARTICLE_INFO'); ?></li>
<?php endif; ?>
<?php if ($params->get('show_parent_category')) : ?>
		<li class="parent-category-name">
			<?php	$title = $this->escape($item->parent_title);
					$url = '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_slug)).'">'.$title.'</a>';?>
			<?php if ($params->get('link_parent_category') && $item->parent_slug) : ?>
				<?php echo JText::sprintf('COM_CONTENT_PARENT', $url); ?>
				<?php else : ?>
				<?php echo JText::sprintf('COM_CONTENT_PARENT', $title); ?>
			<?php endif; ?>
		</li>
<?php endif; ?>

<?php if ($params->get('show_category')) : ?>
		<li class="category-name">
			<?php	$title = $this->escape($item->category_title);
					$url = '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug)) . '">' . $title . '</a>'; ?>
			<?php if ($params->get('link_category') && $item->catslug) : ?>
				<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $url); ?>
				<?php else : ?>
				<?php echo JText::sprintf('COM_CONTENT_CATEGORY', $title); ?>
			<?php endif; ?>
		</li>
<?php endif; ?>
<?php if ($params->get('show_create_date')) : ?>
		<li class="create">
		<?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date',$item->created, JText::_('DATE_FORMAT_LC2'))); ?>
		</li>
<?php endif; ?>
<?php if ($params->get('show_modify_date')) : ?>
		<li class="modified">
		<?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date',$item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
		</li>
<?php endif; ?>
<?php if ($params->get('show_publish_date')) : ?>
		<li class="published">
		<?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date',$item->publish_up, JText::_('DATE_FORMAT_LC2'))); ?>
		</li>
<?php endif; ?>
<?php if ($params->get('show_author') && !empty($item->author )) : ?>
	<li class="createdby">
		<?php $author =  $item->author; ?>
		<?php $author = ($item->created_by_alias ? $item->created_by_alias : $author);?>

			<?php if (!empty($item->contactid ) &&  $params->get('link_author') == true):?>
				<?php 	echo JText::sprintf('COM_CONTENT_WRITTEN_BY' ,
				 JHtml::_('link',JRoute::_('index.php?option=com_contact&view=contact&id='.$item->contactid),$author)); ?>

			<?php else :?>
				<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
			<?php endif; ?>
	</li>
<?php endif; ?>
<?php if ($params->get('show_hits')) : ?>
		<li class="hits">
		<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits); ?>
		</li>
<?php endif; ?>
<?php if (($params->get('show_author')) or ($params->get('show_category')) or ($params->get('show_create_date')) or ($params->get('show_modify_date')) or ($params->get('show_publish_date'))  or ($params->get('show_hits'))) :?>
	</ul>
    </div>
<?php endif; ?>

<?php if ($params->get('show_intro')) :?>
	<div class="intro">
		<?php echo JHtml::_('string.truncate', $item->introtext, $params->get('introtext_limit')); ?>
	</div>
<?php endif; ?>
	</div>
<?php endforeach; ?>
</div>

<div class="pagination">
	<p class="counter">
		<?php echo $this->pagination->getPagesCounter(); ?>
	</p>
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
