<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
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

	if (!isset($this->wrightExtraDivH1)) $this->wrightExtraDivH1 = false;
/* End Wright v.4: Extra classes (general) */

/* Wright v.4: Extra container and row */
if (!isset($this->wrightNonContentContainer)) $this->wrightNonContentContainer = "";
if (!isset($this->wrightNonContentRowMode)) $this->wrightNonContentRowMode = "";
//if (!isset($this->wrightContentExtraContainer)) $this->wrightContentExtraContainer = ""; // Removed!
//if (!isset($this->wrightImagesRow)) $this->wrightImagesRow = false; // Removed!

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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// JHtml::_('behavior.caption');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<div class="blog-featured<?php echo $this->pageclass_sfx;?>">
<?php if ($this->params->get('show_page_heading') != 0) : ?>
<?php
	// Wright v.4: Extra container and row
	addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
?>
<div class="page-header">
	<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php if ($this->wrightExtraDivH1) : ?> <div class="title_in"></div> <?php endif;  // Wright v.4: Added optional extra div ?>
</div>
<?php
	// Wright v.4: Extra container and row
	addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
?>
<?php endif; ?>

<?php if (isset($this->wrightLeadingIntroItemsClass)) if ($this->wrightLeadingIntroItemsClass != "") echo '<div class="' . $this->wrightLeadingIntroItemsClass . '">'; // Wright v.4: Extra Leading and Intro Items Div and Class ?>
<?php $leadingcount = 0; ?>
<?php if (!empty($this->lead_items)) : ?>
<div class="items-leading clearfix<?php echo " " . $this->wrightLeadingItemsClass; // Wright v.4: Leading Items extra Class ?>">
	<?php foreach ($this->lead_items as &$item) : ?>
		<div class="mb-5 leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?> clearfix<?php echo ($this->wrightLeadingExtraClass != '' ? ' ' . $this->wrightLeadingExtraClass : ''); if ($this->wrightLeadingHasImageClass != '') { $images = json_decode($item->images); echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightLeadingHasImageClass : ''); } // Wright v.4: Item elements extra elements
		 ?>">
			<?php
				$this->item = &$item;
				$this->item->wrightElementsStructure = $this->wrightLeadingItemElementsStructure;  // Wright v.4: Item elements order
				$this->item->wrightType = 'leading';  // Wright v.4: Adding item type to identify in the proper override
				echo $this->loadTemplate('item');
			?>
		</div>
		<?php
			$leadingcount++;
		?>
	<?php endforeach; ?>
</div>
<?php endif; ?>

<?php
if (!empty($this->intro_items)) :
    /*
     * In order to set columns for intro_items,
     * through Menu item > Layout > Blog Class
     * set: cols-2 or cols-3 or cols-4 ... cols-12
     */
    ?>

	<div class="wf-row wf-<?php echo $this->params->get('blog_class');?>">

		<?php foreach ($this->intro_items as $key => &$item) : ?>

			<div class="wf-col">
				<div class="wf-item <?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo ($this->wrightIntroExtraClass != '' ? ' ' . $this->wrightIntroExtraClass : ''); if ($this->wrightIntroHasImageClass != '') { $images = json_decode($item->images); echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightIntroHasImageClass : ''); } // Wright v.4: Item elements extra elements
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

<?php endif; ?>

<?php if (isset($this->wrightLeadingIntroItemsClass)) if ($this->wrightLeadingIntroItemsClass != "") echo '</div>'; // Wright v.4: Extra Leading and Intro Items Div and Class ?>



<?php if ($this->wrightComplementOuterClass != "") echo '<div class="' . $this->wrightComplementOuterClass . '">' // Wright v.4: Outer complements class  ?>

<?php if (!empty($this->link_items)) : ?>
	<?php if ($this->wrightComplementExtraClass != "") echo '<div class="' . $this->wrightComplementExtraClass . '">' // Wright v.4: Extra complements class  ?>

	<div class="items-more<?php if ($this->wrightComplementInnerClass != "") echo ' ' . $this->wrightComplementInnerClass // Wright v.4: Inner complements class (also added well class)  ?>">
	<?php echo $this->loadTemplate('links'); ?>
	</div>
	<?php if ($this->wrightComplementExtraClass != "") echo '</div>' // Wright v.4: Extra complements class  ?>
<?php endif; ?>

<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>

	<?php if ($this->wrightComplementExtraClass != "") echo '<div class="' . $this->wrightComplementExtraClass . '">' // Wright v.4: Extra complements class  ?>

	<div class="container-pagination<?php if ($this->wrightComplementInnerClass != "") echo ' ' . $this->wrightComplementInnerClass // Wright v.4: Inner complements class  ?>">

		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter float-right">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php  endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php if ($this->wrightComplementExtraClass != "") echo '</div>' // Wright v.4: Extra complements class  ?>
<?php endif; ?>

<?php if ($this->wrightComplementOuterClass != "") echo '</div>' // Wright v.4: Outer complements class  ?>

</div>
