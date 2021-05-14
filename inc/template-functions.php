<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package test
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function test_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Always add a front-page class to the front page.
	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'page-template-front-page';
	}

	// Adds a class of (full-width|box) to blogs.
	$classes[]                               = 'fluid-layout';
	$classes['test_menu_type']              = 'navigation-classic';
	$classes['test_primary_menu_alignment'] = 'menu-align-left';

	// Adds a class with respect to layout selected.
	$layout  = test_get_theme_layout();
	$sidebar = test_get_sidebar_id();

	$layout_class = "no-sidebar content-width-layout";

	if ( 'right-sidebar' === $layout ) {
		if ( '' !== $sidebar ) {
			$layout_class = 'two-columns-layout content-left';
		}
	}

	$classes[] = $layout_class;

	$classes['test_content_layout'] = 'excerpt-image-top';

	$classes[] = 'header-media-fluid';

	$header_image 		= test_featured_overall_image();

	if ( $enable_slider ) {
		$classes[] = 'has-featured-slider';
	}

	if ( 'disable' !== $header_image ) {
		$classes[] = 'has-header-media';
	}

	$classes['test_menu_layout'] = 'header-fluid';

	if ( $enable_slider || 'disable' !== $header_image ) {
		$classes[] = 'absolute-header';
	} else {
		$classes[] = 'non-absolute-header';
	}

	if ( ! test_has_header_media_text() ) {
		$classes[] = 'header-media-text-disabled';
	}

	// Add a class if there is a custom header.
	if ( has_header_image() && 'disable' !== $header_image ) {
		$classes[] = 'has-header-image';
	}

	// Added color scheme to body class.
	$classes['color_scheme'] = 'color-scheme-' . esc_attr( get_theme_mod( 'color_scheme', 'default' ) );

	return $classes;
}
add_filter( 'body_class', 'test_body_classes' );

if ( ! function_exists( 'test_sections' ) ) :
	/**
	 * Display Sections on header and footer with respect to the section option set in test_sections_sort
	 */
	function test_sections( $selector = 'header' ) {
		get_template_part( 'template-parts/header/header-media' );
	}
endif;

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function test_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'test_pingback_header' );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function test_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'test_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}
	}
}
add_action( 'pre_get_posts', 'test_alter_home' );

/**
 * Check if a section is enabled or not based on the $value parameter
 * @param  string $value Value of the section that is to be checked
 * @return boolean return true if section is enabled otherwise false
 */
function test_check_section( $value ) {
	return ( 'entire-site' == $value  || ( is_front_page() && 'homepage' === $value ) );
}

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since 1.0
 */
function test_get_first_image( $postID, $size, $attr, $src = false ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if ( isset( $matches[1][0] ) ) {
		// Get first image.
		$first_img = $matches[1][0];

		if ( $src ) {
			//Return url of src is true
			return $first_img;
		}

		return '<img class="wp-post-image" src="'. esc_url( $first_img ) .'">';
	}

	return false;
}

function test_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		$layout = 'no-sidebar';
	} elseif ( is_page_template( 'templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} else {
		$layout = get_theme_mod( 'test_default_layout', 'right-sidebar' );

		if ( is_front_page() ) {
			$layout = get_theme_mod( 'test_homepage_layout', 'right-sidebar' );
		} elseif ( is_home() || is_archive() || is_search() ) {
			$layout = get_theme_mod( 'test_archive_layout', 'right-sidebar' );
		}
	}

	return $layout;
}

function test_get_sidebar_id() {
	$sidebar = $id = '';

	$layout = test_get_theme_layout();

	if ( 'no-sidebar' === $layout ) {
		return $sidebar;
	}

		// Blog Page or Front Page setting in Reading Settings.
		if ( 'page' == get_option('show_on_front') ) {
	        $id = get_option('show_on_front');
	    } elseif ( is_singular() ) {
	    	global $post;

			$id = $post->ID;

	    	if ( is_attachment() ) {
				$id = $post->post_parent;
 			}
		}

	$sidebaroptions = get_post_meta( $id, 'test-sidebar-option', true );

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}

	return $sidebar;
}

if ( ! function_exists( 'test_truncate_phrase' ) ) :
	/**
	 * Return a phrase shortened in length to a maximum number of characters.
	 *
	 * Result will be truncated at the last white space in the original string. In this function the word separator is a
	 * single space. Other white space characters (like newlines and tabs) are ignored.
	 *
	 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
	 *
	 * @since 1.0
	 *
	 * @param string $text            A string to be shortened.
	 * @param integer $max_characters The maximum number of characters to return.
	 *
	 * @return string Truncated string
	 */
	function test_truncate_phrase( $text, $max_characters ) {

		$text = trim( $text );

		if ( mb_strlen( $text ) > $max_characters ) {
			//* Truncate $text to $max_characters + 1
			$text = mb_substr( $text, 0, $max_characters + 1 );

			//* Truncate to the last space in the truncated string
			$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
		}

		return $text;
	}
endif; //test_truncate_phrase

if ( ! function_exists( 'test_get_the_content_limit' ) ) :
	/**
	 * Return content stripped down and limited content.
	 *
	 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
	 *
	 * @since 1.0
	 *
	 * @param integer $max_characters The maximum number of characters to return.
	 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
	 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
	 *
	 * @return string Limited content.
	 */
	function test_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {

		$content = get_the_content( '', $stripteaser );

		// Strip tags and shortcodes so the content truncation count is done correctly.
		$content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );

		// Remove inline styles / .
		$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

		// Truncate $content to $max_char
		$content = test_truncate_phrase( $content, $max_characters );

		// More link?
		if ( $more_link_text ) {
			$link   = apply_filters( 'get_the_content_more_link', sprintf( '<a href="%s" class="more-link">%s</a>', esc_url( get_permalink() ), $more_link_text ), $more_link_text );
			$output = sprintf( '<p>%s %s</p>', $content, $link );
		} else {
			$output = sprintf( '<p>%s</p>', $content );
			$link = '';
		}

		return apply_filters( 'test_get_the_content_limit', $output, $content, $link, $max_characters );

	}
endif; //test_get_the_content_limit

if ( ! function_exists( 'test_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply fabulous-fluid your own test_content_image(), and that function will be used instead.
	 *
	 * @since 1.0
	 */
	function test_content_image() {
		if ( has_post_thumbnail() && test_jetpack_featured_image_display() && is_singular() ) {
			global $post, $wp_query;

			// Get Page ID outside Loop.
			$page_id = $wp_query->get_queried_object_id();

			if ( $post ) {
		 		if ( is_attachment() ) {
					$parent = $post->post_parent;

					$individual_featured_image = get_post_meta( $parent, 'test-featured-image', true );
				} else {
					$individual_featured_image = get_post_meta( $page_id, 'test-featured-image', true );
				}
			}

			if ( empty( $individual_featured_image ) ) {
				$individual_featured_image = 'default';
			}

			if ( 'disable' === $individual_featured_image ) {
				echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
				return false;
			} else {
				$class = array();

				$image_size = 'post-thumbnail';

				if ( 'default' !== $individual_featured_image ) {
					$image_size = $individual_featured_image;
					$class[]    = 'from-metabox';
				}

				$class[] = $individual_featured_image;
				?>
				<div class="post-thumbnail <?php echo esc_attr( implode( ' ', $class ) ); ?>">
					<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( $image_size ); ?>
					</a>
				</div>
		   	<?php
			}
		} // End if ().
	}
endif; // test_content_image.

/**
 * Adds Header Media container CSS
 */
function test_header_meadia_container_css() {

	$max_width = get_theme_mod( 'test_header_media_image_content_max_width', 480 );

	$css = '.home .custom-header-content .entry-container { max-width: ' . esc_attr( $max_width ) . 'px' . '; }';

	wp_add_inline_style( 'test-style', $css );
}
add_action( 'wp_enqueue_scripts', 'test_header_meadia_container_css', 11 );

/**
 * Adds Button Border Raduius CSS
 */
function test_button_border_radius_css() {

	$radius = '3';

	$css = 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, .posts-navigation .nav-links a, .pagination .nav-links .prev, .pagination .nav-links .next, .site-main #infinite-handle span button, .hero-content-wrapper .more-link, .promotion-sale-wrapper .hentry .more-link, .promotion-contact-wrapper .hentry .more-link, .recent-blog-content .more-recent-posts .more-link, .custom-header .more-link, .featured-slider-section .more-link, #feature-slider-section .more-link, .view-all-button .more-link, .woocommerce div.product form.cart .button, .woocommerce #respond input#submit, .woocommerce button.button, .woocommerce input.button, .pricing-section .hentry .more-link, .product-container .wc-forward, .promotion-section .more-link, #footer-newsletter .ewnewsletter .hentry form input[type="email"], #footer-newsletter .hentry.ew-newsletter-wrap.newsletter-action.custom input[type="text"], #footer-newsletter .hentry.ew-newsletter-wrap.newsletter-action.custom input[type="text"] ~ input[type="submit"], .app-section .more-link, .promotion-sale .more-link, .venue-section .more-link, .theme-scheme-music button.ghost-button > span, .theme-scheme-music .button.ghost-button > span, .theme-scheme-music .more-link.ghost-button > span { border-radius: ' . esc_attr( $radius ) . 'px' . '; }';

	wp_add_inline_style( 'test-style', $css );
}
add_action( 'wp_enqueue_scripts', 'test_button_border_radius_css', 11 );


if ( ! function_exists( 'test_entry_header' ) ) :
	/**
	 * Prints HTML with meta information for the date and author
	 *
	 * Create your own test_entry_header() function to override in a child theme.
	 *
	 * @since 1.0
	 */
	function test_entry_header() {
		echo '<div class="entry-meta">';

		$portfolio_categories_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<span class="portfolio-entry-meta entry-meta">', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'test' ), '</span>' );

		if ( 'jetpack-portfolio' === get_post_type() ) {
			printf( '<span class="cat-links"><span class="cat-label">%1$s: </span>%2$s</span>',
				sprintf( _x( 'Categories', 'Used before category names.', 'test' ) ),
				$portfolio_categories_list
			);
		}

		$categories_list = get_the_category_list( _x( ' ', 'Used between list items, there is a space after the comma.', 'test' ) );
		if ( $categories_list && test_categorized_blog( ) ) {
			printf( '<span class="cat-links"><span class="cat-label screen-reader-text">%1$s</span>%2$s</span>',
				sprintf( _x( 'Categories', 'Used before category names.', 'test' ) ),
				$categories_list
			);
		}

		// Get the author name; wrap it in a link.
		printf(
			/* translators: %s: post author */
			__( '<span class="byline screen-reader-text"> <span class="author-label screen-reader-text">By </span>%s', 'test' ),
			'<span class="author vcard screen-reader-text"><a class="url fn n screen-reader-text" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span></span>'
		);

		// Comments.
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link screen-reader-text">';
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'test' ), get_the_title() ) );
			echo '</span>';
		}

		echo '</div><!-- .entry-meta -->';
	}
endif;

if ( ! function_exists( 'test_content_display' ) ) :
	/**
	 * Displays excerpt, content or nothing according to option.
	 */
	function test_content_display( $show_content, $echo = true ) {
		$output = '';

		if ( $echo ) {
			if ( 'excerpt' === $show_content ) {
				?>
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->
				<?php
			} elseif ( 'full-content' === $show_content ) {
				?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php
			}

			return;
		} else {
			if ( 'excerpt' === $show_content ) {
				$output = '<div class="entry-summary"><p>'. get_the_excerpt() . '</p></div>';
			} elseif ( 'full-content' === $show_content ) {
				$output = '<div class="entry-content">'. get_the_content() . '</div>';
			}
		}

		return wp_kses_post( $output );
	}
endif;