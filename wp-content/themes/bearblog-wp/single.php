<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="entry-meta">
			<time datetime="<?php echo get_the_date( 'c' ); ?>">
				<?php echo get_the_date( 'F j, Y' ); ?>
			</time>
			<?php if ( get_the_author() ) : ?>
				<span>by <?php the_author_posts_link(); ?></span>
			<?php endif; ?>
			<?php
			$cats = get_the_category_list( ', ' );
			if ( $cats ) echo '<span>' . $cats . '</span>';
			?>
		</div>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

	<?php
	$tags = get_the_tag_list( '', ' ', '' );
	if ( $tags ) : ?>
	<footer class="entry-footer">
		<ul class="tag-list">
			<?php
			foreach ( get_the_tags() as $tag ) {
				printf(
					'<li><a href="%s">#%s</a></li>',
					esc_url( get_tag_link( $tag ) ),
					esc_html( $tag->slug )
				);
			}
			?>
		</ul>
	</footer>
	<?php endif; ?>

</article>

<?php
the_post_navigation( [
	'prev_text' => '← %title',
	'next_text' => '%title →',
] );

if ( comments_open() || get_comments_number() ) {
	comments_template();
}
?>

<?php endwhile; ?>

<?php get_footer(); ?>
