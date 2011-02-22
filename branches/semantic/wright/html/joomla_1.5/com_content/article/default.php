<?php // @version $Id: default.php 19 2010-11-05 21:51:13Z garygisclair $

defined('_JEXEC') or die('Restricted access');

?>

<div id="item-page<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">

	<?php if ($this->params->get('show_page_title', 1) && $this->params->get('page_title') != $this->article->title) : ?>
		<h1> <?php echo $this->escape($this->params->get('page_title')); ?> </h1>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_print_icon') || $this->params->get('show_email_icon') || $this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own')) : ?>
	<ul class="actions">
		<?php if (!$this->print) : ?>
		<?php if ($this->params->get('show_print_icon')) : ?>
		<li class="print-icon"> <?php echo JHtml::_('icon.print_popup',  $this->article, $this->params, $this->access); ?> </li>
		<?php endif; ?>
		<?php if ($this->params->get('show_email_icon')) : ?>
		<li class="email-icon"> <?php echo JHtml::_('icon.email',  $this->article, $this->params, $this->access); ?> </li>
		<?php endif; ?>
		<?php if ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own')) : ?>
		<li class="edit-icon"> <?php echo JHtml::_('icon.edit', $this->article, $this->params); ?> </li>
		<?php endif; ?>
		<?php else : ?>
		<li> <?php echo JHtml::_('icon.print_screen',  $this->article, $this->params, $this->access); ?> </li>
		<?php endif; ?>
	</ul>
	<?php endif; ?>

	<?php if ($this->params->get('show_title')) : ?>
	<h2>
		<?php if ($this->params->get('link_titles') && $this->article->readmore_link != '') : ?>
			<a href="<?php echo $this->article->readmore_link; ?>" class="contentpagetitle<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"> <?php echo $this->escape($this->article->title); ?></a>
		<?php else :
			echo $this->escape($this->article->title);
		endif; ?>
	</h2>
	<?php endif; ?>
	
	<?php if (!$this->params->get('show_intro')) :
		echo $this->article->event->afterDisplayTitle;
	endif; ?>
	
	<?php echo $this->article->event->beforeDisplayContent; ?>
	
	<?php $ShowArticleInfo = ((intval($this->article->modified) !=0 && $this->params->get('show_modify_date')) || ($this->params->get('show_author') && ($this->article->author != "")) || ($this->params->get('show_create_date')) || 
	($this->params->get('show_section') && $this->article->sectionid) || ($this->params->get('show_category') && $this->article->catid)); ?>
	<?php if ($ShowArticleInfo) : ?>
	<div class="article-info-box">

		<?php if ($this->params->get('show_create_date') OR $this->params->get('show_modify_date')) : ?>
		<ul class="article-info">
			<?php if ($this->params->get('show_create_date')) : ?>
			<li class="create"> <?php echo JHTML::_('date', $this->article->created, JText::_('DATE_FORMAT_LC2')); ?> </li>
			<?php endif; ?>
			<?php if ($this->params->get('show_modify_date')) : ?>
			<li class="modified"> <?php echo JText::sprintf('LAST_UPDATED2', JHTML::_('date', $this->article->modified, JText::_('DATE_FORMAT_LC2'))); ?> </li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
		
		<?php $useRowTwo = (($this->params->get('show_author') && !empty($this->item->author )) OR ($this->params->get('show_section')) OR $this->params->get('show_category')); ?>
		<?php if ($useRowTwo) : ?>
		<ul class="article-info">
			<?php if ($this->params->get('show_author') && !empty($this->item->author )) : ?>
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
	<?php if (isset ($this->article->toc)) :
		echo $this->article->toc;
	endif; ?>

	<?php echo JFilterOutput::ampReplace($this->article->text); ?> 
	
	<?php echo $this->article->event->afterDisplayContent; ?> 
	
</div>