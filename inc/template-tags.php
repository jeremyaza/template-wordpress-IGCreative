<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package test
 */

if ( ! function_exists( 'test_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function test_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'test' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'test_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function test_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'test' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'test_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function test_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'test' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Etiquetas %1$s', 'test' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ' ', 'test' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Categorias %1$s', 'test' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"> Comentarios ';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Deja un comentario <span class="screen-reader-text"> on %s</span>', 'test' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'test' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'test_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function test_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'test_single_image' ) ) :
	/**
	 * Display Single Page/Post Image
	 */
	function test_single_image() {
		global $post, $wp_query;

		if ( is_attachment() ) {
			$parent = $post->post_parent;
			$metabox_feat_img = get_post_meta( $parent, 'test-featured-image', true );
		} else {
			$metabox_feat_img = get_post_meta( $post->ID, 'test-featured-image', true );
		}

		if ( empty( $metabox_feat_img ) || ! is_singular() ) {
			$metabox_feat_img = 'default';
		}

		if ( ( 'disabled' == $metabox_feat_img  || ! has_post_thumbnail() ||  'default' == $metabox_feat_img ) ) {
			echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
			return false;
		}
		else {
			$class = '';

			if ( 'default' == $metabox_feat_img ) {
				$class = 'disabled';
			}
			else {
				$class = 'from-metabox ' . $metabox_feat_img;
				$metabox_feat_img = 'disabled';
			}

			?>
			<figure class="entry-image <?php echo esc_attr( $class ); ?>">
                <?php the_post_thumbnail( 'disabled' ); ?>
	        </figure>
	   	<?php
		}
	}
endif; // test_single_image.

/**
 * Footer Text
 *
 * @get footer text from theme options and display them accordingly
 * @display footer_text
 * @action test_footer
 *
 * @since 1.0
 */
function test_footer_content() {
	$theme_data = wp_get_theme();
	
	$footer_content = sprintf( _x( 'Copyright &copy; %1$s %2$s %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'test' ), esc_attr( date_i18n( __( 'Y', 'test' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', function_exists( 'get_the_privacy_policy_link' ) ? get_the_privacy_policy_link('| ') : '' ); ?>
	
	<!-- $footer_content = sprintf( _x( 'Copyright &copy; %1$s %2$s %3$s', '1: Year, 2: Site Title with home URL, 3: Privacy Policy Link', 'test' ), esc_attr( date_i18n( __( 'Y', 'test' ) ) ), '<a href="'. esc_url( home_url( '/' ) ) .'">'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>', function_exists( 'get_the_privacy_policy_link' ) ? get_the_privacy_policy_link('| ') : '' ) . '<span class="sep"> | </span>' . esc_html( $theme_data->get( 'Name' ) ) . '&nbsp;' . esc_html__( 'by', 'test' ) . '&nbsp;<a target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( $theme_data->get( 'Author' ) ) . '</a>'; ?> -->


	<div class="site-info">
		<div class="wrapper">
			<?php if ( $footer_content ) : ?>
				<div id="footer-content" class="copyright"> 
				 	<?php echo $footer_content; ?>
				</div>
			<?php endif; ?>
		</div><!-- .wrapper -->
	</div><!-- .site-info -->
<?php
}
add_action( 'test_credits', 'test_footer_content', 10 );