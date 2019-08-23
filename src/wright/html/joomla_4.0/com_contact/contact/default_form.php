<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

?>
<div class="com-contact__form contact-form mb-5">
    <form id="contact-form" action="<?php echo Route::_('index.php'); ?>" method="post" class="form-validate form-horizontal">
        <fieldset class="card-body bg-light">
            <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
                <?php if ($fieldset->name === 'captcha' && !$this->captchaEnabled) : ?>
                    <?php continue; ?>
                <?php endif; ?>
                <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                <?php if (count($fields)) : ?>
                    <?php if (isset($fieldset->label) && ($legend = trim(Text::_($fieldset->label))) !== '') : ?>
                        <div>
                            <legend><?php echo $legend; ?></legend>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($fields as $field) : ?>
                        <?php echo $field->renderField(); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="control-group mb-0">
                <div class="controls">
                    <button class="btn btn-primary validate" type="submit"><?php echo Text::_('COM_CONTACT_CONTACT_SEND'); ?></button>
                    <input type="hidden" name="option" value="com_contact">
                    <input type="hidden" name="task" value="contact.submit">
                    <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
                    <input type="hidden" name="id" value="<?php echo $this->item->slug; ?>">
                    <?php echo HTMLHelper::_('form.token'); ?>
                </div>
            </div>
        </fieldset>
    </form>
</div>
