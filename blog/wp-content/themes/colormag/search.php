<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package ThemeGrill
 * @subpackage ColorMag
 * @since ColorMag 1.0
 */
?>

<?php get_header(); ?>

	<?php do_action( 'colormag_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">
			<?php if ( have_posts() ) : ?>

				<div class="article-container">

               <?php global $post_i; $post_i = 1; ?>

               <?php while ( have_posts() ) : the_post(); ?>

                  <?php get_template_part( 'content', 'archive' ); ?>

               <?php endwhile; ?>

            </div>

            <?php get_template_part( 'navigation', 'archive' ); ?>

         <?php else : ?>

            <?php get_template_part( 'no-results', 'archive' ); ?>

         <?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php colormag_sidebar_select(); ?>

	<?php do_action( 'colormag_after_body_content' ); ?>

<?php get_footer(); ?>