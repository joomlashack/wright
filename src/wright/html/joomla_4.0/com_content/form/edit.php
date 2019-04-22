<?php
/**
 * @package     Wright
 * @subpackage  HTML Layouts
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.  All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.tabstate');
HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

HTMLHelper::_('script', 'com_content/form-edit.js', ['version' => 'auto', 'relative' => true]);

$this->tab_name = 'com-content-form';
$this->ignore_fieldsets = array('image-intro', 'image-full', 'jmetadata', 'item_associations');

// Create shortcut to parameters.
$params = $this->state->get('params');

// This checks if the editor config options have ever been saved. If they haven't they will fall back to the original settings.
$editoroptions = isset($params->show_publishing_options);

if (!$editoroptions)
{
    $params->show_urls_images_frontend = '0';
}
?>
<div class="edit item-page">
    <?php if ($params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1>
                <?php echo $this->escape($params->get('page_heading')); ?>
            </h1>
        </div>
    <?php endif; ?>

    <form action="<?php echo Route::_('index.php?option=com_content&a_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
        <fieldset>
            <?php echo HTMLHelper::_('uitab.startTabSet', $this->tab_name, array('active' => 'editor')); ?>

            <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'editor', Text::_('COM_CONTENT_ARTICLE_CONTENT')); ?>
            <?php echo $this->form->renderField('title'); ?>

            <?php if (is_null($this->item->id)) : ?>
                <?php echo $this->form->renderField('alias'); ?>
            <?php endif; ?>

            <?php echo $this->form->getInput('articletext'); ?>

            <?php if ($this->captchaEnabled) : ?>
                <?php echo $this->form->renderField('captcha'); ?>
            <?php endif; ?>
            <?php echo HTMLHelper::_('uitab.endTab'); ?>

            <?php if ($params->get('show_urls_images_frontend')) : ?>
                <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'images', Text::_('COM_CONTENT_IMAGES_AND_URLS')); ?>
                <?php echo $this->form->renderField('image_intro', 'images'); ?>
                <?php echo $this->form->renderField('image_intro_alt', 'images'); ?>
                <?php echo $this->form->renderField('image_intro_caption', 'images'); ?>
                <?php echo $this->form->renderField('float_intro', 'images'); ?>
                <?php echo $this->form->renderField('image_fulltext', 'images'); ?>
                <?php echo $this->form->renderField('image_fulltext_alt', 'images'); ?>
                <?php echo $this->form->renderField('image_fulltext_caption', 'images'); ?>
                <?php echo $this->form->renderField('float_fulltext', 'images'); ?>
                <?php echo $this->form->renderField('urla', 'urls'); ?>
                <?php echo $this->form->renderField('urlatext', 'urls'); ?>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $this->form->getInput('targeta', 'urls'); ?>
                    </div>
                </div>
                <?php echo $this->form->renderField('urlb', 'urls'); ?>
                <?php echo $this->form->renderField('urlbtext', 'urls'); ?>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $this->form->getInput('targetb', 'urls'); ?>
                    </div>
                </div>
                <?php echo $this->form->renderField('urlc', 'urls'); ?>
                <?php echo $this->form->renderField('urlctext', 'urls'); ?>
                <div class="control-group">
                    <div class="controls">
                        <?php echo $this->form->getInput('targetc', 'urls'); ?>
                    </div>
                </div>
                <?php echo HTMLHelper::_('uitab.endTab'); ?>
            <?php endif; ?>

            <?php echo LayoutHelper::render('joomla.edit.params', $this); ?>

            <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'publishing', Text::_('COM_CONTENT_PUBLISHING')); ?>
            <?php echo $this->form->renderField('catid'); ?>
            <?php echo $this->form->renderField('tags'); ?>
            <?php if ($params->get('save_history', 0)) : ?>
                <?php echo $this->form->renderField('version_note'); ?>
            <?php endif; ?>
            <?php if ($params->get('show_publishing_options', 1) == 1) : ?>
                <?php echo $this->form->renderField('created_by_alias'); ?>
            <?php endif; ?>
            <?php if ((int) $this->item->id > 0) : ?>
                <?php echo $this->form->renderField('transition'); ?>
            <?php endif; ?>
            <?php if ($this->item->params->get('access-change')) : ?>
                <?php echo $this->form->renderField('featured'); ?>
                <?php if ($params->get('show_publishing_options', 1) == 1) : ?>
                    <?php echo $this->form->renderField('publish_up'); ?>
                    <?php echo $this->form->renderField('publish_down'); ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php echo $this->form->renderField('access'); ?>
            <?php if (is_null($this->item->id)) : ?>
                <div class="control-group">
                    <div class="control-label">
                    </div>
                    <div class="controls">
                        <?php echo Text::_('COM_CONTENT_ORDERING'); ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php echo HTMLHelper::_('uitab.endTab'); ?>

            <?php if (Multilanguage::isEnabled()) : ?>
                <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'language', Text::_('JFIELD_LANGUAGE_LABEL')); ?>
                <?php echo $this->form->renderField('language'); ?>
                <?php echo HTMLHelper::_('uitab.endTab'); ?>
            <?php else: ?>
                <?php echo $this->form->renderField('language'); ?>
            <?php endif; ?>

            <?php if ($params->get('show_publishing_options', 1) == 1) : ?>
                <?php echo HTMLHelper::_('uitab.addTab', $this->tab_name, 'metadata', Text::_('COM_CONTENT_METADATA')); ?>
                <?php echo $this->form->renderField('metadesc'); ?>
                <?php echo $this->form->renderField('metakey'); ?>
                <?php echo HTMLHelper::_('uitab.endTab'); ?>
            <?php endif; ?>

            <?php echo HTMLHelper::_('uitab.endTabSet'); ?>

            <input type="hidden" name="task" value="">
            <input type="hidden" name="return" value="<?php echo $this->return_page; ?>">
            <?php echo HTMLHelper::_('form.token'); ?>
        </fieldset>
        <div class="mb-2 mt-2">
            <button type="button" class="btn btn-primary" data-submit-task="article.save">
                <span class="fa fa-check" aria-hidden="true"></span>
                <?php echo Text::_('JSAVE'); ?>
            </button>
            <button type="button" class="btn btn-danger" data-submit-task="article.cancel">
                <span class="fa fa-times" aria-hidden="true"></span>
                <?php echo Text::_('JCANCEL'); ?>
            </button>
            <?php if ($params->get('save_history', 0) && $this->item->id) : ?>
                <?php echo $this->form->getInput('contenthistory'); ?>
            <?php endif; ?>
        </div>
    </form>
</div>
<?php
// Load frontediting.css as last CSS file
$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
$wa->enableAsset('template.wright.frontediting');
