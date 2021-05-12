<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package test
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="body-template">
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'test' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a class="link_menu_scroll" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a class="link_menu_scroll" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$test_description = get_bloginfo( 'description', 'display' );
			if ( $test_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $test_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<!-- Button toggle -->
		<div id="menu_toggle" class="menu_toggle" onclick="toggleMenu()">
        	<div class="bars">
          		<div class="bar"></div>
          		<div class="bar"></div>
          		<div class="bar"></div>
        	</div>
      	</div>
		
		<!-- Menu main -->
		<div id="menu_wrapper_header" class="contain_menu_main">
			<div id="menu_slide" class="content_menu">
				<nav class="menu_wrapper">
					<div class="close_menu" onclick="toggleMenu()">
						<div class="close-1 x" id="close-1"></div>
						<div class="close-2 x" id="close-2"></div>
					</div>
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
					?>
				</nav>
				<div class="menu_bottom">
					<p><?php bloginfo( 'name' ); ?></p>
					<?php if ( has_nav_menu( 'social-primary' ) ) : ?>
						<?php 
							wp_nav_menu( array(
								'theme_location' 	=> 'social-primary',
								'menu_class'     	=> 'social-links-menu social-icons s-icons',
								'container'			=> '',
								'link_before'    	=> '<span class="screen-reader-text">',
							) );
						?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->

	<?php test_sections(); ?>