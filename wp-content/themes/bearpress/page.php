<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-link">← <?php bloginfo( 'name' ); ?></a>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="post-header">
			<h1 class="post-title"><?php the_title(); ?></h1>
		</header>

		<div class="post-content">
			<?php the_content(); ?>
		</div>

	</article>

	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>

<?php endwhile; ?>

<?php get_footer(); ?>
