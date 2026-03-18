	<footer class="site-footer">
		<?php
		$footer_text = get_theme_mod( 'bearpress_footer_text', '' );
		if ( $footer_text ) {
			echo wp_kses_post( $footer_text );
		} else {
			printf(
				/* translators: %s: blog name */
				esc_html__( '%s', 'bearpress' ),
				'<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>'
			);
		}

		if ( has_nav_menu( 'footer' ) ) {
			echo ' · ';
			wp_nav_menu( [
				'theme_location' => 'footer',
				'container'      => false,
				'depth'          => 1,
				'fallback_cb'    => false,
				'items_wrap'     => '%3$s',
				'walker'         => new BearPress_Nav_Walker(),
			] );
		}
		?>
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="footer-widgets">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
		<?php endif; ?>
	</footer>

</div><!-- .site-wrapper -->
<?php wp_footer(); ?>
</body>
</html>
