<?php
/**
 * test Theme Customizer
 *
 * @package test
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function test_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport     = 'refresh';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'test_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'test_customize_partial_blogdescription',
			)
		);
	}

	// Important Links.
	$wp_customize->add_section( 'test_important_links', array(
		'priority'      => 999,
		'title'         => esc_html__( 'Enlaces importantes', 'test' ),
	) );

	// Has dummy Sanitizaition function as it contains no value to be sanitized.
	test_register_option( $wp_customize, array(
		'name'              => 'test_important_links',
		'sanitize_callback' => 'sanitize_text_field',
		'custom_control'    => 'Test_Important_Links_Control',
		'label'             => esc_html__( 'Important Links', 'test' ),
		'section'           => 'test_important_links',
		'type'              => 'test_important_links',
	)
);
// Important Links End.
}
add_action( 'customize_register', 'test_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function test_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function test_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function test_customize_preview_js() {
	wp_enqueue_script( 'test-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'test_customize_preview_js' );

/**
 * Include Custom Controls
 */
require get_parent_theme_file_path( 'inc/customizer/custom-controls.php' );

/**
 * Include Customizer Helper Functions
 */
require get_parent_theme_file_path( 'inc/customizer/helpers.php' );

/**
 * Include Sanitization functions
 */
require get_parent_theme_file_path( 'inc/customizer/sanitize-functions.php' );

/**
 * Include Header Media Options
 */
require get_parent_theme_file_path( 'inc/customizer/header-media.php' );

/**
 * Include Featured Content
 */
require get_parent_theme_file_path( 'inc/customizer/featured-content.php' );