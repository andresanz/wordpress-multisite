<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'page' ); ?>>

        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>

        <div class="entry-content">
            <?php
            the_content();
            wp_link_pages( [
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bearpress' ),
                'after'  => '</div>',
            ] );
            ?>
        </div>

    </article>

    <?php if ( comments_open() || get_comments_number() ) : ?>
        <?php comments_template(); ?>
    <?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
