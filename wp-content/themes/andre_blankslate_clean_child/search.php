<?php
/**
 * Search results template
 */
get_header(); ?>

<div class="site-main-wrapper">
    <main class="content-area">
        <div class="card">
        <header class="page-header">
            <h1 class="entry-title">
                <?php printf( __( 'Search results for: %s', 'andre-clean-child' ), get_search_query() ); ?>
            </h1>
        </header>

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header>
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="entry-meta">
                            <?php echo get_the_date(); ?>
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

            <p><?php _e( 'No results found.', 'andre-clean-child' ); ?></p>

        <?php endif; ?>
        </div><!-- .card -->
    </main>

    <?php get_sidebar(); ?>
</div><!-- .site-main-wrapper -->

<?php get_footer(); ?>
