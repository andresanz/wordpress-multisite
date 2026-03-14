<?php get_header(); ?>

<article>
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( '404 — Page not found', 'bearpress' ); ?></h1>
	</header>
	<div class="entry-content">
		<p><?php esc_html_e( "The page you're looking for doesn't exist.", 'bearpress' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</article>

<?php get_footer(); ?>
