<?php include("header.php"); 
global $wp_query, $donor; $postid = $wp_query->post->ID;
?>

<div class="cf"></div>

<div class="g3 the_content" style="margin: 0;">
  

		      <?php while ( have_posts() ) : the_post(); ?>

      			<?php if ( 'post' == get_post_type() ) : ?>
        		<?php endif; ?>
        		<h2 class="vision"><?php project_title(); ?></h2>
        		<div class="autofit">
        		<div class="projectdata">
        		<?php 
        		$the_id = get_the_ID();
        		foreach (array('Cost' => 'C', 'Location' => '$', 'Length' => 'N', 'Dates' => 'P', 'Deadline' => 'P') as $key => $value) {
					$v = get_post_meta($the_id, strtolower($key), true);
					if($v != '') echo "<div class=\"projectinfo\"><h3>$key <span class=\"icon\">$value</span></h3>$v</div>";
				}
        		$res_url = get_post_meta($the_id, 'resource_url', true);
        		$gain = get_post_meta($the_id, 'gain_partnership', true);
        		?>
        			<?php if(!$donor){ ?> <div class="projectinfo"><?php the_apply_project_button(); ?></div><?php } ?>
        		</div>
        		<?php echo the_post_thumbnail('full');?></div>
        		<div class="clear"></div>
        		<?php the_content(); ?>
        		
<?php if(!$donor){ ?> 
        		<div class="social-buttons">
            <ul class="socs">
              <a href="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="Tweet this!" target="_blank"><li>Tweet <span class="icon" id="social-buttons">t</span></li></a>
              <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="Share on Facebook." target="_blank"><li>Share <span class="icon" id="social-buttons">l</span></li></a>
            </ul>
            </div>
<?php } ?>
      		<?php endwhile; // end of the loop. ?>
		
				</div>

			     <div class="g3">
			      <?php if(!$donor){ the_apply_project_button(); } else { the_donate_button($gain); } ?>
			     </div>
							
				<div class="cf"></div>
				
<?php if(!$donor){ ?> 
				<div class="g3">
				<p><?php previous_post_link(); ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php next_post_link(); ?></p>
				</div>
				
		   <div class="cf"></div>
<?php } ?>

<?php include("footer.php"); ?>
