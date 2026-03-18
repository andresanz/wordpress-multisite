<?php if ( post_password_required() ) return; ?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>

        <h2 class="comments-title">
            <?php
            $count = get_comments_number();
            printf(
                esc_html( _n( '%s comment', '%s comments', $count, 'bearpress' ) ),
                number_format_i18n( $count )
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php wp_list_comments( [
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 0,
                'callback'    => 'bearpress_comment',
            ] ); ?>
        </ol>

        <?php the_comments_navigation( [
            'prev_text' => __( '← older comments', 'bearpress' ),
            'next_text' => __( 'newer comments →', 'bearpress' ),
        ] ); ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'bearpress' ); ?></p>
    <?php endif; ?>

    <?php comment_form( [
        'title_reply'         => __( 'Leave a comment', 'bearpress' ),
        'label_submit'        => __( 'Post comment', 'bearpress' ),
        'comment_notes_before' => '',
        'comment_notes_after'  => '',
    ] ); ?>

</div>

<?php
function bearpress_comment( $comment, $args, $depth ) {
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment' ); ?>>
        <div class="comment-meta">
            <span class="comment-author">
                <cite class="fn"><?php comment_author(); ?></cite>
            </span>
            &mdash;
            <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                <?php echo get_comment_date( get_theme_mod( 'bearpress_date_format', 'Y-m-d' ) ); ?>
            </a>
            <?php edit_comment_link( __( 'edit', 'bearpress' ), ' · ' ); ?>
        </div>
        <div class="comment-content">
            <?php if ( '0' == $comment->comment_approved ) : ?>
                <p><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'bearpress' ); ?></em></p>
            <?php endif; ?>
            <?php comment_text(); ?>
        </div>
    <?php
}
