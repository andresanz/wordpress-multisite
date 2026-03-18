<?php
if ( post_password_required() ) return;
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<h2 class="comments-title">
			<?php
			$count = get_comments_number();
			printf(
				/* translators: %d: comment count */
				esc_html( _n( '%d comment', '%d comments', $count, 'bearpress' ) ),
				$count
			);
			?>
		</h2>

		<ol class="comment-list">
		<?php
		wp_list_comments( [
			'style'       => 'ol',
			'short_ping'  => true,
			'avatar_size' => 0,
			'callback'    => 'bearpress_comment',
		] );
		?>
		</ol>

		<?php the_comments_pagination( [
			'prev_text' => __( '← Older comments', 'bearpress' ),
			'next_text' => __( 'Newer comments →', 'bearpress' ),
			'class'     => 'pagination',
		] ); ?>

	<?php endif; ?>

	<?php
	comment_form( [
		'title_reply'        => __( 'Leave a comment', 'bearpress' ),
		'title_reply_before' => '<h3>',
		'title_reply_after'  => '</h3>',
		'class_container'    => 'comment-respond',
		'class_form'         => 'comment-form',
		'label_submit'       => __( 'Post comment', 'bearpress' ),
		'submit_button'      => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s">',
	] );
	?>

</div><!-- .comments-area -->

<?php
/**
 * Custom comment callback — no avatars, minimal markup.
 */
function bearpress_comment( $comment, $args, $depth ) {
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
		<div class="comment">
			<span class="comment-author"><?php comment_author( $comment ); ?></span>
			<span class="comment-date">
				<a href="<?php echo esc_url( get_comment_link( $comment ) ); ?>">
					<?php echo esc_html( get_comment_date( 'Y-m-d', $comment ) ); ?>
				</a>
			</span>
			<?php if ( '0' === $comment->comment_approved ) : ?>
				<p><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'bearpress' ); ?></em></p>
			<?php endif; ?>
			<div class="comment-body"><?php comment_text(); ?></div>
			<?php
			comment_reply_link( array_merge( $args, [
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<span class="reply-link">',
				'after'     => '</span>',
			] ) );
			?>
		</div>
	<?php
}
