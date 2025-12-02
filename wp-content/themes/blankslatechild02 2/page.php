<?php get_header(); ?>

<div class="main-area container">
    <main id="content" class="roundedrectangle" role="main">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
        <?php endwhile;
        endif; ?>
    </main>

    <aside class="roundedrectangle" role="complementary">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>