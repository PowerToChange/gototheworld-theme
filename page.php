<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

include("header.php"); 
global $wp_query; $postid = $wp_query->post->ID;
?>

<div class="cf"></div>

<div class="g3 the_content" style="margin: 0;">
  

		      <?php while ( have_posts() ) : the_post(); ?>

        		<h2 class="vision"><?php the_title(); ?></h2>
        		<?php the_content(); ?>

        		<div class="social-buttons">
            <ul class="socs">
              <a href="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="Tweet this!" target="_blank"><li>Tweet <span class="icon" id="social-buttons">t</span></li></a>
              <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="Share on Facebook." target="_blank"><li>Share <span class="icon" id="social-buttons">l</span></li></a>
            </ul>
            </div>

      		<?php endwhile; // end of the loop. ?>
		
				</div>

			     <div class="g3">
			      <?php the_apply_project_button(); ?>
			     </div>
							
				<div class="cf"></div>
								
		   <div class="cf"></div>

<?php include("footer.php"); ?>
