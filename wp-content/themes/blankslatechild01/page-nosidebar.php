<?php

/**
 * Template Name: No Sidebar
 */
get_header(); ?>

<div class="main-area fullwidth container">
    <main id="content" class="roundedrectangle">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header>
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>

        <?php endwhile;
        endif; ?>
    </main>
</div>

<?php get_footer(); ?>