<?php

/**
 * Template part for displaying the top-nav searchform collapse widget
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 * @version 6.1.0
 */


// Exit if accessed directly
defined('ABSPATH') || exit;

?>


<!-- Collapse Search Mobile -->
<?php if (is_active_sidebar('top-nav-search')) : ?>
  <div class="collapse <?= apply_filters('bootscore/class/header/collapse', 'bg-body-tertiary position-absolute start-0 end-0'); ?> d-<?= apply_filters('bootscore/class/header/search/breakpoint', 'lg'); ?>-none" id="collapse-search">
    <div class="<?= apply_filters('bootscore/class/container', 'container', 'collapse-search'); ?> pb-2">
      <?php dynamic_sidebar('top-nav-search'); ?>
    </div>
  </div>
<?php endif; ?>
