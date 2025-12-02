<?php get_header(); ?>
<div class="main-area container">

    <main id="content" class="roundedrectangle">

        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_category()) {
                    echo 'Category: ' . single_cat_title('', false);
                } elseif (is_tag()) {
                    echo 'Tag: ' . single_tag_title('', false);
                } elseif (is_search()) {
                    echo 'Search Results for: ' . get_search_query();
                } else {
                    the_archive_title();
                }
                ?>
            </h1>
            <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
        </header>

        <section class="posts">
            <?php if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
                <?php endwhile; ?>

                <?php the_posts_pagination(); ?>

            <?php else : ?>
                <?php get_template_part('template-parts/content', 'none'); ?>
            <?php endif; ?>
        </section>

    </main>

    <aside class="roundedrectangle">
        <?php get_sidebar(); ?>
    </aside>

</div>
<?php get_footer(); ?>