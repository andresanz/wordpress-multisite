<?php
get_header();
?>

<main id="primary" class="site-main rc-404 roundedrectangle">
  <section class="rc-404__wrap">
    <h1 class="rc-404__title">Nope.</h1>
    <p class="rc-404__text">
      This page doesn’t exist. Either the link is wrong or you moved it and forgot to tell the internet.
    </p>

    <!--
    <div class="rc-404__actions">
      <a class="rc-btn" href="<?php echo esc_url(home_url('/')); ?>">Go home</a>
    </div>
-->

    <div class="rc-404__search">
      <?php get_search_form(); ?>
    </div>
  </section>
</main>

<?php
get_footer();