<?php
/**
* @copyright Copyright (C) 2010 Joomlashack LLC. All rights reserved.
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<doctype>
<html>
<head>
<w:head />

<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->document->template ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->document->template ?>/js/superfish.js"></script>
<script type="text/javascript">
jQuery.noConflict();
jQuery('document').ready(function(){
	jQuery('#navbar ul.menu')
	.find('li.current_page_item,li.current_page_parent,li.current_page_ancestor,li.current-cat,li.current-cat-parent,li.current-menu-item')
		.addClass('active')
		.end()
		.superfish({})
		jQuery('a.sf-with-ul').parent().addClass('sf-with-ul');
		});
</script>
</head>
<body>
	<!-- BEGIN HEADER -->
	<header id="header" class="container_12 clearfix">
		<?php // displays the logo
		BuildHeader::getHeader();
		?>
		<?php if($this->countModules('shackmenu')) : ?>
		<div id="menu_wrap">
			<div id="menu">		
					<?php BuildHeader::getMenu();?>
					<w:module type="single" name="shackmenu" chrome="none" />
				</div>
		</div>
		<?php endif; ?>
		<div class="clear"></div>
	</header>
	<!-- END HEADER -->
	<div id="navbar">
	<w:module type="single" name="menu" chrome="none" />
	</div>
	<!-- BEGIN CONTAINER -->
	<div id="wrap">
	<div id="container">

	<?php if($this->countModules('grid-top')) : ?>
	<!-- BEGIN USER1 MODULES -->
	<div id="leader">
	<div class="container_12 clearfix">
			<w:module type="grid" name="grid-top" chrome="wrightflexgrid" />
			<div class="clear"></div>
	</div>
	</div>
	<?php endif; ?>

	<div class="container_12 clearfix">
		<section id="main">
		<?php if ($this->countModules('breadcrumbs') && (JRequest::getVar('view') != 'frontpage')) : ?>
		<div id="breadcrumbs">
			<w:module type="single" name="breadcrumbs" chrome="none" />
		</div>
		<?php endif; ?>
		<w:module type="single" name="above-content" chrome="wrightCSS3" />
			<jdoc:include type="message" />
			<w:content above="false" below="false"/>
		<w:module type="single" name="below-content" chrome="wrightCSS3" />
		</section>
		<aside id="sidebar1">
			<w:module name="sidebar1" chrome="wrightCSS3" />
		</aside>
		<aside id="sidebar2">
			<w:module name="sidebar2" chrome="wrightCSS3" />
		</aside>
		<div class="clear">&nbsp;</div>
	</div><!-- /#main section -->
	<?php if($this->countModules('grid-bottom')) : ?>
	<!-- BOTTOM MODULES -->
	<div class="bottom">
		<div class="container_12 clearfix">
			<w:module type="grid" name="grid-bottom" chrome="wrightflexgrid" />
			<div class="clear">&nbsp;</div>
		</div>
	</div>
	<?php endif; ?>
	
<div class="clear"></div>
</div><!--/#container-->
</div><!--/wrap-->
<div class="footer_top">
<w:module type="single" name="footertext" chrome="none" />
</div>

<?php if($this->countModules('grid-footer')) : ?>
<!-- BOTTOM MODULES -->
<div class="bottom">
	<div class="container_12 clearfix">
		<w:module type="grid" name="grid-footer" chrome="wrightflexgrid" />
		<div class="clear">&nbsp;</div>
	</div>
</div>
<?php endif; ?>

<?php if (($this->countModules('user8')) || ($this->countModules('footer'))) : ?>
<div id="footer" class="container_12 clearfix">
		<?php if ($this->countModules('user8')) : ?>
		<div id="link" class="grid_8">
			<w:module type="single" name="user8" chrome="none" />
		</div>
		<?php endif; ?>
		<div class="clear"></div>
</div>
<?php endif; ?>
<w:footer />
<?php echo $this->params->get("footerscript",""); ?>
</body>
</html>