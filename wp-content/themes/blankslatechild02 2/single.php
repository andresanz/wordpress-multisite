<?php get_header(); ?>
<div class="main-area container">
    <main id="content" class="roundedrectangle">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', 'single'); ?>
                <?php comments_template(); ?>

                <nav class="post-navigation">
                    <div class="nav-links">
                        <div class="nav-previous">
                            <?php previous_post_link('%link', '← %title'); ?>
                        </div>
                        <div class="nav-next">
                            <?php next_post_link('%link', '%title →'); ?>
                        </div>
                    </div>
                </nav>

        <?php endwhile;
        endif; ?>
    </main>
    <aside class="roundedrectangle">
        <?php get_sidebar(); ?>
    </aside>
</div>
<?php get_footer(); ?>