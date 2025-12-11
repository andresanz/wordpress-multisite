<?php get_header(); ?>

<div class="main-area">
  <main id="content" class="roundedrectangle">
    <header class="archive-header">
      <h1 class="archive-title"><?php echo 'Category: ' . single_cat_title('', false); ?></h1>
      <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
    </header>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php get_template_part('template-parts/content', get_post_format()); ?>
    <?php endwhile; endif; ?>

    <nav class="pagination">
      <?php the_posts_pagination(); ?>
    </nav>
  </main>

  <aside class="roundedrectangle">
    <?php get_sidebar(); ?>
  </aside>
</div>

<?php get_footer(); ?>