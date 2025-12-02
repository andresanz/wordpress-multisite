<?php
/**
 * Header for Andre Blank Slate Clean Child
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="site">
    <header class="site-header">
        <h1 class="site-title">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php bloginfo( 'name' ); ?>
            </a>
        </h1>
        <?php if ( get_bloginfo( 'description' ) ) : ?>
            <p class="site-description"><?php bloginfo( 'description' ); ?></p>
        <?php endif; ?>
    </header>

    <nav class="site-nav">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'fallback_cb'    => false,
            'depth'          => 1,
        ) );
        ?>
    </nav>
