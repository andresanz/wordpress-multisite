<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

	<ul class="post-list">
		<?php while ( have_posts() ) : the_post(); ?>
		<li class="post-list-item">
			<span class="post-list-date">
				<?php echo get_the_date( 'Y-m-d' ); ?>
			</span>
			<span class="post-list-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</span>
		</li>
		<?php endwhile; ?>
	</ul>

	<?php
	the_posts_pagination( [
		'mid_size'  => 2,
		'prev_text' => '← older',
		'next_text' => 'newer →',
		'class'     => 'pagination',
	] );
	?>

<?php else : ?>
	<p><?php esc_html_e( 'No posts yet.', 'bearpress' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
