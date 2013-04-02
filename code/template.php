<doctype>
<html>
    <head>
        <w:head />
        <?php wp_head(); ?>
    </head>
    <body>
        <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <header class="entry-header">

                    <h1 class="entry-title"><?php the_title(); ?></h1>

                </header><!-- .entry-header -->

                
                <div class="entry-content">
                    <w:content />
                </div><!-- .entry-content -->


                <footer class="entry-meta">

                </footer><!-- .entry-meta -->
            </article><!-- #post -->


        <?php endwhile; ?>
        <?php endif; ?>
    </body>
</html>