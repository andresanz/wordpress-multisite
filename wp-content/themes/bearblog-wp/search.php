<?php get_header(); ?>

<p class="search-results-heading">
    <?php
    printf(
        esc_html__( 'Search results for: %s', 'bearpress' ),
        '<strong>' . esc_html( get_search_query() ) . '</strong>'
    );
    ?>
</p>

<?php get_search_form(); ?>

<?php if ( have_posts() ) : ?>
    <ul class="post-list" style="margin-top:1.5rem;">
        <?php while ( have_posts() ) : the_post(); ?>
            <li class="post-list-item">
                <?php if ( get_theme_mod( 'bearpress_show_dates', true ) ) : ?>
                    <span class="post-list-date"><?php echo esc_html( bearpress_post_date() ); ?></span>
                <?php endif; ?>
                <span class="post-list-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </span>
            </li>
        <?php endwhile; ?>
    </ul>

    <?php the_posts_pagination( [
        'prev_text' => __( '← older', 'bearpress' ),
        'next_text' => __( 'newer →', 'bearpress' ),
        'class'     => 'pagination',
    ] ); ?>

<?php else : ?>
    <p style="margin-top:1.5rem;"><?php esc_html_e( 'Nothing found.', 'bearpress' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
