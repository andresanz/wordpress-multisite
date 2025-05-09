<div class="entry-meta">
    <span class="author vcard"
        <?php if (is_single()) {
            echo ' itemprop="author" itemscope itemtype="https://schema.org/Person"';
        } ?>>
        <span<?php if (is_single()) echo ' itemprop="name"'; ?>>
            <?php the_author_posts_link(); ?>
    </span>
    </span>

    <span class="meta-sep"> | </span>

    <a href="<?php echo esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))); ?>">
        <?php echo get_the_date(); ?>
    </a>

    <!-- Optional published time tag -->
    <!--
    <time class="entry-date" datetime="<?php echo esc_attr(get_the_date('c')); ?>"
        title="<?php echo esc_attr(get_the_date()); ?>"
        <?php if (is_single()) echo ' itemprop="datePublished" pubdate'; ?>>
        <?php the_time(get_option('date_format')); ?>
    </time>
    -->

    | <span class="cat-links"><?php _e('Category: ', 'blankslate-child'); ?><?php the_category(', '); ?></span>
    | <span class="tag-links"><?php the_tags(); ?></span>

    <?php if (is_single()) {
        echo '<meta itemprop="dateModified" content="' . esc_attr(get_the_modified_date()) . '">';
    } ?>
</div>