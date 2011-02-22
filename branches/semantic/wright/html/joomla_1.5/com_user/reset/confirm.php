<?php // @version $Id: confirm.php 13 2010-11-05 16:28:16Z jeremy $
defined('_JEXEC') or die('Restricted access');
?>

<div class="reset-confirm<?php echo $this->escape($this->params->get('pageclass_sfx')) ?>">

	<?php if ($this->params->get('show_page_title')) : ?>
		<h1>
			<?php echo $this->escape($this->params->get('page_title')); ?>
		</h1>
	<?php endif; ?>

	<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=confirmreset' ); ?>" method="post" class="josForm form-validate">
		<p><?php echo JText::_('RESET_PASSWORD_CONFIRM_DESCRIPTION'); ?></p>
		<fieldset>
			<div class="reset-field">
				<label for="username" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_USERNAME_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_USERNAME_TIP_TEXT'); ?>"><?php echo JText::_('User Name'); ?>:</label>
				<input id="username" name="username" type="text" class="required" size="36" />
			</div>
			<div class="reset-field">
				<label for="token" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_TOKEN_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_TOKEN_TIP_TEXT'); ?>"><?php echo JText::_('Token'); ?>:</label>
				<input id="token" name="token" type="text" class="required" size="36" />
			</div>
		</fieldset>

		<div>
			<button type="submit" class="validate"><?php echo JText::_('Submit'); ?></button>
			<?php echo JHTML::_( 'form.token' ); ?>
		</div>
	</form>
</div>