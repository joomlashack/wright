<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$params     = $displayData->params;
$images     = json_decode($displayData->images);
$imgfloat   = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>

<?php if (isset($images->image_fulltext) && !empty($images->image_fulltext)) : ?>
    <div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image">

        <?php if ($params->get('access-view')) : ?>
            <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid)); ?>">
        <?php endif; ?>
                <img class="<?php echo $displayData->wrightBootstrapImages; ?>" src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>" />
        <?php if ($params->get('access-view')) : ?>
            </a>
        <?php endif; ?>

        <?php if ($images->image_fulltext_caption !== ''): ?>
            <div class="caption <?php echo $displayData->wrightBootstrapImages; ?>">
                <?php echo htmlspecialchars($images->image_fulltext_caption); ?>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>