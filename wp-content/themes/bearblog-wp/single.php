<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-meta">
                <?php echo esc_html( bearpress_post_date() ); ?>
            </div>
        </header>

        <div class="entry-content">
            <?php
            the_content( sprintf(
                wp_kses(
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'bearpress' ),
                    [ 'span' => [ 'class' => [] ] ]
                ),
                wp_kses_post( get_the_title() )
            ) );

            wp_link_pages( [
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'bearpress' ),
                'after'  => '</div>',
            ] );
            ?>
        </div>

        <?php if ( get_theme_mod( 'bearpress_show_tags', true ) ) :
            $tags = get_the_tags();
            if ( $tags ) : ?>
                <div class="post-tags">
                    <?php foreach ( $tags as $tag ) : ?>
                        <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>">
                            <?php echo esc_html( $tag->name ); ?>
                        </a>
                        <?php echo ' '; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif;
        endif; ?>

    </article>

    <?php
    the_post_navigation( [
        'prev_text' => '<span class="nav-subtitle">' . esc_html__( '← previous', 'bearpress' ) . '</span> <span class="nav-title">%title</span>',
        'next_text' => '<span class="nav-subtitle">' . esc_html__( 'next →', 'bearpress' ) . '</span> <span class="nav-title">%title</span>',
        'class'     => 'post-navigation',
    ] );
    ?>

    <?php comments_template(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
