<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package test
 */

?>

	<footer id="colophon" class="site-footer">
		<!-- Displays footer widgets if assigned -->
		<?php
		if (
			is_active_sidebar( 'sidebar-2' ) ||
			is_active_sidebar( 'sidebar-3' ) ||
			is_active_sidebar( 'sidebar-4' ) ) :
		?>

			<aside <?php test_footer_sidebar_class(); ?> role="complementary">
				<div class="wrapper">
					<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
						<div class="widget-column footer-widget-1">
							<?php dynamic_sidebar( 'sidebar-2' ); ?>
						</div><!-- .widget-area -->
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
						<div class="widget-column footer-widget-2">
							<?php dynamic_sidebar( 'sidebar-3' ); ?>
						</div><!-- .widget-area -->
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
						<div class="widget-column footer-widget-3">
							<?php dynamic_sidebar( 'sidebar-4' ); ?>
						</div><!-- .widget-area -->
					<?php endif; ?>
				</div><!-- .footer-widgets-wrapper -->
			</aside><!-- .footer-widgets -->
		<?php endif;?>

		<div id="site-generator">
			<?php get_template_part('template-parts/footer/site-info'); ?>
		</div><!-- #site-generator -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
