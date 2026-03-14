<?php
if ( post_password_required() ) return;
?>

<div class="comments-area" id="comments">

	<?php if ( have_comments() ) : ?>

		<h2 class="comments-title">
			<?php
			printf(
				esc_html( _nx( '%s comment', '%s comments', get_comments_number(), 'comments title', 'bearpress' ) ),
				number_format_i18n( get_comments_number() )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( [
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 0,
			] );
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p><?php esc_html_e( 'Comments are closed.', 'bearpress' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( [
		'title_reply'         => __( 'Leave a comment', 'bearpress' ),
		'title_reply_before'  => '<h2 class="comments-title">',
		'title_reply_after'   => '</h2>',
		'label_submit'        => __( 'Post comment', 'bearpress' ),
		'class_submit'        => 'submit',
		'class_form'          => 'comment-form',
	] );
	?>

</div>
