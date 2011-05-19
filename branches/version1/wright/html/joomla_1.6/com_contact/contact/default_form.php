<?php

defined('_JEXEC') or die;

	$script = '<!--
		function validateForm(frm) {
			var valid = document.formvalidator.isValid(frm);
			if (valid == false) {
				// do field validation
				if (frm.email.invalid) {
					alert("' . JText::_('COM_CONTACT_CONTACT_ENTER_VALID_EMAIL', true) . '");
				} else if (frm.text.invalid) {
					alert("' . JText::_('COM_CONTACT_FORM_NC', true) . '");
				}
				return false;
			} else {
				frm.submit();
			}
		}
		// -->';
	$document = JFactory::getDocument();
	$document->addScriptDeclaration($script); ?>

<?php if(isset($this->error)) : ?>
<tr>
	<td><?php echo $this->error; ?></td>
</tr>
<?php endif; ?>


<tr>
	<td colspan="2">
	<br /><br />
	<form action="<?php echo JRoute::_( 'index.php' );?>" method="post" name="emailForm" id="emailForm" class="form-validate">
		<div class="contact_email<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
			<div class="jform-required">
				<?php echo JText::_('COM_CONTACT_FORM_LABEL'); ?>
			</div>
			<?php echo $this->form->getLabel('contact_name'); ?>
			<br />
			<?php echo $this->form->getInput('contact_name'); ?>
			<br />
			<?php echo $this->form->getLabel('contact_email'); ?>
			<br />
			<?php echo $this->form->getInput('contact_email'); ?>
			<br />
			<?php echo $this->form->getLabel('contact_subject'); ?>
			<br />
			<?php echo $this->form->getInput('contact_subject'); ?>
			<br /><br />
			<?php echo $this->form->getLabel('contact_message'); ?>
			<div><?php echo $this->form->getInput('contact_message'); ?></div>
			<?php if ($this->params->get( 'show_email_copy' )) : ?>
			<br />
				<span style="float: left"><?php echo $this->form->getInput('contact_email_copy'); ?></span>
				<?php echo $this->form->getLabel('contact_email_copy'); ?>
			<?php endif; ?>
			<br />
			<br />
			<button class="button validate" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>

			<input type="hidden" name="option" value="com_contact" />
			<input type="hidden" name="task" value="contact.submit" />
			<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
			<?php echo JHtml::_( 'form.token' ); ?>
		</div>
	</form>
	<br />
	</td>
</tr>