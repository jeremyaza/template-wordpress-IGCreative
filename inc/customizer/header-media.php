<?php
/**
 * Header Media Options
 *
 * @package Test
 */

/**
 * Add Header Media options
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function test_header_media_options( $wp_customize ) {
	$wp_customize->get_section( 'header_image' )->description = esc_html__( 'Selecciona en donde quieres que se muestre esta imagen de portada', 'test' );

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'test_sanitize_select',
			'choices'           => array(
				'homepage'               => esc_html__( 'Página de inicio / Portada', 'test' ),
				'entire-site'            => esc_html__( 'En todo el sitio', 'test' ),
				'disable'                => esc_html__( 'Deshabilitado', 'test' ),
			),
			'label'             => esc_html__( 'Activar en', 'test' ),
			'section'           => 'header_image',
			'type'              => 'select',
			'priority'          => 1,
		)
	);

	/*Overlay Option for Header Media*/
	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_image_content_max_width',
			'default'           => '480',
			'sanitize_callback' => 'test_sanitize_number_range',
			'label'             => esc_html__( 'Ancho máximo del contenedor (480px-1000px)', 'test' ),
			'section'           => 'header_image',

			'type'              => 'number',
			'input_attrs'       => array(
				'style' => 'width: 65px;',
				'min'   => 480,
				'max'   => 1000,
			),
		)
	);

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_logo',
			'sanitize_callback' => 'esc_url_raw',
			'custom_control'    => 'WP_Customize_Image_Control',
			'label'             => esc_html__( 'Logotipo multimedia de la cabecera', 'test' ),
			'section'           => 'header_image',
		)
	);

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_logo_option',
			'default'           => 'homepage',
			'sanitize_callback' => 'test_sanitize_select',
			'active_callback'   => 'test_is_header_media_logo_active',
			'choices'           => array(
				'homepage'               => esc_html__( 'Homepage / Frontpage', 'test' ),
				'entire-site'            => esc_html__( 'Entire Site', 'test' ) ),
			'label'             => esc_html__( 'Enable Header Media logo on', 'test' ),
			'section'           => 'header_image',
			'type'              => 'select',
		)
	);

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_before_subtitle',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Subtítulo antes del título', 'test' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_title',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Título multimedia de la cabecera', 'test' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_after_subtitle',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Subtítulo después del título', 'test' ),
			'section'           => 'header_image',
			'type'              => 'text',
		)
	);

    test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_text',
			'sanitize_callback' => 'wp_kses_post',
			'label'             => esc_html__( 'Texto de la cabecera del sitio', 'test' ),
			'section'           => 'header_image',
			'type'              => 'textarea',
		)
	);

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_url',
			'sanitize_callback' => 'esc_url_raw',
			'label'             => esc_html__( 'URL multimedia de la cabecera', 'test' ),
			'section'           => 'header_image',
		)
	);

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_media_url_text',
			'sanitize_callback' => 'sanitize_text_field',
			'label'             => esc_html__( 'Texto URL multimedia de la cabecera', 'test' ),
			'section'           => 'header_image',
		)
	);

	test_register_option( $wp_customize, array(
			'name'              => 'test_header_url_target',
			'sanitize_callback' => 'test_sanitize_checkbox',
			'label'             => esc_html__( 'Abrir una nueva ventana/pestaña', 'test' ),
			'section'           => 'header_image',
			'custom_control'    => 'Test_Toggle_Control',
		)
	);
}
add_action( 'customize_register', 'test_header_media_options' );

/** Active Callback Functions */

if ( ! function_exists( 'test_is_header_media_logo_active' ) ) :
	/**
	* Return true if header logo is active
	*
	* @since 1.0
	*/
	function test_is_header_media_logo_active( $control ) {
		$logo = $control->manager->get_setting( 'test_header_media_logo' )->value();
		if ( '' != $logo ) {
			return true;
		} else {
			return false;
		}
	}
endif;
