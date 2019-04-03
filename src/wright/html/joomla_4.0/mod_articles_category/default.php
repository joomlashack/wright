<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2019 Joomlashack. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$wrightTypeList = (isset($wrightTypeList) ? $wrightTypeList : ' nav flex-column'); // Wright v.4: Optional list-striped class

$wrightEnableIcons = (isset($wrightEnableIcons) ? $wrightEnableIcons : true);  // Wright v.4: Enable icons parameter

$wrightIncludeImages = (isset($wrightIncludeImages) ? $wrightIncludeImages : true);  // Wright v.4: Include images

?>
<ul class="category-module<?php echo $moduleclass_sfx; ?><?php echo $wrightTypeList; // Wright v.4: Optional nav flex-column classes ?>">
<?php if ($grouped) : ?>
	<?php foreach ($list as $group_name => $group) : ?>
		<li class="nav-item">
			<ul class="nav flex-column">
				<?php foreach ($group as $item) : ?>
				<li class="nav-item">
					<?php if ($params->get('link_titles') == 1) : ?>
						<a class="mod-articles-category-title nav-link <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<i class="fas fa-file"></i> <?php // Wright v.4: Added icon ?>
							<?php echo $item->title; ?>
						</a>
					<?php else : ?>
						<span class="nav-link">
							<?php if($wrightEnableIcons): ?><i class="fas fa-file"></i> <?php endif; ?>  <?php // Wright v.4: Added icon ?>
							<?php echo $item->title; ?>
						</span>
					<?php endif; ?>

					<?php if ($item->displayHits or $params->get('show_author') or $item->displayCategoryTitle or $item->displayDate) : ?>
						<dl class="article-info text-muted nav-link">

							<?php if ($item->displayHits) :?>
								<dd class="mod-articles-category-hits">
									<i class="fas fa-eye"></i>  <?php // Wright v.4: Added icon and removed parenthesis ?>
									<?php echo $item->displayHits; ?>  </dd>
							<?php endif; ?>

							<?php if ($params->get('show_author')) :?>
								<dd class="mod-articles-category-writtenby">
									<i class="fas fa-user"></i>  <?php // Wright v.4: Added icon ?>
									<?php echo $item->displayAuthorName; ?>
								</dd>
							<?php endif;?>

							<?php if ($item->displayCategoryTitle) :?>
								<dd class="mod-articles-category-category">
									<i class="fas fa-folder-open"></i>  <?php // Wright v.4: Added icon and removed parenthesis ?>
									<?php echo $item->displayCategoryTitle; ?>
								</dd>
							<?php endif; ?>

							<?php if ($item->displayDate) : ?>
								<dd class="mod-articles-category-date">
									<i class="fas fa-calendar"></i>  <?php // Wright v.4: Added icon ?>
									<?php echo $item->displayDate; ?></dd>
							<?php endif; ?>

						</dl>
					<?php endif; ?>

					<?php if ($params->get('show_introtext')) :?>
						<div class="mod-articles-category-introtext nav-link">
							<?php echo $item->displayIntrotext; ?>
						</div>
					<?php endif; ?>

					<?php if ($params->get('show_readmore')) :?>
						<div class="readmore mod-articles-category-readmore nav-link">  <?php // Wright v.4: Added readmore nav-link classes ?>
						<a class="mod-articles-category-title <?php echo $item->active; ?> btn btn-secondary" href="<?php echo $item->link; ?>">  <?php // Wright v.4: Added btn btn-secondary classes ?>
						<?php if ($item->params->get('access-view') == false) :
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
						<i class="fas fa-chevron-right"></i>  <?php // Wright v.4: Added icon ?>
						</a>
						</div>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</li>
	<?php endforeach; ?>
<?php else : ?>
	<?php foreach ($list as $item) : ?>
		<li class="nav-item">
			<?php if ($params->get('link_titles') == 1) : ?>
				<a class="mod-articles-category-title nav-link <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
				<?php if($wrightEnableIcons): ?><i class="fas fa-file"></i> <?php endif; ?> <?php // Wright v.4: Added icon ?>
				<?php echo $item->title; ?>
				</a>
			<?php else : ?>
				<span class="nav-link">
					<?php if($wrightEnableIcons): ?><i class="fas fa-file"></i> <?php endif; ?> <?php // Wright v.4: Added icon ?>
					<?php echo $item->title; ?>
				</span>
			<?php endif; ?>

			<?php if ($item->displayHits or $params->get('show_author') or $item->displayCategoryTitle or $item->displayDate) : ?>
				<dl class="article-info text-muted nav-link">

					<?php if ($item->displayHits) :?>
						<dd class="mod-articles-category-hits">
						<i class="fas fa-eye"></i>  <?php // Wright v.4: Added icon and removed parenthesis ?>
							<?php echo $item->displayHits; ?>  </dd>
					<?php endif; ?>

					<?php if ($params->get('show_author')) :?>
						<dd class="mod-articles-category-writtenby">
							<i class="fas fa-user"></i>  <?php // Wright v.4: Added icon ?>
							<?php echo $item->displayAuthorName; ?>
						</dd>
					<?php endif;?>

					<?php if ($item->displayCategoryTitle) :?>
						<dd class="mod-articles-category-category">
						<i class="fas fa-folder-open"></i>  <?php // Wright v.4: Added icon and removed parenthesis ?>
							<?php echo $item->displayCategoryTitle; ?>
						</dd>
					<?php endif; ?>

					<?php if ($item->displayDate) : ?>
						<dd class="mod-articles-category-date">
						<i class="fas fa-calendar"></i>  <?php // Wright v.4: Added icon ?>
							<?php echo $item->displayDate; ?></dd>
					<?php endif; ?>

				</dl>
			<?php endif; ?>

			<?php if ($params->get('show_introtext')) :?>
				<div class="mod-articles-category-introtext nav-link">
				<?php echo $item->displayIntrotext; ?>
				</div>
			<?php endif; ?>

			<?php if ($params->get('show_readmore')) :?>
				<div class="readmore mod-articles-category-readmore nav-link">  <?php // Wright v.4: Added readmore nav-link classes ?>
				<a class="btn btn-secondary mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">  <?php // Wright v.4: Added btn btn-secondary classes ?>
					<?php if ($item->params->get('access-view') == false) :
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
					<i class="fas fa-chevron-right"></i>  <?php // Wright v.4: Added icon ?>
				</a>
				</div>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>
