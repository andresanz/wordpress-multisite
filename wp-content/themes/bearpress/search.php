<?php get_header(); ?>

<header class="archive-header">
	<h1 class="archive-title">
		<?php
		printf(
			/* translators: %s: search query */
			esc_html__( 'Search: %s', 'bearpress' ),
			'<span>' . esc_html( get_search_query() ) . '</span>'
		);
		?>
	</h1>
</header>

<?php get_search_form(); ?>

<?php if ( have_posts() ) : ?>

	<ul class="post-list" style="margin-top:1rem">
	<?php while ( have_posts() ) : the_post(); ?>
		<li class="post-list-item">
			<span class="post-list-date"><?php the_date( 'Y-m-d' ); ?></span>
			<span class="post-list-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</span>
		</li>
	<?php endwhile; ?>
	</ul>

	<?php the_posts_pagination( [
		'prev_text' => __( '← Older', 'bearpress' ),
		'next_text' => __( 'Newer →', 'bearpress' ),
		'class'     => 'pagination',
	] ); ?>

<?php else : ?>
	<p class="not-found-content" style="margin-top:1rem"><?php esc_html_e( 'Nothing found. Try a different search.', 'bearpress' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
