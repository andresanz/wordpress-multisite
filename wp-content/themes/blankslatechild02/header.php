<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>

  <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/favicon/favicon.ico" type="image/x-icon">

</head>

<body <?php body_class(); ?>>
  <div class="container">
    <div class="roundedrectangle">
      <header style="background: var(--background-color-secondary);  padding: 1.10rem;">
        <h1><a href="<?php echo home_url(); ?>" style="text-decoration: none; color: var(--color-primary);"><?php bloginfo('name'); ?></a></h1>
        <h4 style="font-style:italic;"><?php bloginfo('description'); ?></h4>
      </header>
    </div>

    <div class="roundedrectangle">
      <nav>
        <?php
        wp_nav_menu(array(
          'theme_location' => 'main-menu',
          'container' => false, // <-- kills the <div>
          'menu_class' => 'menu' // <- adds class directly to <ul>
        ));
        ?>
      </nav>
    </div>