<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* Wright v.4: Helper */
	include_once(dirname(__FILE__) . '/../com_content.helper.php');
/* End Wright v.4: Helper */

/* Wright v.4: Bootstrapped images */
	$app = JFactory::getApplication();
	$template = $app->getTemplate(true);
	$this->wrightBootstrapImages = $template->params->get('wright_bootstrap_images','');
/* End Wright v.4: Bootstrapped images */


/* Wright v.4: Item elements structure and extra elements */
	if (!isset($this->wrightLeadingItemElementsStructure)) $this->wrightLeadingItemElementsStructure = Array();
	if (!isset($this->wrightLeadingHasImageClass)) $this->wrightLeadingHasImageClass = "";
	if (!isset($this->wrightLeadingExtraClass)) $this->wrightLeadingExtraClass = "";

	if (!isset($this->wrightIntroItemElementsStructure)) $this->wrightIntroItemElementsStructure = Array();
	if (!isset($this->wrightIntroHasImageClass)) $this->wrightIntroHasImageClass = "";
	if (!isset($this->wrightIntroExtraClass)) $this->wrightIntroExtraClass = "";
/* End Wright v.4: Item elements structure and extra elements */

/* Wright v.4: Extra classes (general) */
	if (!isset($this->wrightLeadingItemsClass)) $this->wrightLeadingItemsClass = "";
	//if (!isset($this->wrightIntroRowsClass)) $this->wrightIntroRowsClass = "row"; // Not needed! Replaced with CSS Grid
	//if (!isset($this->wrightIntroItemsClass)) $this->wrightIntroItemsClass = ""; // Removed!

	if (!isset($this->wrightComplementOuterClass)) $this->wrightComplementOuterClass = "";
	if (!isset($this->wrightComplementExtraClass)) $this->wrightComplementExtraClass = "";
	if (!isset($this->wrightComplementInnerClass)) $this->wrightComplementInnerClass = "";

	if (!isset($this->wrightIntroRowMode)) $this->wrightIntroRowMode = 'row';

	if (!isset($this->wrightExtraDivH1)) $this->wrightExtraDivH1 = false;
/* End Wright v.4: Extra classes (general) */

/* Wright v.4: Extra container and row */
if (!isset($this->wrightNonContentContainer)) $this->wrightNonContentContainer = "";
if (!isset($this->wrightNonContentRowMode)) $this->wrightNonContentRowMode = "";
if (!isset($this->wrightContentExtraContainer)) $this->wrightContentExtraContainer = "";
//if (!isset($this->wrightImagesRow)) $this->wrightImagesRow = false; // Removed!

if (!isset($this->MoreItemsGridOrientation))
	{
		$this->MoreItemsGridOrientation = Array(
			'activeLayout' => '',
			'moreitemsLayout' => '',
			'subcategoriesLayout' => ''
		);
}

function addExtraNonContentContainers($wrightNonContentContainer, $wrightNonContentRowMode)
{
	if ($wrightNonContentContainer != '')
	{
		echo('<div class="' . $wrightNonContentContainer . '">');
	}
	if ($wrightNonContentRowMode != '')
	{
		echo('<div class="' . $wrightNonContentRowMode . '">');
	}
}

function addExtraNonContentContainersClose($wrightNonContentContainer, $wrightNonContentRowMode)
{
	if ($wrightNonContentRowMode != '')
	{
		echo('</div>');
	}
	if ($wrightNonContentContainer != '')
	{
		echo('</div>');
	}
}
/* End Wright v.4: Extra container and row */

/* Wright v.4: Special featured items grid */

	//if (!isset($this->specialItroItemsLayout)) $this->specialItroItemsLayout = Array('activeLayout' => false, 'layoutitemscolums' => 0); // Removed!
	if (!isset($this->layoutSpanorder)) $this->layoutSpanorder = Array();

/* End Wright v.4: Special featured items grid */

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

// JHtml::_('behavior.caption');
?>
<div class="blog<?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<?php
		// Wright v.4: Extra container and row
		addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<div class="page-header">
		<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		<?php if ($this->wrightExtraDivH1) : ?> <div class="title_in"></div> <?php endif;  // Wright v.4: Added optional extra div ?>
	</div>
	<?php
		// Wright v.4: Extra container and row
		addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<?php endif; ?>
	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>

	<?php
		// Wright v.4: Extra container and row
		addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<?php /* Wright v.4: Adds page header if h1 is missing */
	if (!$this->params->get('show_page_heading')) : ?>
	<div class="page-header">
	<?php endif; /* End Wright v.4: Adds page header if h1 is missing */ ?>

	<h2> <?php echo $this->escape($this->params->get('page_subheading')); ?>
		<?php if ($this->params->get('show_category_title')) : ?>
		<span class="subheading-category"><?php echo $this->category->title;?></span>
		<?php endif; ?>
	</h2>
	<?php
		// Wright v.4: Extra container and row
		addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>

	<?php /* Wright v.4: Adds page header if h1 is missing */
	if (!$this->params->get('show_page_heading')) : ?>
	</div>
	<?php endif; /* End Wright v.4: Adds page header if h1 is missing */ ?>

	<?php endif; ?>

	<?php if ($this->params->get('show_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php
			// Wright v.4: Extra container and row
			addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
		?>
		<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
		<?php
			// Wright v.4: Extra container and row
			addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
		?>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<?php
		// Wright v.4: Extra container and row
		addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<div class="category-desc clearfix">
		<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
			<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) : ?>
			<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
		<?php endif; ?>
	</div>
	<?php
		// Wright v.4: Extra container and row
		addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<?php endif; ?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (isset($this->wrightLeadingIntroItemsClass)) if ($this->wrightLeadingIntroItemsClass != "") echo '<div class="' . $this->wrightLeadingIntroItemsClass . '">'; // Wright v.4: Extra Leading and Intro Items Div and Class ?>

	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
	<div class="items-leading clearfix<?php echo " " . $this->wrightLeadingItemsClass; // Wright v.4: Leading Items extra Class ?>">
		<?php foreach ($this->lead_items as &$item) : ?>
		<div class="mb-5 leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo ($this->wrightLeadingExtraClass != '' ? ' ' . $this->wrightLeadingExtraClass : ''); if ($this->wrightLeadingHasImageClass != '') { $images = json_decode($item->images); echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightLeadingHasImageClass : ''); } // Wright v.4: Item elements extra elements
		 ?>">
			<div itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                <?php
				$this->item = &$item;
				$this->item->wrightElementsStructure = $this->wrightLeadingItemElementsStructure;  // Wright v.4: Item elements order
				$this->item->wrightType = 'leading';  // Wright v.4: Adding item type to identify in the proper override
				echo $this->loadTemplate('item');
			    ?>
            </div>
		</div>
		<?php
			$leadingcount++;
		?>
		<?php endforeach; ?>
	</div><!-- end items-leading -->
	<?php endif; ?>

	<div class="wf-row wf-cols-<?php echo (int) $this->columns;?>">

		<?php foreach ($this->intro_items as $key => &$item) : ?>

			<div class="wf-col">
				<div  itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting"
				      class="wf-item <?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo ($this->wrightIntroExtraClass != '' ? ' ' . $this->wrightIntroExtraClass : ''); if ($this->wrightIntroHasImageClass != '') { $images = json_decode($item->images); echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightIntroHasImageClass : ''); } // Wright v.4: Item elements extra elements
				 ?>">
                    <?php
                    $this->item = &$item;
                    $this->item->wrightElementsStructure = $this->wrightIntroItemElementsStructure;  // Wright v.4: Item elements structure
                    $this->item->wrightType = 'intro';  // Wright v.4: Adding item type to identify in the proper override
                    echo $this->loadTemplate('item');
                    ?>
				</div>
			</div>

		<?php endforeach; ?>

	</div>

	<?php if ($this->wrightComplementOuterClass != "") echo '<div class="' . $this->wrightComplementOuterClass . '">' // Wright v.4: Outer complements class  ?>

			<?php if ($this->MoreItemsGridOrientation['activeLayout'] != '') { // Wright v.4: Bootstrap grid layout

				if ( (empty($this->children[$this->category->id]) && $this->maxLevel == 0) || empty($this->link_items)) {

					$this->MoreItemsGridOrientation['moreitemsLayout'] = 12;
					$this->MoreItemsGridOrientation['subcategoriesLayout'] = 12;
				}
			}

			?>

			<?php if ($this->MoreItemsGridOrientation['activeLayout'] != '') : // Wright v.4: Bootstrap grid layout ?>
				<?php echo '<div class="' . $this->wrightIntroRowMode . '">' ?>
			<?php endif; // Wright v.4: Bootstrap grid layout ?>

			<?php if (!empty($this->link_items)) : ?>
			<?php
				// Wright v.4: Extra container and row
				addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>

			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : // Wright v.4: Bootstrap grid layout ?>
				<?php echo '<div class="col-md-' . $this->MoreItemsGridOrientation['moreitemsLayout'] . '">' ?>
			<?php endif; ?>

			<?php if ($this->wrightComplementExtraClass != "") echo '<div class="' . $this->wrightComplementExtraClass . '">' // Wright v.4: Extra complements class  ?>
			<div class="items-more<?php if ($this->wrightComplementInnerClass != "") echo ' ' . $this->wrightComplementInnerClass // Wright v.4: Inner complements class  ?>">
			<?php echo $this->loadTemplate('links'); ?>
			</div>
			<?php if ($this->wrightComplementExtraClass != "") echo '</div>' // Wright v.4: Extra complements class  ?>
			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : // Wright v.4: Bootstrap grid layout ?>
				<?php echo '</div>' // Wright v.4: Bootstrap grid layout ?>
			<?php endif; ?>
			<?php
				// Wright v.4: Extra container and row
				addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php endif; ?>

			<?php if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
			<?php
				// Wright v.4: Extra container and row
				addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : ?>
				<?php echo '<div class="col-md-' . $this->MoreItemsGridOrientation['subcategoriesLayout'] . '">' ?>
			<?php endif; ?>
			<?php if ($this->wrightComplementExtraClass != "") echo '<div class="' . $this->wrightComplementExtraClass . '">' // Wright v.4: Extra complements class  ?>
			<div class="cat-children<?php if ($this->wrightComplementInnerClass != "") echo ' ' . $this->wrightComplementInnerClass // Wright v.4: Inner complements class  ?>">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3> <?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
			<?php endif; ?>
				<?php echo $this->loadTemplate('children'); ?> </div>
			<?php if ($this->wrightComplementExtraClass != "") echo '</div>' // Wright v.4: Extra complements class  ?>
			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : // Wright v.4: Bootstrap grid layout ?>
				<?php echo '</div>' ?>
			<?php endif; // Wright v.4: Bootstrap grid layout ?>
			<?php
				// Wright v.4: Extra container and row
				addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php endif; ?>

			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : // Wright v.4: Bootstrap grid layout ?>
				<?php echo '</div>' ?>
			<?php endif; // Wright v.4: Bootstrap grid layout ?>

			<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
			<?php
				// Wright v.4: Extra container and row
				addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php if ($this->wrightComplementExtraClass != "") echo '<div class="' . $this->wrightComplementExtraClass . '">' // Wright v.4: Extra complements class  ?>
			<div class="container-pagination<?php if ($this->wrightComplementInnerClass != "") echo ' ' . $this->wrightComplementInnerClass // Wright v.4: Inner complements class  ?>">
				<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter float-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
				<?php endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?> </div>
				<?php if ($this->wrightComplementExtraClass != "") echo '</div>' // Wright v.4: Extra complements class  ?>
			<?php
				// Wright v.4: Extra container and row
				addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php  endif; ?>

	<?php if ($this->wrightComplementOuterClass != "") echo '</div>' // Wright v.4: Outer complements class  ?>

</div>
