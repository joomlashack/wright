<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="archive-items">
<?php foreach ($this->items as $item) : ?>
	<div class="row<?php echo ($item->odd +1 ); ?>">
		<h2>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug)); ?>">
				<?php echo $this->escape($item->title); ?></a>
		</h2>

		<?php $ShowArticleInfo = ((intval($this->article->modified) !=0 && $this->params->get('show_modify_date')) || ($this->params->get('show_author') && ($this->article->author != "")) || ($this->params->get('show_create_date')) ||
			($this->params->get('show_section') && $this->article->sectionid) || ($this->params->get('show_category') && $this->article->catid)); ?>
		<?php if ($ShowArticleInfo) : ?>
		<div class="article-info-box">

			<?php if ($params->get('show_create_date') OR $params->get('show_modify_date')) : ?>
			<ul class="article-info">
				<?php if ($params->get('show_create_date')) : ?>
				<li class="create"> <?php echo JHTML::_('date', $this->article->created, JText::_('DATE_FORMAT_LC2')); ?> </li>
				<?php endif; ?>
				<?php if ($params->get('show_modify_date')) : ?>
				<li class="modified"> <?php echo JText::sprintf('LAST_UPDATED2', JHTML::_('date', $this->article->modified, JText::_('DATE_FORMAT_LC2'))); ?> </li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
			
			<?php $useRowTwo = (($params->get('show_author')) OR ($params->get('show_section')) OR $this->params->get('show_category')); ?>
			<?php if ($useRowTwo) : ?>
			<ul class="article-info">
				<?php endif; ?>
				<?php if ($params->get('show_author') && !empty($this->item->author )) : ?>
				<li class="createdby">
					<?php JText::printf('Written by', ($this->article->created_by_alias ? $this->escape($this->article->created_by_alias) : $this->escape($this->article->author))); ?>
				</li>
				<?php endif; ?>
				<?php if ($this->params->get('show_section') && $this->article->sectionid) : ?>
				<li class="parent-category-name">
					<?php if ($this->params->get('link_section')) : ?>
					<?php echo '<a href="'.JRoute::_(ContentHelperRoute::getSectionRoute($this->article->sectionid)).'">'; ?>
					<?php endif; ?>
					<?php echo $this->escape($this->article->section); ?>
					<?php if ($this->params->get('link_section')) : ?>
					<?php echo '</a>'; ?>
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<?php if ($this->params->get('show_category') && $this->article->catid) : ?>
				<li class="category-name">
					<?php if ($this->params->get('link_category')) : ?>
					<?php echo '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->article->catslug, $this->article->sectionid)).'">'; ?>
					<?php endif; ?>
					<?php echo $this->escape($this->article->category); ?>
					<?php if ($this->params->get('link_category')) : ?>
					<?php echo '</a>'; ?>
					<?php endif; ?>
				</li>
				<?php endif; ?>
			</ul>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		
		<?php if ($params->get('show_intro')) :?>
		<div class="intro">
			<?php echo substr(strip_tags($item->introtext), 0, 255);  ?>...
		</div>
		<?php endif; ?>
	</div>
<?php endforeach; ?>
</div>

<div class="pagination">
	<p class="counter">
		<?php echo $this->pagination->getPagesCounter(); ?>
	</p>
	<?php echo $this->pagination->getPagesCounter(); ?>
</div>
