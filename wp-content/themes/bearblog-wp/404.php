<?php get_header(); ?>

<div class="error-404">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( '404', 'bearpress' ); ?></h1>
    </header>
    <p><?php esc_html_e( 'Page not found.', 'bearpress' ); ?></p>
    <p style="margin-top:1rem;">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <?php esc_html_e( '← Go home', 'bearpress' ); ?>
        </a>
    </p>
</div>

<?php get_footer(); ?>
