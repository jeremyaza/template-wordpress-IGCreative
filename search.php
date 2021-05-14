<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package test
 */

get_header();
?>

	<main id="primary" class="site-main search-page">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h3 class="page-title">
					<span class="search-text">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Resultados de la búsqueda: %s', 'test' ), '<span>' . get_search_query() . '</span>' );
						?>
					</span>
				</h3>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
