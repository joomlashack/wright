<?php
/**
 * @package     Wright
 * @subpackage  Modules
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack.   All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

$module         = $displayData['module'];
$params         = $displayData['params'];
$attribs        = $displayData['attribs'];

if ($module->content) :

    $moduleTag      = $params->get('module_tag', 'div');
    $headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));
    $bootstrapSize  = (int) $params->get('bootstrap_size', 0);
    $moduleClass    = $bootstrapSize != 0 ? ' col-md-' . $bootstrapSize : '';

    // Temporarily store header class in variable
    $headerClass    = $params->get('header_class');
    $headerClass    = ($headerClass) ? ' class="' . htmlspecialchars($headerClass) . '"' : '';

    $module->content = preg_replace('/<([^>]+)class="([^""]*)' . $params->get('moduleclass_sfx') . '([^""]*)"([^>]*)>/sU', '<$1class="$2$3"$4>', $module->content);
    $content = trim($module->content);

    $extradivs = explode(',',$attribs['extradivs']);
    $extraclass = ($attribs['extraclass'] != '' ? ' ' . $attribs['extraclass'] : '');

    if (!empty ($content)) {
        ?>
        <<?php echo $moduleTag; ?> class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')) . $moduleClass; ?>">
              <?php if (in_array('module', $extradivs)) : ?>
            <div class="module-inner">
        <?php endif; ?>

        <?php if ($module->showtitle != 0) : ?>
            <<?php echo $headerTag . $headerClass . '>' . $module->title; ?></<?php echo $headerTag; ?>>
              <?php endif; ?>

        <?php echo $content; ?>

        <?php if (in_array('module', $extradivs)) : ?>
              </div>
              <?php endif; ?>
        </<?php echo $moduleTag; ?>>
    <?php
    }

endif; ?>