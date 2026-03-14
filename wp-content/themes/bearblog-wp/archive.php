<?php get_header(); ?>

<header class="entry-header">
	<h1 class="entry-title">
		<?php
		if ( is_category() )      echo 'Category: ' . single_cat_title( '', false );
		elseif ( is_tag() )       echo '#' . single_tag_title( '', false );
		elseif ( is_author() )    echo 'Author: ' . get_the_author();
		elseif ( is_year() )      echo get_the_date( 'Y' );
		elseif ( is_month() )     echo get_the_date( 'F Y' );
		elseif ( is_day() )       echo get_the_date( 'F j, Y' );
		else                      esc_html_e( 'Archive', 'bearpress' );
		?>
	</h1>
</header>

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

	<?php
	the_posts_pagination( [
		'prev_text' => '← older',
		'next_text' => 'newer →',
		'class'     => 'pagination',
	] );
	?>

<?php else : ?>
	<p><?php esc_html_e( 'Nothing found.', 'bearpress' ); ?></p>
<?php endif; ?>

<?php get_footer(); ?>
