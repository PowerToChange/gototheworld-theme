<?php
/*
Template Name: Speakers + Bands
*/
?>

<?php include("header.php"); ?>

  <div class="g3">
      <h2 class="vision"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=151, 'speakersbands_title', true); ?> <span class="icon">O</span></h2>
      <p class="headline"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=98, 'speakersbands-tease', true); ?></p>
  </div>

      <div class="g3-speakers">
          <?php query_posts('post_type=speakersbands&posts_per_page=-1');
              if (have_posts()) : while (have_posts()) : the_post();?>
              <div class="g-half">
              <?php the_post_thumbnail( 'full' ); ?>
              <div class="cf"></div>
              <h3><?php the_title();?></h3>
              <h4><?php echo get_post_meta($post->ID, 'church_and_location', true);?></h4>              
              <?php
                  global $more;
                  $more = 0;

                  the_content();                 
                  echo '</div>';
                  endwhile; endif;
                  // Reset Query
                  wp_reset_query();
              ?>
              </div>
          </div>
          
  <div class="cf"></div>      
  
  <div class="g3">
   <a href="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'eventbrite_url', true); ?>" target="_blank">
      <div class="reg-button">
        <?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'register_now_text', true); ?>&nbsp;<span class="icon">-</span>
      </div></a>
  </div>
    
<?php include("footer.php"); ?>