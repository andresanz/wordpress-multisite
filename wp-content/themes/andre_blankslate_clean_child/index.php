<?php
/**
 * Main index template
 */
get_header(); ?>

<div class="site-main-wrapper">
    <main class="content-area">
        <div class="card">
        <?php if ( have_posts() ) : ?>

            <?php if ( ! is_singular() ) : ?>
                <header class="page-header">
                    <?php if ( is_home() && ! is_front_page() ) : ?>
                        <h1 class="entry-title"><?php single_post_title(); ?></h1>
                    <?php endif; ?>
                </header>
            <?php endif; ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header>
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="entry-meta">
                            <?php echo get_the_date(); ?>
                            <?php _e( '&nbsp;•&nbsp;', 'andre-clean-child' ); ?>
                            <?php the_category( ', ' ); ?>
                        </div>
                    </header>

                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
                <hr />
            <?php endwhile; ?>

            <nav class="pagination">
                <?php the_posts_pagination(); ?>
            </nav>

        <?php else : ?>

            <p><?php _e( 'No posts found.', 'andre-clean-child' ); ?></p>

        <?php endif; ?>
        </div><!-- .card -->
    </main>

    <?php get_sidebar(); ?>
</div><!-- .site-main-wrapper -->

<?php get_footer(); ?>
