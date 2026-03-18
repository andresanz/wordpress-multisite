<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <ul class="post-list">
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
        'mid_size'  => 2,
        'prev_text' => __( '← older', 'bearpress' ),
        'next_text' => __( 'newer →', 'bearpress' ),
        'class'     => 'pagination',
    ] ); ?>

<?php else : ?>
    <p><?php esc_html_e( 'No posts yet.', 'bearpress' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
