<?php get_header(); ?>

<p class="not-found-title"><?php esc_html_e( 'Nothing here.', 'bearpress' ); ?></p>
<p class="not-found-content">
	<?php esc_html_e( 'The page you are looking for doesn\'t exist or has moved.', 'bearpress' ); ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( '← Go home', 'bearpress' ); ?></a>
</p>

<?php get_footer(); ?>
