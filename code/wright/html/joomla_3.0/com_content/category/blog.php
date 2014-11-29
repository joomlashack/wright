<?php
// Wright v.3 Override: Joomla 3.2.2
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* Wright v.3: Helper */
	include_once(dirname(__FILE__) . '/../com_content.helper.php');
/* End Wright v.3: Helper */

/* Wright v.3: Bootstrapped images */
	$app = JFactory::getApplication();
	$template = $app->getTemplate(true);
	$this->wrightBootstrapImages = $template->params->get('wright_bootstrap_images','');
/* End Wright v.3: Bootstrapped images */


/* Wright v.3: Item elements structure and extra elements */
	if (!isset($this->wrightLeadingItemElementsStructure)) $this->wrightLeadingItemElementsStructure = Array();
	if (!isset($this->wrightLeadingHasImageClass)) $this->wrightLeadingHasImageClass = "";
	if (!isset($this->wrightLeadingExtraClass)) $this->wrightLeadingExtraClass = "";

	if (!isset($this->wrightIntroItemElementsStructure)) $this->wrightIntroItemElementsStructure = Array();
	if (!isset($this->wrightIntroHasImageClass)) $this->wrightIntroHasImageClass = "";
	if (!isset($this->wrightIntroExtraClass)) $this->wrightIntroExtraClass = "";
/* End Wright v.3: Item elements structure and extra elements */

/* Wright v.3: Extra classes (general) */
	if (!isset($this->wrightLeadingItemsClass)) $this->wrightLeadingItemsClass = "";
	if (!isset($this->wrightIntroRowsClass)) $this->wrightIntroRowsClass = "";
	if (!isset($this->wrightIntroItemsClass)) $this->wrightIntroItemsClass = "";

	if (!isset($this->wrightComplementOuterClass)) $this->wrightComplementOuterClass = "";
	if (!isset($this->wrightComplementExtraClass)) $this->wrightComplementExtraClass = "";
	if (!isset($this->wrightComplementInnerClass)) $this->wrightComplementInnerClass = "";

	if (!isset($this->wrightIntroRowMode)) $this->wrightIntroRowMode = 'row-fluid';

	if (!isset($this->wrightExtraDivH1)) $this->wrightExtraDivH1 = false;
/* End Wright v.3: Extra classes (general) */

/* Wright v.3: Extra container and row */
if (!isset($this->wrightNonContentContainer)) $this->wrightNonContentContainer = "";
if (!isset($this->wrightNonContentRowMode)) $this->wrightNonContentRowMode = "";
if (!isset($this->wrightContentExtraContainer)) $this->wrightContentExtraContainer = "";
if (!isset($this->wrightImagesRow)) $this->wrightImagesRow = false;

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
/* End Wright v.3: Extra container and row */

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');

JHtml::_('behavior.caption');
?>
<div class="blog<?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<?php
		// Wright v.3: Extra container and row
		addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<div class="page-header">
		<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		<?php if ($this->wrightExtraDivH1) : ?> <div class="title_in"></div> <?php endif;  // Wright v.3: Added optional extra div ?>
	</div>
	<?php
		// Wright v.3: Extra container and row
		addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<?php endif; ?>
	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>

	<?php
		// Wright v.3: Extra container and row
		addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<?php /* Wright v.3: Adds page header if h1 is missing */
	if (!$this->params->get('show_page_heading')) : ?>
	<div class="page-header">
	<?php endif; /* End Wright v.3: Adds page header if h1 is missing */ ?>

	<h2> <?php echo $this->escape($this->params->get('page_subheading')); ?>
		<?php if ($this->params->get('show_category_title')) : ?>
		<span class="subheading-category"><?php echo $this->category->title;?></span>
		<?php endif; ?>
	</h2>
	<?php
		// Wright v.3: Extra container and row
		addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>

	<?php /* Wright v.3: Adds page header if h1 is missing */
	if (!$this->params->get('show_page_heading')) : ?>
	</div>
	<?php endif; /* End Wright v.3: Adds page header if h1 is missing */ ?>

	<?php endif; ?>

	<?php if ($this->params->get('show_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php
			// Wright v.3: Extra container and row
			addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
		?>
		<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
		<?php
			// Wright v.3: Extra container and row
			addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
		?>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<?php
		// Wright v.3: Extra container and row
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
		// Wright v.3: Extra container and row
		addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
	?>
	<?php endif; ?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php if (isset($this->wrightLeadingIntroItemsClass)) if ($this->wrightLeadingIntroItemsClass != "") echo '<div class="' . $this->wrightLeadingIntroItemsClass . '">'; // Wright v.3: Extra Leading and Intro Items Div and Class ?>

	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
	<div class="items-leading clearfix<?php echo " " . $this->wrightLeadingItemsClass; // Wright v.3: Leading Items extra Class ?>">
		<?php foreach ($this->lead_items as &$item) : ?>
		<div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo ($this->wrightLeadingExtraClass != '' ? ' ' . $this->wrightLeadingExtraClass : ''); if ($this->wrightLeadingHasImageClass != '') { $images = json_decode($item->images); echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightLeadingHasImageClass : ''); } // Wright v.3: Item elements extra elements
		 ?>">
			<?php
				$this->item = &$item;
				$this->item->wrightElementsStructure = $this->wrightLeadingItemElementsStructure;  // Wright v.3: Item elements order
				$this->item->wrightType = 'leading';  // Wright v.3: Adding item type to identify in the proper override
				echo $this->loadTemplate('item');
			?>
		</div>
		<?php
			$leadingcount++;
		?>
		<?php endforeach; ?>
	</div><!-- end items-leading -->
	<?php endif; ?>
	<?php
	$introcount = (count($this->intro_items));
	$counter = 0;
?>
	<?php if (!empty($this->intro_items)) : ?>
	<?php if ($this->wrightIntroItemsClass != "") echo '<div class="' . $this->wrightIntroItemsClass . '">'; // Wright v.3: Extra Intro Items Div and Class ?>
	<?php foreach ($this->intro_items as $key => &$item) : ?>
		<?php $rowcount = ((int) $key % (int) $this->columns) + 1; ?>
		<?php if ($rowcount == 1) : ?>
			<?php $row = $counter / $this->columns; ?>

			<?php
				/* Wright v.3: Row buffer storage and image print in separate row */
				$wrightImagesRowExist = false;

				if ($this->wrightImagesRow)
				{
					ob_start();
					$wrightPreRowContent = '<div class="container-fluid container-images"><div class="row-fluid">';
				}
				/* End Wright v.3: Row buffer storage and image print in separate row */

				/* Wright v.3: Row extra container */
				if ($this->wrightContentExtraContainer != '')
				{
					echo('<div class="' . $this->wrightContentExtraContainer . '">');
				}
				/* End Wright v.3: Row extra container */
			?>

		<div class="items-row cols-<?php echo (int) $this->columns;?> <?php echo 'row-'.$row; ?> row-fluid clearfix<?php echo ($this->wrightIntroRowsClass != '' ? ' ' . $this->wrightIntroRowsClass : ''); // Wright v.3: Intro Rows Class ?>">
		<?php endif; ?>
			<?php
				/* Wright v.3: Parse and detect article images */
				$articleImages = json_decode($item->images);

				if ($articleImages && $articleImages->image_intro != '')
				{
					$wrightImagesRowExist = true;
				}
				/* End Wright v.3: Parse and detect article images */
			?>
			<div class="span<?php echo round((12 / $this->columns));?>">
				<div class="item column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?><?php echo ($this->wrightIntroExtraClass != '' ? ' ' . $this->wrightIntroExtraClass : ''); if ($this->wrightIntroHasImageClass != '') { $images = json_decode($item->images); echo ((isset($images->image_intro) and !empty($images->image_intro)) ? ' ' . $this->wrightIntroHasImageClass : ''); } // Wright v.3: Item elements extra elements
				 ?>">
					<?php
					$this->item = &$item;
					$this->item->wrightElementsStructure = $this->wrightIntroItemElementsStructure;  // Wright v.3: Item elements structure
					$this->item->wrightType = 'intro';  // Wright v.3: Adding item type to identify in the proper override
					echo $this->loadTemplate('item');
				?>
				</div><!-- end item -->

				<?php
					/* Wright v.3: Row buffer storage and image print in separate row */
					if ($this->wrightImagesRow)
					{
						$wrightPreRowContent .= '<div class="span' . round((12 / $this->columns)) . '">';

						if (isset($articleImages->image_intro) && !empty($articleImages->image_intro))
						{
							$imageLink = '';
							if ($item->params->get('access-view'))
							{
								$wrightPreRowContent .= '<a href="' . JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)) . '">';
							}
							$imageClass = $this->wrightBootstrapImages;
							$wrightPreRowContent .= '<img src="' . $articleImages->image_intro . '" alt="' . htmlspecialchars($articleImages->image_intro_alt) . '" class="' . $imageClass . '"' . ($articleImages->image_intro_caption ? ' title="' . $articleImages->image_intro_caption . '"' : '') . ' />';
							if ($item->params->get('access-view'))
							{
								$wrightPreRowContent .= '</a>';
							}
						}
						$wrightPreRowContent .= '</div>';
					}
					/* End Wright v.3: Row buffer storage and image print in separate row */
				?>

				<?php $counter++; ?>
			</div><!-- end span -->
			<?php if (($rowcount == $this->columns) or ($counter == $introcount)) : ?>
		</div><!-- end row -->

				<?php
					// Wright v.3: Row extra container
					if ($this->wrightContentExtraContainer != '')
					{
						echo('</div>');
					}

					/* Wright v.3: Row buffer storage and image print in separate row */
					if ($this->wrightImagesRow)
					{
						$wrightRowContent = ob_get_clean();
						$wrightPreRowContent .= '</div></div>';

						if ($wrightImagesRowExist)
						{
							echo $wrightPreRowContent;
						}

						echo $wrightRowContent;
					}
					/* End Wright v.3: Row buffer storage and image print in separate row */
				?>
			<?php endif; ?>
	<?php endforeach; ?>
	<?php if ($this->wrightIntroItemsClass != "") echo ('</div>'); // Wright v.3: Extra Intro Items Div and Class ?>
	<?php endif; ?>

	<?php if ($this->wrightComplementOuterClass != "") echo '<div class="' . $this->wrightComplementOuterClass . '">' // Wright v.3: Outer complements class  ?>

			<?php if ($this->MoreItemsGridOrientation['activeLayout'] != '') { // Wright v.3: Bootstrap grid layout 
		
				if ( (empty($this->children[$this->category->id]) && $this->maxLevel == 0) || empty($this->link_items)) {
						
					$this->MoreItemsGridOrientation['moreitemsLayout'] = 12;
					$this->MoreItemsGridOrientation['subcategoriesLayout'] = 12;
				}
			}

			?>

			<?php if ($this->MoreItemsGridOrientation['activeLayout'] != '') : // Wright v.3: Bootstrap grid layout ?>
				<?php echo '<div class="' . $this->wrightIntroRowMode . '">' ?>
			<?php endif; // Wright v.3: Bootstrap grid layout ?>

			<?php if (!empty($this->link_items)) : ?>
			<?php
				// Wright v.3: Extra container and row
				addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>

			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : // Wright v.3: Bootstrap grid layout ?>
				<?php echo '<div class="span' . $this->MoreItemsGridOrientation['moreitemsLayout'] . '">' ?>
			<?php endif; ?>

			<?php if ($this->wrightComplementExtraClass != "") echo '<div class="' . $this->wrightComplementExtraClass . '">' // Wright v.3: Extra complements class  ?>
			<div class="items-more<?php if ($this->wrightComplementInnerClass != "") echo ' ' . $this->wrightComplementInnerClass // Wright v.3: Inner complements class  ?>">
			<?php echo $this->loadTemplate('links'); ?>
			</div>
			<?php if ($this->wrightComplementExtraClass != "") echo '</div>' // Wright v.3: Extra complements class  ?>
			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : // Wright v.3: Bootstrap grid layout ?>
				<?php echo '</div>' // Wright v.3: Bootstrap grid layout ?>
			<?php endif; ?>
			<?php
				// Wright v.3: Extra container and row
				addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php endif; ?>
			
			<?php if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
			<?php
				// Wright v.3: Extra container and row
				addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : ?>
				<?php echo '<div class="span' . $this->MoreItemsGridOrientation['subcategoriesLayout'] . '">' ?>
			<?php endif; ?>	
			<?php if ($this->wrightComplementExtraClass != "") echo '<div class="' . $this->wrightComplementExtraClass . '">' // Wright v.3: Extra complements class  ?>
			<div class="cat-children<?php if ($this->wrightComplementInnerClass != "") echo ' ' . $this->wrightComplementInnerClass // Wright v.3: Inner complements class  ?>">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3> <?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
			<?php endif; ?>
				<?php echo $this->loadTemplate('children'); ?> </div>
			<?php if ($this->wrightComplementExtraClass != "") echo '</div>' // Wright v.3: Extra complements class  ?>
			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : // Wright v.3: Bootstrap grid layout ?>
				<?php echo '</div>' ?>
			<?php endif; // Wright v.3: Bootstrap grid layout ?>
			<?php
				// Wright v.3: Extra container and row
				addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php endif; ?>

			<?php if ($this->MoreItemsGridOrientation['activeLayout']) : // Wright v.3: Bootstrap grid layout ?> 
				<?php echo '</div>' ?>
			<?php endif; // Wright v.3: Bootstrap grid layout ?>
			
			<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
			<?php
				// Wright v.3: Extra container and row
				addExtraNonContentContainers($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php if ($this->wrightComplementExtraClass != "") echo '<div class="' . $this->wrightComplementExtraClass . '">' // Wright v.3: Extra complements class  ?>
			<div class="pagination<?php if ($this->wrightComplementInnerClass != "") echo ' ' . $this->wrightComplementInnerClass // Wright v.3: Inner complements class  ?>">
				<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
				<?php endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?> </div>
				<?php if ($this->wrightComplementExtraClass != "") echo '</div>' // Wright v.3: Extra complements class  ?>
			<?php
				// Wright v.3: Extra container and row
				addExtraNonContentContainersClose($this->wrightNonContentContainer, $this->wrightNonContentRowMode);
			?>
			<?php  endif; ?>

	<?php if ($this->wrightComplementOuterClass != "") echo '</div>' // Wright v.3: Outer complements class  ?>

</div>