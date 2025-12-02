<?php
/**
 * Primary sidebar
 */

if ( ! is_active_sidebar( 'primary-sidebar' ) ) {
    return;
}
?>
<aside class="sidebar" role="complementary">
    <?php dynamic_sidebar( 'primary-sidebar' ); ?>
</aside>
