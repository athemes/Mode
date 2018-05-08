<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Mode
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mode_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'mode_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function mode_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'mode_pingback_header' );

/**
 * Single comment template
 */
function mode_comment_template($comment, $args, $depth) {

	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body comment-entry clearfix">
			<figure class="comment-avatar">
				<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</figure>
			<div class="comment-text">
				<header class="comment-meta">
					<span class="comment-author">
					<?php printf( '<b class="fn">%s</b>', get_comment_author_link() ) ; ?>
					</span><!-- .comment-author -->
					<span class="comment-time">,
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
								/* translators: 1: comment date, 2: comment time */
								printf( __( '%1$s at %2$s', 'mode' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
						</time>
					</span><!-- .comment-metadata -->
					<a class="comment-href" href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<span class="sr-only"><?php _e( 'Direct link to comment', 'mode' ); ?></span>
						<i class="mo mo-link" aria-hidden="true"></i>
					</a>
				</header><!-- .comment-meta -->

				<div class="comment-content">
					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'mode' ); ?></p>
					<?php endif; ?>

					<?php comment_text(); ?>
				</div><!-- .comment-content -->
				<footer class="comment-links">
					<?php edit_comment_link( __( 'Edit', 'mode' ), '<span class="edit-link">', '</span>' ); ?>
					<?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<span class="reply-link">',
						'after'     => '</span>'
					) ) );
					?>
				</footer><!-- .comment-links -->
			</div>
		</article>
	<?php
}

/**
 * Move comment textarea to bottom.
 */
function mode_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
} 
add_filter( 'comment_form_fields', 'mode_move_comment_field_to_bottom' );

/**
 * Excerpt length
 */
function mode_excerpt_length( $length ) {

	if ( is_admin() ) {
		return $length;
	}

	$excerpt = get_theme_mod('mode_exc_length', '20');
	return $excerpt;
}
add_filter( 'excerpt_length', 'mode_excerpt_length', 999 );

/**
 * Excerpt read more
 * We are using a custom Read more position for highlighted posts
 */
function mode_custom_excerpt( $more ) {

	if ( is_admin() ) {
		return $more;
	}

	$more = get_theme_mod('mode_custom_read_more_regular');
  	if ( $more == '' ) {
    	return '<span class="read-more">[&hellip;]</span>';
	} else {
		return ' <a class="read-more" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . esc_html( $more ) . '</a>';
	}
}
add_filter( 'excerpt_more', 'mode_custom_excerpt' );