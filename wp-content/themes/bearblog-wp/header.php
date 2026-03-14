<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site">

	<header class="site-header">
		<p class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</p>

		<?php
		$desc = get_bloginfo( 'description', 'display' );
		if ( $desc ) : ?>
			<p class="site-description"><?php echo esc_html( $desc ); ?></p>
		<?php endif; ?>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'bearpress' ); ?>">
				<?php
				wp_nav_menu( [
					'theme_location' => 'primary',
					'menu_class'     => '',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'walker'         => new BearPress_Nav_Walker(),
				] );
				?>
			</nav>
		<?php endif; ?>
	</header>

	<main class="site-main" id="main">
<?php

/**
 * Minimal nav walker — outputs plain <a> links, no <ul><li> wrapper.
 */
class BearPress_Nav_Walker extends Walker_Nav_Menu {
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		$item    = $data_object;
		$classes = empty( $item->classes ) ? [] : (array) $item->classes;
		$class   = implode( ' ', array_filter( $classes ) );
		$url     = $item->url ? esc_url( $item->url ) : '#';
		$title   = apply_filters( 'the_title', $item->title, $item->ID );

		$output .= sprintf(
			'<a href="%s" class="%s">%s</a>',
			$url,
			esc_attr( $class ),
			esc_html( $title )
		);
	}
	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {}
}
