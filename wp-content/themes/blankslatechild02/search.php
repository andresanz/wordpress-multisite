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
                    if (have_posts()) {
                        echo 'Search Results for: ' . get_search_query();
                    } else {
                        echo 'No results found for: ' . get_search_query();
                    }
                } else {
                    the_archive_title();
                }
                ?>
            </h1>
            <?php if (is_search() && !have_posts()) : ?>
                <div class="archive-description no-results">
                    <p>Nothing matched your search. Try a different keyword.</p>
                    <?php get_search_form(); ?>
                </div>
            <?php endif; ?>
            <?php if (!is_search()) : ?>
                <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
            <?php endif; ?>
        </header>

        <section class="posts">
            <?php if (have_posts()) :
                while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'card'); ?>
                <?php endwhile; ?>

                <?php the_posts_pagination(); ?>

            <?php else : ?>
                <?php if (!is_search()) : ?>
                    <?php get_template_part('template-parts/content', 'none'); ?>
                <?php endif; ?>
            <?php endif; ?>
        </section>

    </main>

    <aside class="roundedrectangle">
        <?php get_sidebar(); ?>
    </aside>

</div>
<?php get_footer(); ?>