<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-link">← <?php bloginfo( 'name' ); ?></a>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="post-header">
			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-meta">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo get_the_date( 'F j, Y' ); ?>
				</time>
				<?php
				$categories = get_the_category();
				if ( $categories ) :
					echo '<span class="sep">·</span>';
					$cat_links = array_map( function( $cat ) {
						return '<a href="' . esc_url( get_category_link( $cat ) ) . '">' . esc_html( $cat->name ) . '</a>';
					}, $categories );
					echo implode( ', ', $cat_links );
				endif;
				?>
			</div>
		</header>

		<div class="post-content">
			<?php the_content(); ?>
		</div>

		<?php bearpress_post_tags(); ?>

	</article>

	<?php
	$prev = get_previous_post();
	$next = get_next_post();
	if ( $prev || $next ) : ?>
		<nav class="pagination" aria-label="<?php esc_attr_e( 'Post navigation', 'bearpress' ); ?>">
			<?php if ( $prev ) : ?>
				<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>">← <?php echo esc_html( get_the_title( $prev ) ); ?></a>
			<?php endif; ?>
			<?php if ( $next ) : ?>
				<a href="<?php echo esc_url( get_permalink( $next ) ); ?>"><?php echo esc_html( get_the_title( $next ) ); ?> →</a>
			<?php endif; ?>
		</nav>
	<?php endif; ?>

	<?php comments_template(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
