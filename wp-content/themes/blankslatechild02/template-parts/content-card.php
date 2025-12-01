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

        <div class="entry-meta">
            <small>Posted on <?php echo get_the_date(); ?> in <?php the_category(', '); ?></small>
        </div>

        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div>

        <a class="read-more" href="<?php the_permalink(); ?>">Read more »</a>
    </div>
</article>