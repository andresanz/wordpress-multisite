<?php get_header(); ?>

<div class="main-area">
  <main class="roundedrectangle">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article <?php post_class(); ?>>
          <h2><?php the_title(); ?></h2>
          <?php the_content(); ?>
        </article>
    <?php endwhile;
    endif; ?>

    <div class="pagination">
      <?php
      the_posts_pagination(array(
        'mid_size' => 2,
        'prev_text' => __('&laquo; Prev'),
        'next_text' => __('Next &raquo;'),
      ));
      ?>
    </div>

  </main>

  <div class="roundedrectangle" style="background: var(--background-color-primary);">
    <?php get_sidebar(); ?>
  </div>

</div>

<?php get_footer(); ?>