<?php include("header.php"); ?>

<div class="cf"></div>

<div class="g-half" style="margin: 0;">
  
    <div class="g3">
      <h2><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=148, 'outreach_title', true); ?> <span class="icon">9</span></h2>
    </div>
    
				  <?php while ( have_posts() ) : the_post(); ?>

  					<?php if ( 'post' == get_post_type() ) : ?>
        		<?php endif; ?>
        		<h3><?php the_title(); ?></h3>
        		<h4><?php echo get_post_meta($post->ID, 'location-specifics', true);?></h4>
        		<?php the_content(); ?>
        		<div class="social-buttons">
            <ul class="socs">
              <a href="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?>" title="Tweet this!" target="_blank"><li>Tweet <span class="icon" id="social-buttons">t</span></li></a>
              <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="Share on Facebook." target="_blank"><li>Share <span class="icon" id="social-buttons">l</span></li></a>
            </ul>
            </div>

  				<?php endwhile; // end of the loop. ?>
				
				</div>
				
				<div class="cf"></div>
				
				<div class="g3">
				<p><?php previous_post_link(); ?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php next_post_link(); ?></p>
				</div>
				
		   <div class="cf"></div>

<?php include("footer.php"); ?>
