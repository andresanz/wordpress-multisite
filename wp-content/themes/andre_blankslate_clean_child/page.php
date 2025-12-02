<?php
/**
 * Default page template with sidebar
 */
get_header(); ?>

<div class="site-main-wrapper">
    <main class="content-area">
        <div class="card">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

            <?php
            // Edit link
            edit_post_link( __( 'Edit', 'andre-clean-child' ), '<p>', '</p>' );
            ?>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>

        <?php endwhile; endif; ?>
        </div><!-- .card -->
    </main>

    <?php get_sidebar(); ?>
</div><!-- .site-main-wrapper -->

<?php get_footer(); ?>
