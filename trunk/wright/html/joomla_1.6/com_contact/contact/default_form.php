<?php
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

	$script = '
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
		}';
	$document = JFactory::getDocument();
	$document->addScriptDeclaration($script); ?>

<?php if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="contact-form">
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate">
		<fieldset>
			<legend><?php echo JText::_('COM_CONTACT_FORM_LABEL'); ?></legend>
			                
         <div class="contact_email<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
			<label for="contact_name">
				&nbsp;<?php echo $this->form->getLabel('contact_name'); ?>:
			</label>
			<br />
			<?php echo $this->form->getInput('contact_name'); ?>
			<br />
			<label id="contact_emailmsg" for="contact_email">
				&nbsp;<?php echo $this->form->getLabel('contact_email'); ?>:
			</label>
			<br />
			<?php echo $this->form->getInput('contact_email'); ?>
			<br />
			<label for="contact_subject">
				&nbsp;<?php echo $this->form->getLabel('contact_subject'); ?>:
			</label>
			<br />
			<?php echo $this->form->getInput('contact_subject'); ?>
			<br /><br />
			<label id="contact_textmsg" for="contact_text">
				&nbsp;<?php echo $this->form->getLabel('contact_message'); ?>:
			</label>
			<br />
			<?php echo $this->form->getInput('contact_message'); ?>
			<?php if ($this->contact->params->get( 'show_email_copy' )) : ?>
			<br />
				<?php echo $this->form->getInput('contact_email_copy'); ?>
				<label for="contact_email_copy">
					<?php echo $this->form->getLabel('contact_email_copy'); ?>
				</label>
			<?php endif; ?>
  			<br />
          
            <?php //Dynamically load any additional fields from plugins.
            foreach ($this->form->getFieldsets() as $fieldset): ?>
                  <?php if ($fieldset->name != 'contact'):?>
                       <?php $fields = $this->form->getFieldset($fieldset->name);?>
                       <?php foreach($fields as $field): ?>
            <div>
                            <?php if ($field->hidden): ?>
                                 <?php echo $field->input;?>
                            <?php else:?>
                                    <?php echo $field->label; ?>
                                    <?php if (!$field->required && $field->type != "Spacer"): ?>
                                       <span class="optional"><?php echo JText::_('COM_CONTACT_OPTIONAL');?></span>
                                    <?php endif; ?>
                                 <?php echo $field->input;?>
                            <?php endif;?>
            </div>
                       <?php endforeach;?>
                  <?php endif ?>
             <?php endforeach;?>
            
			<div>
				<button class="button validate" type="submit"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
			</div>
			<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
			<input type="hidden" name="option" value="com_contact" />
			<input type="hidden" name="task" value="contact.submit" />
			<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
			<?php echo JHtml::_( 'form.token' ); ?>
		</div>
		</fieldset>
	</form><br />
</div>
