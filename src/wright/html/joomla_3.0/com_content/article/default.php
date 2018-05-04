<?php
// Wright v.3 Override: Joomla 3.6.5
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* Wright v.3: Helper */
include_once(dirname(__FILE__) . '/../com_content.helper.php');

/* Wright v.3: Item elements structure and extra elements */
if (!isset($this->wrightElementsStructure)) $this->wrightElementsStructure  = Array();
if (!isset($this->wrightHasImageClass))     $this->wrightHasImageClass      = "";
if (!isset($this->wrightExtraClass))        $this->wrightExtraClass         = "";
if (!isset($this->wrightLegendTop))         $this->wrightLegendTop          = "";
if (!isset($this->wrightLegendBottom))      $this->wrightLegendBottom       = "";

if (empty($this->wrightElementsStructure)) :
    $this->wrightElementsStructure = Array(
        "title",
        "icons",
        "article-info",
        "image",
        "legendtop",
        "content",
        "legendbottom",
        "article-info-below",
        "article-info-split",
        "bottom"

    );
endif;

/* Wright v.3: Bootstrapped images */
$app                            = JFactory::getApplication();
$template                       = $app->getTemplate(true);
$this->wrightBootstrapImages    = $template->params->get('wright_bootstrap_images','');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Caption support
JHtml::_('behavior.caption');

// Create shortcuts to some parameters.
$params     = $this->item->params;
$images     = json_decode($this->item->images);
$urls       = json_decode($this->item->urls);
$canEdit    = $params->get('access-edit');
$user       = JFactory::getUser();
$info       = $params->get('info_block_position', 0);
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author'));

?>

<div class="item-page<?php echo $this->pageclass_sfx?><?php echo ($this->wrightExtraClass != '' ? ' ' . $this->wrightExtraClass : ''); if ($this->wrightHasImageClass != '') { echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightHasImageClass : ''); } // Wright v.3: Item elements extra elements
 ?>">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header">
		<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
	</div>
	<?php endif;
if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
{
 echo wrightTransformArticlePager($this->item->pagination);  // Wright v.3: Pager styles (using helper)
}
?>

	<?php if (!$useDefList && $this->print) : ?>
		<div id="pop-print" class="btn">
			<?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
		</div>
		<div class="clearfix"> </div>
	<?php endif; ?>

<?php 
/* Wright v.3: Item elements structure */
foreach ($this->wrightElementsStructure as $wrightElement) :
    switch ($wrightElement) :
        case "title":
        ?>

            <?php if ($params->get('show_title') || $params->get('show_author')) : ?>
                <?php /* Wright v.3: Adds page header if h1 is missing */
                if (!$params->get('show_page_heading')) : ?>
                <div class="page-header">
                <?php endif; /* End Wright v.3: Adds page header if h1 is missing */ ?>
                <h2>
                    <?php if ($params->get('show_title')) : ?>
                        <?php if ($params->get('link_titles') && !empty($this->item->readmore_link)) : ?>
                            <a href="<?php echo $this->item->readmore_link; ?>"> <?php echo $this->escape($this->item->title); ?></a>
                        <?php else : ?>
                            <?php echo $this->escape($this->item->title); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </h2>

                <?php if ($this->item->state == 0) : ?>
                    <span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
                <?php endif; ?>
                <?php if (strtotime($this->item->publish_up) > strtotime(JFactory::getDate())) : ?>
                    <span class="label label-warning"><?php echo JText::_('JNOTPUBLISHEDYET'); ?></span>
                <?php endif; ?>
                <?php if ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00') : ?>
                    <span class="label label-warning"><?php echo JText::_('JEXPIRED'); ?></span>
                <?php endif; ?>

                <?php /* Wright v.3: Adds page header if h1 is missing */
                if (!$params->get('show_page_heading')) : ?>
                </div>
                <?php endif; /* End Wright v.3: Adds page header if h1 is missing */ ?>

                <?php if (!$params->get('show_intro')) : echo $this->item->event->afterDisplayTitle; endif; ?>

            <?php endif;

            break;

        /* End title */

        case "icons":
        ?>

            <?php if (!$this->print) : ?>
                <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
                <div class="btn-group pull-right icons-actions">   <?php // Wright v.3: Added icons-actions class ?>
                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> <span class="icon-cog"></span> <span class="caret"></span> </a>
                    <?php // Note the actions class is deprecated. Use dropdown-menu instead. ?>
                    <ul class="dropdown-menu actions">
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
            <?php else : ?>
                <?php if ($useDefList) : ?>
                    <div id="pop-print" class="btn">
                        <?php echo JHtml::_('icon.print_screen', $this->item, $params); ?>
                    </div>
                <?php endif; ?>
            <?php endif;

            break;

        /* End icons */

        case "article-info":
        case "article-info-below":
        case "article-info-split":

            switch($wrightElement) :

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

                    // Info and Tags below (when Position of Article Info is set as "below")
                    if ($useDefList && $info == 1) :
                        echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below'));
                    endif;

                    if ($params->get('access-view') && $info == 1 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) :
                        $this->item->tagLayout = new JLayoutFile('joomla.content.tags');
                        echo $this->item->tagLayout->render($this->item->tags->itemTags);
                    endif;

                    break;

                case "article-info-split":

                    // Info and Tags below (when Position of Article Info is set as "split")
                    if ($useDefList && $info == 2) :
                        echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below'));
                    endif;

                    if ($params->get('access-view') && $info == 2 && $params->get('show_tags', 1) && !empty($this->item->tags->itemTags)) :
                        $this->item->tagLayout = new JLayoutFile('joomla.content.tags');
                        echo $this->item->tagLayout->render($this->item->tags->itemTags);
                    endif;

                    break;

            endswitch;

            break;

        /* End article-info */

        case "image":
        ?>

            <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '0')) || ($params->get('urls_position') == '0' && empty($urls->urls_position)))
                || (empty($urls->urls_position) && (!$params->get('urls_position')))) : ?>
            <?php echo $this->loadTemplate('links'); ?>
            <?php endif; ?>

            <?php if ($params->get('access-view')):?>
                <?php if (isset($images->image_fulltext) && !empty($images->image_fulltext)) : ?>
                <?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
                <div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image"> <img
                <?php if ($images->image_fulltext_caption):
                    echo 'class="caption ' . $this->wrightBootstrapImages . '"'.' title="' .htmlspecialchars($images->image_fulltext_caption) . '"';  // Wright .v.3: Added image class
                    /* Wright v.3: Image class when no caption present */
                    else:
                        echo 'class="' . $this->wrightBootstrapImages . '"';
                    /* End Wright v.3: Image class when no caption present */
                endif; ?>
                src="<?php echo htmlspecialchars($images->image_fulltext); ?>" alt="<?php echo htmlspecialchars($images->image_fulltext_alt); ?>" />
                </div>
                <?php endif; ?>
            <?php
            endif; // access-view

            break;

        /* End image */

        case "content":

            if ($params->get('access-view')) :

                echo $this->item->event->beforeDisplayContent;

                if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && !$this->item->paginationrelative):
                    echo wrightTransformArticlePager($this->item->pagination);  // Wright v.3: Pager styles (using helper)
                endif;
                ?>
                <?php if (isset ($this->item->toc)) :
                    echo wrightTransformArticleTOC($this->item->toc);  // Wright v.3: TOC transformation (using helper)
                endif; ?>
                <?php echo wrightTransformArticleContent($this->item->text);  // Wright v.3: Transform article content's plugins (using helper)
            endif; // access-view

            break;

        /* End content */

        case "bottom":

            if ($params->get('access-view')):   // access-view
            ?>

                <?php
                if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && !$this->item->paginationrelative):
                    echo wrightTransformArticlePager($this->item->pagination);  // Wright v.3: Pager styles (using helper)
                ?>
                    <?php endif; ?>
                    <?php if (isset($urls) && ((!empty($urls->urls_position) && ($urls->urls_position == '1')) || ($params->get('urls_position') == '1'))) : ?>
                    <?php echo $this->loadTemplate('links'); ?>
                    <?php endif; ?>
                    <?php // Optional teaser intro text for guests ?>
                    <?php elseif ($params->get('show_noauth') == true && $user->get('guest')) : ?>
                    <?php echo $this->item->introtext; ?>
                    <?php //Optional link to let them register to see the whole article. ?>
                    <?php if ($params->get('show_readmore') && $this->item->fulltext != null) :
                        $link1 = JRoute::_('index.php?option=com_users&view=login');
                        $link = new JUri($link1);?>
                    <p class="readmore">
                        <a href="<?php echo $link; ?>">
                        <?php $attribs = json_decode($this->item->attribs); ?>
                        <?php
                        if ($attribs->alternative_readmore == null) :
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
                        </a>
                    </p>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php
                if (!empty($this->item->pagination) && $this->item->pagination && $this->item->paginationposition && $this->item->paginationrelative) :
                 echo wrightTransformArticlePager($this->item->pagination);  // Wright v.3: Pager styles (using helper)
                ?>
            <?php endif;

            break;

        /* End bottom */

        case "legendtop":

            if ($this->wrightLegendTop != '') :
            ?>
                <div class="wrightlegend-top"><?php echo $this->wrightLegendTop ?></div>
            <?php
            endif;

            break;

        /* End legendtop */

        case "legendbottom":

            if ($this->wrightLegendBottom != '') :
            ?>
                <div class="wrightlegend-bottom"><?php echo $this->wrightLegendBottom ?></div>
            <?php
            endif;

            break;

        /* End legendbottom */

        default:

            if (preg_match("/^([\/]?)([a-z0-9-_]+?)([\#]?)([a-z0-9-_]*?)([\.]?)([a-z0-9-]*)$/iU", $wrightElement, $wrightDiv)) {
                echo '<' . $wrightDiv[1] . $wrightDiv[2] .
                    ($wrightDiv[1] != '' ? '' :
                        ($wrightDiv[3] != '' ? ' id="' . $wrightDiv[4] . '"' : '') .
                        ($wrightDiv[5] != '' ? ' class="' . $wrightDiv[6] . '"' : '')
                    )
                    . '>';
            }

        /* End default */

    endswitch;
endforeach;
/* End Wright v.3: Item elements structure */
?>

	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
