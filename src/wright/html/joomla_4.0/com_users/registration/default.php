<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
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
<div class="com-users-registration registration">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
        </div>
    <?php endif; ?>

    <form id="member-registration" action="<?php echo Route::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="com-users-registration__form form-validate" enctype="multipart/form-data">
        <div class="card-body bg-light">
            <?php // Iterate through the form fieldsets and display each one. ?>
            <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
                <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                <?php if (count($fields)) : ?>
                        <?php // If the fieldset has a label set, display it as the legend. ?>
                        <?php if (isset($fieldset->label)) : ?>
                            <legend><?php echo Text::_($fieldset->label); ?></legend>
                        <?php endif; ?>
                        <?php echo $this->form->renderFieldset($fieldset->name); ?>
                    </fieldset>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="com-users-registration__submit control-group mb-0">
                <div class="controls">
                    <button type="submit" class="com-users-registration__register btn btn-primary validate">
                        <?php echo Text::_('JREGISTER'); ?>
                    </button>
                    <input type="hidden" name="option" value="com_users">
                    <input type="hidden" name="task" value="registration.register">
                </div>
            </div>
        </div>
        <?php echo HTMLHelper::_('form.token'); ?>
    </form>
</div>