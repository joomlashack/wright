<?php
// Wright v.3 Override: Joomla 2.5.14
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_category
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<ul class="category-module<?php echo $moduleclass_sfx; ?> nav nav-list">  <?php // Wright v.3: Added nav nav-list classes ?>
<?php if ($grouped) : ?>
	<?php foreach ($list as $group_name => $group) : ?>
	<li>
		<h<?php echo $item_heading; ?>><?php echo $group_name; ?></h<?php echo $item_heading; ?>>
		<ul class="nav nav-list">  <?php // Wright v.3: Added nav nav-list classes ?>
			<?php foreach ($group as $item) : ?>
				<li>
					<h<?php echo $item_heading+1; ?>>
					   	<?php if ($params->get('link_titles') == 1) : ?>
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
						<i class="icon-file"></i>  <?php // Wright v.3: Added icon ?>
						<?php echo $item->title; ?>
				        <?php if ($item->displayHits) :?>
							<span class="mod-articles-category-hits label label-info">  <?php // Wright v.3: Added label label-info classes ?>
							<i class="icon-eye-open"></i>  <?php // Wright v.3: Added icon ?>
				            <?php echo $item->displayHits; ?>  </span>  <?php // Wright v.3: Removed parenthesis ?>
				        <?php endif; ?></a>
				        <?php else :?>
				        <?php echo $item->title; ?>
				        	<?php if ($item->displayHits) :?>
							<span class="mod-articles-category-hits label label-info">  <?php // Wright v.3: Added label label-info classes ?>
							<i class="icon-eye-open"></i>  <?php // Wright v.3: Added icon ?>
				            <?php echo $item->displayHits; ?>  </span>  <?php // Wright v.3: Removed parenthesis ?>
				        <?php endif; ?></a>
				            <?php endif; ?>
			        </h<?php echo $item_heading+1; ?>>

					<ul class="nav nav-list">  <?php // Wright v.3: Sub-list ?>
						<?php if ($params->get('show_author')) :?>
							<li>  <?php // Wright v.3: Sub-list ?>
								<span class="mod-articles-category-writtenby">
				       			<i class="icon-user"></i>  <?php // Wright v.3: Added icon ?>
								<?php echo $item->displayAuthorName; ?>
								</span>
							</li>  <?php // Wright v.3: Sub-list ?>
						<?php endif;?>

						<?php if ($item->displayCategoryTitle) :?>
							<li>  <?php // Wright v.3: Sub-list ?>
								<span class="mod-articles-category-category">
								<i class="icon-folder-open"></i>  <?php // Wright v.3: Added icon and removed parenthesis ?>
								<?php echo $item->displayCategoryTitle; ?>
								</span>
							</li>  <?php // Wright v.3: Sub-list ?>
						<?php endif; ?>
						<?php if ($item->displayDate) : ?>
							<li>  <?php // Wright v.3: Sub-list ?>
								<span class="mod-articles-category-date"><i class="icon-calendar"></i>  <?php // Wright v.3: Added icon ?><?php echo $item->displayDate; ?></span>
							</li>  <?php // Wright v.3: Sub-list ?>
						<?php endif; ?>
						<?php if ($params->get('show_introtext')) :?>
							<li>  <?php // Wright v.3: Sub-list ?>
								<p class="mod-articles-category-introtext">
								<?php echo $item->displayIntrotext; ?>
								</p>
							</li>  <?php // Wright v.3: Sub-list ?>
						<?php endif; ?>

						<?php if ($params->get('show_readmore')) :?>
							<li>  <?php // Wright v.3: Sub-list ?>
								<p class="mod-articles-category-readmore">
									<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
									<?php if ($item->params->get('access-view')== FALSE) :
											echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE');
										elseif ($readmore = $item->alternative_readmore) :
											echo $readmore;
											echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
											if ($params->get('show_readmore_title', 0) != 0) :
												echo JHtml::_('string.truncate', ($this->item->title), $params->get('readmore_limit'));
											endif;
										elseif ($params->get('show_readmore_title', 0) == 0) :
											echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE');
										else :

											echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE');
											echo JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));
										endif; ?>
					        		</a>
								</p>
							</li>  <?php // Wright v.3: Sub-list ?>
						<?php endif; ?>
					</ul>  <?php // Wright v.3: Sub-list ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</li>
	<?php endforeach; ?>
<?php else : ?>
	<?php foreach ($list as $item) : ?>
	    <li>
	   	<h<?php echo $item_heading; ?>>
	   	<?php if ($params->get('link_titles') == 1) : ?>
		<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
			<i class="icon-file"></i>  <?php // Wright v.3: Added icon ?>
		<?php echo $item->title; ?>
        <?php if ($item->displayHits) :?>
			<span class="mod-articles-category-hits label label-info">  <?php // Wright v.3: Added label label-info classes ?>
			<i class="icon-eye-open"></i>  <?php // Wright v.3: Added icon ?>
            <?php echo $item->displayHits; ?>  </span>  <?php // Wright v.3: Removed parenthesis ?>
        <?php endif; ?></a>
        <?php else :?>
        <?php echo $item->title; ?>
        	<?php if ($item->displayHits) :?>
			<span class="mod-articles-category-hits label label-info">  <?php // Wright v.3: Added label label-info classes ?>
				<i class="icon-eye-open"></i>  <?php // Wright v.3: Added icon ?>
            <?php echo $item->displayHits; ?>  </span>  <?php // Wright v.3: Removed parenthesis ?>
        <?php endif; ?></a>
            <?php endif; ?>
        </h<?php echo $item_heading; ?>>

		<ul class="nav nav-list">  <?php // Wright v.3: Sub-list ?>

	       	<?php if ($params->get('show_author')) :?>
	       		<li>  <?php // Wright v.3: Sub-list ?>
		       		<span class="mod-articles-category-writtenby">
		       			<i class="icon-user"></i>  <?php // Wright v.3: Added icon ?>
					<?php echo $item->displayAuthorName; ?>
					</span>
				</li>  <?php // Wright v.3: Sub-list ?>
			<?php endif;?>
			<?php if ($item->displayCategoryTitle) :?>
	       		<li>  <?php // Wright v.3: Sub-list ?>
					<span class="mod-articles-category-category">
					<i class="icon-folder-open"></i>  <?php // Wright v.3: Added icon and removed parenthesis ?>
					<?php echo $item->displayCategoryTitle; ?>
					</span>
				</li>  <?php // Wright v.3: Sub-list ?>
			<?php endif; ?>
	        <?php if ($item->displayDate) : ?>
	       		<li>  <?php // Wright v.3: Sub-list ?>
					<span class="mod-articles-category-date"><i class="icon-calendar"></i>  <?php // Wright v.3: Added icon ?><?php echo $item->displayDate; ?></span>
				</li>  <?php // Wright v.3: Sub-list ?>
			<?php endif; ?>
			<?php if ($params->get('show_introtext')) :?>
	       		<li>  <?php // Wright v.3: Sub-list ?>
					<p class="mod-articles-category-introtext">
					<?php echo $item->displayIntrotext; ?>
					</p>
				</li>
			<?php endif; ?>

			<?php if ($params->get('show_readmore')) :?>
	       		<li>  <?php // Wright v.3: Sub-list ?>
					<p class="mod-articles-category-readmore">
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
				        <?php if ($item->params->get('access-view')== FALSE) :
								echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE');
							elseif ($readmore = $item->alternative_readmore) :
								echo $readmore;
								echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
							elseif ($params->get('show_readmore_title', 0) == 0) :
								echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE');
							else :
								echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE');
								echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
							endif; ?>
			        </a>
					</p>
				</li>
			<?php endif; ?>
		</ul>  <?php // Wright v.3: Sub-list ?>
	</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>
