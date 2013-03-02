<?php
// Wright v.3 Override: Joomla 2.5.9
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/* Wright v.3: Bootstrapped images */
	$app = JFactory::getApplication();
	$template = $app->getTemplate(true);
	$this->wrightBootstrapImages = $template->params->get('wright_bootstrap_images','');
/* End Wright v.3: Bootstrapped images */

/* Wright v.3: Extra classes (general) */
	if (!isset($this->wrightLeadingItemsClass)) $this->wrightLeadingItemsClass = "";
	if (!isset($this->wrightIntroItemsClass)) $this->wrightIntroItemsClass = "";
/* End Wright v.3: Extra classes (general) */

/* Wright v.3: Item elements structure and extra elements */
	if (!isset($this->wrightLeadingItemElementsStructure)) $this->wrightLeadingItemElementsStructure = Array();
	if (!isset($this->wrightLeadingHasImageClass)) $this->wrightLeadingHasImageClass = "";
	if (!isset($this->wrightLeadingExtraClass)) $this->wrightLeadingExtraClass = "";

	if (!isset($this->wrightIntroItemElementsStructure)) $this->wrightIntroItemElementsStructure = Array();
	if (!isset($this->wrightIntroHasImageClass)) $this->wrightIntroHasImageClass = "";
	if (!isset($this->wrightIntroExtraClass)) $this->wrightIntroExtraClass = "";
/* End Wright v.3: Item elements structure and extra elements */


JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<div class="blog-featured<?php echo $this->pageclass_sfx;?>">
<?php if ( $this->params->get('show_page_heading')!=0) : ?>
	<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>

<?php
	/* Wright v.3: Extra Leading and Intro Items Div and Class */
	if (isset($this->wrightLeadingIntroItemsClass)) if ($this->wrightLeadingIntroItemsClass != "") :
?>
	<div class="<?php echo $this->wrightLeadingIntroItemsClass ?>">
<?php
	endif;
	/* End Wright v.3: Extra Leading and Intro Items Div and Class */
?>

<?php $leadingcount=0 ; ?>
<?php if (!empty($this->lead_items)) : ?>
<div class="items-leading<?php echo " " . $this->wrightLeadingItemsClass; // Wright v.3: Leading Items extra Class ?>">
	<?php foreach ($this->lead_items as &$item) : ?>
		<div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo ($this->wrightLeadingExtraClass != '' ? ' ' . $this->wrightLeadingExtraClass : ''); if ($this->wrightLeadingHasImageClass != '') { $images = json_decode($item->images); echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightLeadingHasImageClass : ''); } // Wright v.3: Item elements extra elements
		 ?>">
			<?php
				$this->item = &$item;
				$this->item->wrightElementsStructure = $this->wrightLeadingItemElementsStructure;  // Wright v.3: Item elements order
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
	$introcount=(count($this->intro_items));
	$counter=0;
?>
<?php if (!empty($this->intro_items)) : ?>
	<?php
		/* Wright v.3: Extra Intro Items Div and Class */
		if ($this->wrightIntroItemsClass != "") :
	?>
		<div class="<?php echo $this->wrightIntroItemsClass ?>">
	<?php
		endif;
		/* End Wright v.3: Extra Intro Items Div and Class */
	?>
	<?php foreach ($this->intro_items as $key => &$item) : ?>

	<?php
		$key= ($key-$leadingcount)+1;
		$rowcount=( ((int)$key-1) %	(int) $this->columns) +1;
		$row = $counter / $this->columns ;

		/* Wright v.3: Blog columns */
			$wrightspan = 1;
			switch ($this->columns) {
				case "1":
					$wrightspan = 12;
					break;
				case "2":
					$wrightspan = 6;
					break;
				case "3":
					$wrightspan = 4;
					break;
				case "4":
					$wrightspan = 3;
					break;
				case "5":
					$wrightspan = 2;
					break;
				case "6":
					$wrightspan = 2;
					break;
				default:
					$wrightspan = 1;
			}
		/* End Wright v.3: Blog columns */


		if ($rowcount==1) : ?>

			<div class="items-row cols-<?php echo (int) $this->columns;?> <?php echo 'row-'.$row ; ?><?php echo " row-fluid"; // Wright v.3: Blog columns ?>">
		<?php endif; ?>
		<div class="item column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished"' : null; ?><?php echo " span$wrightspan"; // Wright v.3: Blog columns ?><?php echo ($this->wrightIntroExtraClass != '' ? ' ' . $this->wrightIntroExtraClass : ''); if ($this->wrightIntroHasImageClass != '') { $images = json_decode($item->images); echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightIntroHasImageClass : ''); } // Wright v.3: Item elements extra elements
		 ?>">
			<?php
					$this->item = &$item;
					$this->item->wrightElementsStructure = $this->wrightIntroItemElementsStructure;  // Wright v.3: Item elements structure
					echo $this->loadTemplate('item');
			?>
		</div>
		<?php $counter++; ?>
			<?php if (($rowcount == $this->columns) or ($counter ==$introcount)): ?>
				<span class="row-separator"></span>
				</div>

			<?php endif; ?>
	<?php endforeach; ?>
	<?php
		/* Wright v.3: Extra Intro Items Div and Class */
		if ($this->wrightIntroItemsClass != "") :
	?>
		</div>
	<?php
		endif;
		/* End Wright v.3: Extra Intro Items Div and Class */
	?>
<?php endif; ?>

<?php
	/* Wright v.3: Extra Leading and Intro Items Div and Class */
	if (isset($this->wrightLeadingIntroItemsClass)) if ($this->wrightLeadingIntroItemsClass != "") :
?>
	</div>
<?php
	endif;
	/* End Wright v.3: Extra Leading and Intro Items Div and Class */
?>

<?php if (!empty($this->link_items)) : ?>
	<div class="items-more<?php echo " well"; // Wright v.3: More articles ?>">
	<?php echo $this->loadTemplate('links'); ?>
	</div>
<?php endif; ?>

<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<div class="pagination">

		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php  endif; ?>
				<?php echo wrightTransformArticlePagination($this->pagination->getPagesLinks());  // Wright v.3: Page Navigation transformation (using helper) ?>
	</div>
<?php endif; ?>

</div>
