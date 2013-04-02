<?php
/*
Template Name: Schedule
*/
?>

<?php include("header.php"); ?>

  <div class="g3">
      <h2 class="vision"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=150, 'schedule_title', true); ?> <span class="icon">P</span></h2>
  </div>

  <div class="cf"></div>
  
  <div class="g3">
    <div class="schedule-container">
      <?php query_posts('post_type=schedule&posts_per_page=-1');
          if (have_posts()) : while (have_posts()) : the_post();?>
          <?php  if( $post->ID == '150' ) continue; 
          // post ID 150 - Schedule — Title (DO NOT DELETE THIS POST!) will not show on the Schedule post loop ?>
          <div class="cf"></div>
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
    </div>
      
    <div class="cf"></div>

    <div class="g3">
     <a href="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'eventbrite_url', true); ?>" target="_blank">
        <div class="reg-button">
          <?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'register_now_text', true); ?>&nbsp;<span class="icon">-</span>
        </div></a>
    </div>

<?php include("footer.php"); ?>
