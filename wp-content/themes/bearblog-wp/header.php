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
            <div class="site-title">
                <?php if ( is_front_page() && is_home() ) : ?>
                    <span><?php bloginfo( 'name' ); ?></span>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ( get_theme_mod( 'bearpress_show_tagline', true ) ) :
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                    <p class="site-description"><?php echo $description; ?></p>
                <?php endif;
            endif; ?>
        </div>

        <?php if ( has_nav_menu( 'primary' ) ) : ?>
            <nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary', 'bearpress' ); ?>">
                <?php wp_nav_menu( [
                    'theme_location' => 'primary',
                    'menu_class'     => '',
                    'container'      => false,
                    'depth'          => 1,
                ] ); ?>
            </nav>
        <?php endif; ?>
    </header>

    <main id="main" class="site-main">
