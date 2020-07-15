<?php
// Wright v.3 Override: Joomla 3.6.5
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2020 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* Wright v.3: Helper */
	include_once(dirname(__FILE__) . '/../com_content.helper.php');
/* End Wright v.3: Helper */


// Create a shortcut for params.
$params = &$this->item->params;
$images = json_decode($this->item->images);
$canEdit = $this->item->params->get('access-edit');
$info    = $this->item->params->get('info_block_position', 0);

?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
	<div class="system-unpublished">
<?php endif; ?>

<?php
/* Wright v.3: Item elements structure */
if (empty($this->item->wrightElementsStructure))    $this->item->wrightElementsStructure    = Array(
    "title",
    "icons",
    "article-info",
    "image",
    "legendtop",
    "content",
    "legendbottom",
    "article-info-below",
    "article-info-split"
);
if (!isset($this->item->wrightLegendTop))           $this->item->wrightLegendTop            = '';
if (!isset($this->item->wrightLegendBottom))        $this->item->wrightLegendBottom         = '';

// moved useDefList to the top, to set it throught the switch
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') );

foreach ($this->item->wrightElementsStructure as $wrightElement) :
    switch ($wrightElement) :

        case "title":
        ?>

            <?php if ($params->get('show_title')) : ?>
                <h2 class="item-title">
                <?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
                    <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>"> <?php echo $this->escape($this->item->title); ?></a>
                <?php else : ?>
                    <?php echo $this->escape($this->item->title); ?>
                <?php endif; ?>
                </h2>
            <?php endif; ?>

            <?php if ($this->item->state == 0) : ?>
                <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
            <?php endif; ?>

            <?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
                <span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
            <?php endif; ?>
            <?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00') : ?>
                <span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
            <?php endif; ?>

            <?php if (!$params->get('show_intro')) : ?>
                <?php echo $this->item->event->afterDisplayTitle; ?>
            <?php endif; ?>

            <?php
            break;

        /* End title */

        case "icons":
        ?>

            <?php if ($params->get('show_print_icon') || $params->get('show_email_icon') || $canEdit) : ?>
                <div class="btn-group pull-right icons-actions"> <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" role="button"> <span class="icon-cog"></span> <span class="caret"></span> </a>
                    <ul class="dropdown-menu">
                    <?php if ($params->get('show_print_icon')) : ?>
                        <li class="print-icon"> <?php echo JHtml::_('icon.print_popup', $this->item, $params); ?> </li>
                    <?php endif; ?>
                    <?php if ($params->get('show_email_icon')) : ?>
                        <li class="email-icon"> <?php echo JHtml::_('icon.email', $this->item, $params); ?> </li>
                    <?php endif; ?>
                    <?php if ($canEdit) : ?>
                        <li class="edit-icon"> <?php echo JHtml::_('icon.edit', $this->item, $params); ?> </li>
                    <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php
            break;

        /* End icons */

        case "article-info":
        case "article-info-below":
        case "article-info-split":

            switch($wrightElement) :

                default:
                case "article-info":

                    // Info and Tags above (when Position of Article Info is set as "above", or "split")
                    if ($useDefList && ($info == 0 || $info == 2)) :
                        echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above'));
                    endif;

                    if ($params->get('access-view') && $info == 0 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) :
                        $this->item->tagLayout = new JLayoutFile('joomla.content.tags');
                        echo $this->item->tagLayout->render($this->item->tags->itemTags);
                    endif;

                    break;

                case "article-info-below":

                    // Info and Tags below (when Position of Article Info is set as "below", and there is no "Read more" button)
                    if (!$this->item->readmore) :
                        if ($useDefList && $info == 1) :
                            echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below'));
                        endif;

                        if ($params->get('access-view') && $info == 1 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) :
                            $this->item->tagLayout = new JLayoutFile('joomla.content.tags');
                            echo $this->item->tagLayout->render($this->item->tags->itemTags);
                        endif;
                    endif;

                    break;

                case "article-info-split":

                    // Info and Tags below (when Position of Article Info is set as "split", and there is no "Read more" button)
                    if (!$this->item->readmore) :
                        if ($useDefList && $info == 2) :
                            echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below'));
                        endif;

                        if ($params->get('access-view') && $info == 2 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) :
                            $this->item->tagLayout = new JLayoutFile('joomla.content.tags');
                            echo $this->item->tagLayout->render($this->item->tags->itemTags);
                        endif;
                    endif;

                    break;

            endswitch;

            break;

        /* End article-info */

        case "image":
        ?>

            <?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
            <?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
            <div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image">
                <?php
                /* Wright v.3: Added link to the image from the article */
                if ($params->get('access-view')) :
                ?>
                <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid)); ?>">
                    <?php
                    endif;
                    /* End Wright v.3: Added link to the image from the article */
                    ?>
                    <img
                        <?php if ($images->image_intro_caption):
                            echo 'class="caption ' . $this->wrightBootstrapImages . '"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';  // Wright .v.3: Added image class
                        /* Wright v.3: Image class when no caption present */
                        else:
                            echo 'class="' . $this->wrightBootstrapImages . '"';
                            /* End Wright v.3: Image class when no caption present */
                        endif; ?>
                        src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>">
                    <?php
                    /* Wright v.3: Added link to the image from the article */
                    if ($params->get('access-view')) :
                    ?>
                </a>
            <?php
            endif;
            /* End Wright v.3: Added link to the image from the article */
            ?>
            </div>
        <?php endif; ?>

            <?php
            break;

        /* End image */

        case "content":
        ?>

            <?php echo $this->item->event->beforeDisplayContent; ?>
            <?php echo wrightTransformArticleContent($this->item->introtext);  // Wright v.3: Transform article content's plugins (using helper) ?>

            <?php if ($params->get('show_readmore') && $this->item->readmore) :

                // Info and Tags below (when Position of Article Info is set as "below" or "split", and there is a "Read more" button)
                if ($useDefList && ($info == 1 || $info == 2)) :
                    echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below'));
                endif;

                if ($params->get('access-view') && ($info == 1 || $info == 2) && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) :
                    $this->item->tagLayout = new JLayoutFile('joomla.content.tags');
                    echo $this->item->tagLayout->render($this->item->tags->itemTags);
                endif;

                if ($params->get('access-view')) :
                    $link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
                else :
                    $menu = JFactory::getApplication()->getMenu();
                    $active = $menu->getActive();
                    $itemId = $active->id;
                    $link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
                    $returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
                    $link = new JUri($link1);
                    $link->setVar('return', base64_encode($returnURL));
                endif; ?>

                <p class="readmore"><a class="btn" href="<?php echo $link; ?>"> <span class="icon-chevron-right"></span>

                <?php if (!$params->get('access-view')) :
                    echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');
                elseif ($readmore = $this->item->alternative_readmore) :
                    echo $readmore;
                    if ($params->get('show_readmore_title', 0) != 0) :
                    echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
                    endif;
                elseif ($params->get('show_readmore_title', 0) == 0) :
                    echo JText::sprintf('COM_CONTENT_READ_MORE_TITLE');
                else :
                    echo JText::_('COM_CONTENT_READ_MORE');
                    echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
                endif; ?>

                </a></p>

            <?php endif; ?>

            <?php
            break;

        /* End content */

        case "legendtop":

            if ($this->item->wrightLegendTop != '') :
            ?>
                <div class="wrightlegend-top"><?php echo $this->item->wrightLegendTop ?></div>
            <?php
            endif;

            break;

        /* End legendtop */

        case "legendbottom":

            if ($this->item->wrightLegendBottom != '') :
            ?>
            <div class="wrightlegend-bottom"><?php echo $this->item->wrightLegendBottom ?></div>
            <?php
            endif;

            break;

        /* End legendbottom */

        default:

            // accept any other div or HTML content in tag#id.class form, or /tag for closure
            if (preg_match("/^([\/]?)([a-z0-9-_]+?)([\#]?)([a-z0-9-_]*?)([\.]?)([a-z0-9-]*)$/iU", $wrightElement, $wrightDiv)) {
                echo '<' . $wrightDiv[1] . $wrightDiv[2] .
                    ($wrightDiv[1] != '' ? '' :
                        ($wrightDiv[3] != '' ? ' id="' . $wrightDiv[4] . '"' : '') .
                        ($wrightDiv[5] != '' ? ' class="' . $wrightDiv[6] . '"' : '')
                    )
                    . '>';
            }

            break;

        /* End default */

    endswitch;
endforeach;
/* End Wright v.3: Item elements structure */
?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent;
