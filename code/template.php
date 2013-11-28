<doctype>
<html>
	<head>
		<w:head />
	</head>

	<body class="<?php echo $responsive; ?>">

		<!-- TODO: process <w:nav> for "position" toolbar -->

		<div class="<?php echo $containerClass; ?>">


			<header id="header">
				<div class="<?php echo $gridMode; ?> clearfix">
					<!-- TODO: process <w:logo> -->
					<div class="clear"></div>
				</div>
			</header>

			<!-- TODO: process <w:nav> for module "menu" -->
			<!-- TODO: process position "featured" (<w:module>) -->
			<!-- TODO: process position "grid-top" (<w:module>) -->
			<!-- TODO: process position "grid-top2" (<w:module>) -->

			<div id="main-content" class="<?php echo $gridMode; ?>">

				<aside id="sidebar1">
				<!-- TODO: process position "sidebar1" -->
				</aside>

				<section id="main">

					<!-- TODO: process position "above-content" -->
					<!-- TODO: process position "breadcrumbs" -->

					<w:content />

					<!-- TODO: process position "below-content" -->

				</section>

				<aside id="sidebar2">
					<!-- TODO: process position "sidebar2" -->
				</aside>

			</div>

			<!-- TODO: process position "grid-bottom" -->
			<!-- TODO: process position "grid-bottom2" -->
			<!-- TODO: process position "bottom-menu" -->

		</div>

		<!-- footer -->
		<div class="wrapper-footer">
			<footer id="footer" <?php if ($this->params['stickyFooter']) : ?> class="sticky" <?php endif; ?>>
				<div class="<?php echo $containerClass; ?> footer-content">
					<!-- TODO: process position "footer" -->
					<w:footer />
				</div>
			</footer>
		</div>

	</body>
</html>
