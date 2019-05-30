<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$params             = $this->item->params;

$displayGroups      = $params->get('show_user_custom_fields');
$userFieldGroups    = array();
?>

<?php if (!$displayGroups || !$this->contactUser) : ?>
    <?php return; ?>
<?php endif; ?>

<?php foreach ($this->contactUser->jcfields as $field) : ?>
    <?php if (!in_array('-1', $displayGroups) && (!$field->group_id || !in_array($field->group_id, $displayGroups))) : ?>
        <?php continue; ?>
    <?php endif; ?>
    <?php if (!array_key_exists($field->group_title, $userFieldGroups)) : ?>
        <?php $userFieldGroups[$field->group_title] = array(); ?>
    <?php endif; ?>
    <?php $userFieldGroups[$field->group_title][] = $field; ?>
<?php endforeach; ?>

<?php foreach ($userFieldGroups as $groupTitle => $fields) : ?>
    <?php $id = ApplicationHelper::stringURLSafe($groupTitle); ?>
    <?php echo '<h3>' . ($groupTitle ?: Text::_('COM_CONTACT_USER_FIELDS')) . '</h3>'; ?>

    <div class="com-contact__user-fields contact-profile mb-5" id="user-custom-fields-<?php echo $id; ?>">
        <dl class="dl-horizontal">
            <?php foreach ($fields as $field) : ?>
                <?php if (!$field->value) : ?>
                    <?php continue; ?>
                <?php endif; ?>

                <?php if ($field->params->get('showlabel')) : ?>
                    <?php echo '<dt>' . Text::_($field->label) . '</dt>'; ?>
                <?php endif; ?>

                <?php echo '<dd>' . $field->value . '</dd>'; ?>
            <?php endforeach; ?>
        </dl>
    </div>
<?php endforeach; ?>
