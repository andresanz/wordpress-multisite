<?php

/**
 * Main template file
 */
get_header();
?>

<main id="content" role="main">

    <?php
    $domain = parse_url(get_site_url(), PHP_URL_HOST);

    switch ($domain) {
        case 'randomcategory.com':
    ?>
            <div class="box-cornsilk" style="margin-bottom: 60px;">
                <div style="margin: 12px;">
                    <div style="text-align: center;">
                        <p style="font-size: 2.25em; margin-bottom: 0;">Welcome to Random<wbr />Category.com</p>
                        <p style="font-size: 1.2em; margin-top: 0;">
                            A repository of (what I think are) interesting things.
                            You can email me at <a href="mailto:sanz.andre@gmail.com">sanz.andre@gmail.com</a>.
                            Thanks for visiting! <i class="fa-solid fa-peace"></i>
                        </p>
                    </div>
                </div>
            </div>
        <?php
            break;

        case 'nicetrybuddy.com':
        ?>
            <div class="box-cornsilk" style="margin-bottom: 22px;">
                <div style="margin: 12px;">
                    <div style="text-align: center;">
                        <p style="font-size: 2.25em; margin-bottom: 0;">Welcome to nicetrybuddy.com</p>
                        <p style="font-size: 1.2em; margin-top: 0;">
                            A repository of (what I think are) interesting things.
                            You can email me at <a href="mailto:sanz.andre@gmail.com">sanz.andre@gmail.com</a>.
                            Thanks for visiting! <i class="fa-solid fa-peace"></i>
                        </p>
                    </div>
                </div>
            </div>
        <?php
            break;

        case 'techthoughts.xyz':
        ?>
            <div class="box-lightblue" style="margin-bottom: 22px;">
                <div style="margin: 12px;">
                    <div style="text-align: center;">
                        <p style="font-size: 2.25em; margin-bottom: 0;">Welcome to TechThoughts.xyz</p>
                        <p style="font-size: 1.2em; margin-top: 0;">
                            Personal tech experiments, automation scripts, and other random nerd stuff.
                            Email: <a href="mailto:dre@techthoughts.xyz">dre@techthoughts.xyz</a>.
                            🤖💡
                        </p>
                    </div>
                </div>
            </div>
    <?php
            break;

        default:
            // Show nothing or a generic fallback if needed
            break;
    }
    ?>

    <div class="posts-container">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', 'post'); ?>
            <?php endwhile; ?>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <p><?php _e('No posts found.', 'blankslate-child'); ?></p>
        <?php endif; ?>


    </div>
</main>
<?php get_sidebar(); ?>

<?php get_footer(); ?>