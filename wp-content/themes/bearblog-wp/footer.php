	</main><!-- #main -->

	<footer class="site-footer">
		<span>
			&copy; <?php echo date( 'Y' ); ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
		</span>
		<span>
			<?php
			printf(
				/* translators: %s: WordPress link */
				esc_html__( 'Powered by %s', 'bearpress' ),
				'<a href="https://wordpress.org">WordPress</a>'
			);
			?>
		</span>
	</footer>

</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
