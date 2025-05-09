<?php get_header(); ?>

<div class="main-area container">
  <main id="content">
    <section class="roundedrectangle posts">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <?php get_template_part('template-parts/content', get_post_format()); ?>
        <?php endwhile;
      else : ?>
        <p>No posts found.</p>
      <?php endif; ?>

      <nav class="pagination">
        <?php the_posts_pagination(); ?>
      </nav>

    </section>

  </main>

  <aside class="roundedrectangle">
    <?php get_sidebar(); ?>
  </aside>
</div>

<?php get_footer(); ?>