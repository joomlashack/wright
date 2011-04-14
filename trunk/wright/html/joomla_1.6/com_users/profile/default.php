<?php
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
?>
<div class="profile<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
</h1>
<?php endif; ?>

<?php include('default_core.php'); ?>

<?php include('default_params.php'); ?>

<?php include('default_custom.php'); ?>

<?php if (JFactory::getUser()->id == $this->data->id) : ?>
<div class="button2-left">
<a href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id='.(int) $this->data->id);?>">
	<?php echo JText::_('COM_USERS_Edit_Profile'); ?></a></div>
<?php endif; ?>
</div>
