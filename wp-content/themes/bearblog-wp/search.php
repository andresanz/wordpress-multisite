<?php get_header(); ?>

<header class="entry-header">
	<h1 class="entry-title">
		<?php
		printf(
			esc_html__( 'Search: %s', 'bearpress' ),
			'<span>' . get_search_query() . '</span>'
		);
		?>
	</h1>
</header>

<?php get_search_form(); ?>

<?php if ( have_posts() ) : ?>

	<ul class="post-list">
		<?php while ( have_posts() ) : the_post(); ?>
		<li class="post-list-item">
			<span class="post-list-date"><?php echo get_the_date( 'Y-m-d' ); ?></span>
			<span class="post-list-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</span>
		</li>
		<?php endwhile; ?>
	</ul>

	<?php the_posts_pagination( [ 'prev_text' => '← older', 'next_text' => 'newer →' ] ); ?>

<?php else : ?>
	<p><?php esc_html_e( 'No results found.', 'bearpress' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
