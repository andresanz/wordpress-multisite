<?php get_header(); ?>

<header class="archive-header">
	<?php the_archive_title( '<h1 class="archive-title">', '</h1>' ); ?>
	<?php the_archive_description( '<p class="archive-description">', '</p>' ); ?>
</header>

<?php if ( have_posts() ) : ?>

	<?php
	$show_dates = get_theme_mod( 'bearpress_show_dates', true );
	?>

	<ul class="post-list">
	<?php while ( have_posts() ) : the_post(); ?>
		<li class="post-list-item">
			<?php if ( $show_dates ) : ?>
				<span class="post-list-date"><?php the_date( 'Y-m-d' ); ?></span>
			<?php endif; ?>
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
	<p class="not-found-content"><?php esc_html_e( 'No posts found.', 'bearpress' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
