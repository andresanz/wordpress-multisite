<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header>
        <h1 class="entry-title"><?php the_title(); ?></h1>

        <!--
        <div class="entry-meta">
            <small>Posted on <?php echo get_the_date(); ?> in <?php the_category(', '); ?></small>
        </div>
-->

        <!--        
<div class="entry-meta">
            <small>
                Posted on <?php echo get_the_date(); ?> in <?php the_category(', '); ?>
                <?php
                $tags = get_the_tags();
                if ($tags) {
                    echo ' &nbsp;•&nbsp; Tags: ';
                    $tag_links = array_map(function ($tag) {
                        return '<a href="' . get_tag_link($tag->term_id) . '">' . esc_html($tag->name) . '</a>';
                    }, $tags);
                    echo implode(', ', $tag_links);
                }
                ?>
            </small>
        </div>

            -->

        <div class="entry-meta">
            <small>
                Published:
                <time datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date(); ?>
                </time>

                <?php if (get_the_modified_date() !== get_the_date()) : ?>
                    <span class="separator"> • </span>
                    Last updated:
                    <time datetime="<?php echo get_the_modified_date('c'); ?>">
                        <?php echo get_the_modified_date(); ?>
                    </time>
                <?php endif; ?>

                <?php if (has_category()) : ?>
                    <span class="separator"> • </span>
                    Categories: <?php the_category(', '); ?>
                <?php endif; ?>

                <?php if (has_tag()) : ?>
                    <span class="separator"> • </span>
                    Tags: <?php the_tags('', ', '); ?>
                <?php endif; ?>
            </small>
        </div>

    </header>

    <!--
    <?php if (has_post_thumbnail()) :
        $full = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        $lowres = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium'); ?>

        <div class="featured-image">
            <a href="<?php echo esc_url($full[0]); ?>" target="_blank">
                <img src="<?php echo esc_url($lowres[0]); ?>" alt="<?php the_title_attribute(); ?>" class="single-post-thumbnail" />
            </a>
        </div>
    <?php endif; ?>
    -->


    <div class="entry-content">
        <?php the_content(); ?>


        <?php wp_link_pages(); ?>
    </div>

</article>