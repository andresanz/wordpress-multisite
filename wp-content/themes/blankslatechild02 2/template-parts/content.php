<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
    <a href="<?php the_permalink(); ?>" class="post-thumbnail">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('medium');
        } else {
            echo '<img src="https://placehold.co/300x300?text=No+Image" alt="Placeholder Thumbnail">';
        }
        ?>
    </a>

    <div class="post-content">
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>

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


        <div class="entry-summary">
            <p class="excerpt">
                <?php echo wp_trim_words(get_the_content(), 40, ''); ?>
            </p>
        </div>

        <a class="read-more" href="<?php the_permalink(); ?>">Read more »</a>
    </div>
</article>