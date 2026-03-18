<?php get_header(); ?>

<?php if ( is_home() && ! is_front_page() ) : ?>
	<h1 class="screen-reader-text"><?php single_post_title(); ?></h1>
<?php endif; ?>

<?php if ( have_posts() ) : ?>

	<?php
	$group_by_year = get_theme_mod( 'bearpress_group_by_year', true );
	$show_dates    = get_theme_mod( 'bearpress_show_dates', true );
	$current_year  = '';
	?>

	<ul class="post-list">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$post_year = get_the_date( 'Y' );
		if ( $group_by_year && $post_year !== $current_year ) :
			$current_year = $post_year;
			echo '<li class="post-list-year">' . esc_html( $current_year ) . '</li>';
		endif;
		?>
		<li class="post-list-item">
			<?php if ( $show_dates ) : ?>
				<span class="post-list-date"><?php the_date( 'M j' ); ?></span>
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

	<p class="not-found-content"><?php esc_html_e( 'No posts yet.', 'bearpress' ); ?></p>

<?php endif; ?>

<?php get_footer(); ?>
