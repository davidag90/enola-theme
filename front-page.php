<?php

/**
 * Template Name: Full Width Image
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bootscore
 */

get_header();
?>

<div id="content" class="site-content">
	<div id="primary" class="content-area">

		<main id="main" class="site-main">
			
			<?php 
				$args = array(
					'post_type' => 'home_slides'
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ):
					if($query->post_count() > 1): ?>
						<div class="owl-carousel owl-theme height-75 bg-dark">
					<?php else: ?>
						<div class="height-75 bg-dark">
					<?php endif;
		        	
					while ( $query->have_posts() ) : $query->the_post();
						if($query->post_count() > 1): ?>
							<div class="owl-slide cover" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full') ?>)">
								<div class="d-flex align-items-end justify-content-center h-100">
									<div class="owl-slide-text text-center px-5 pb-4 mb-4">
										<h2 class="owl-slide-animated owl-slide-title text-light"><?php the_title(); ?></h2>
									</div><!-- .owl-slide-text -->
								</div>
							</div>
						<?php else: ?>
							<div class="cover h-100" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full') ?>)">
								<div class="d-flex align-items-end justify-content-center h-100">
									<div class="text-center px-5 pb-4 mb-4">
										<h2 class="text-light"><?php the_title(); ?></h2>
									</div><!-- .owl-slide-text -->
								</div>
							</div>
						<?php endif; ?>
					<?php endwhile; ?>
                <?php endif;

                wp_reset_postdata(); ?>
						</div><!-- .height-75 -->

			<div class="container">
				<!-- Hook to add something nice -->
				<?php bs_after_primary(); ?>

				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</div><!-- container -->

		</main><!-- #main -->

	</div><!-- #primary -->
</div><!-- #content -->
<?php get_footer(); ?>