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

<div class="site-wrapper">

	<header class="site-header">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<span class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</span>
				<?php
				$tagline = get_bloginfo( 'description', 'display' );
				if ( $tagline && get_theme_mod( 'bearpress_inline_tagline', true ) ) : ?>
					<span class="site-tagline"><?php echo esc_html( $tagline ); ?></span>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary menu', 'bearpress' ); ?>">
				<?php
				wp_nav_menu( [
					'theme_location' => 'primary',
					'menu_class'     => '',
					'container'      => false,
					'depth'          => 1,
					'fallback_cb'    => false,
					'items_wrap'     => '%3$s',  // no wrapping ul — just bare <a> tags
					'walker'         => new BearPress_Nav_Walker(),
				] );
				?>
			</nav>
		<?php else : ?>
			<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary menu', 'bearpress' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'bearpress' ); ?></a>
				<?php if ( get_page_by_path( 'about' ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'bearpress' ); ?></a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>
	</header><!-- .site-header -->
