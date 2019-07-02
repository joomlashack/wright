<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$canEdit = $displayData['params']->get('access-edit');

if ($canEdit) :
?>
    <div class="icons">
        <div class="btn-group float-right icons-actions">   <?php // Wright v.4: Added icons-actions class ?>
            <a class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" href="#"> <span class="fas fa-cog"></span> <span class="caret"></span> </a>
            <?php // Note the actions class is deprecated. Use dropdown-menu instead. ?>
            <ul class="dropdown-menu">
                <li class="edit-icon"> <?php echo JHtml::_('icon.edit', $displayData['item'], $displayData['params']); ?> </li>
            </ul>
        </div>
    </div>
<?php endif; ?>