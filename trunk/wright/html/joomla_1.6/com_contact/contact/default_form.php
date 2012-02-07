<?php
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
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
	<form action="<?php echo JRoute::_('index.php');?>" method="post" name="emailForm" id="emailForm" class="form-validate">
		<p class="form-required">
			<?php echo JText::_('COM_CONTACT_FORM_LABEL'); ?>
		</p>
		<div class="contact-email">
			<div>
				<?php echo $this->form->getLabel('contact_name'); ?>
				<?php echo $this->form->getInput('contact_name'); ?>
			</div>
			<div>
				<?php echo $this->form->getLabel('contact_email'); ?>
				<?php echo $this->form->getInput('contact_email'); ?>
			</div>
			<div>
				<?php echo $this->form->getLabel('contact_subject'); ?>
				<?php echo $this->form->getInput('contact_subject'); ?>
			</div>
			<div>
				<?php echo $this->form->getLabel('contact_message'); ?>
				<?php echo $this->form->getInput('contact_message'); ?>
			</div>

			<?php if ($this->params->get('show_email_copy')) : ?>
			<div class="fl-right">
				<?php echo $this->form->getInput('contact_email_copy'); ?>
                <?php echo $this->form->getLabel('contact_email_copy'); ?>
			</div>
			<?php endif; ?>
            
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
	</form>
</div>
