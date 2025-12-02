<?php
/**
 * Single post template
 */
get_header(); ?>

<div class="site-main-wrapper">
    <main class="content-area">
        <div class="card">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <?php echo get_the_date(); ?>
                        <?php _e( '&nbsp;•&nbsp;', 'andre-clean-child' ); ?>
                        <?php the_category( ', ' ); ?>
                    </div>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

            <?php the_post_navigation(); ?>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>

        <?php endwhile; endif; ?>
        </div><!-- .card -->
    </main>

    <?php get_sidebar(); ?>
</div><!-- .site-main-wrapper -->

<?php get_footer(); ?>
