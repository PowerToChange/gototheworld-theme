<?php
/*
Template Name: Resources + Promotion
*/
?>


<?php include("header.php"); ?>

  <div class="g3">
      <h2 class="vision"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'resources_promotion_title', true); ?> <span class="icon">?</span></h2>
  </div>

  <div class="g-half">
    <h3><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'video_title', true); ?></h3>
      <div id="homevideo">
        <div class="vendor">
          <?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'video', true); ?>
          </div>
        </div>
      <h4><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'video_subheader', true); ?></h4>
      <p style="margin-bottom: 0.75em;"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'video_description', true); ?></p>
      <div class="social-buttons">
      <ul class="socs">
         <a href="http://twitter.com/home/?status=<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'video_title', true); ?> - <?php the_permalink(); ?>" title="Tweet this!" target="_blank"><li>Tweet <span class="icon" id="social-buttons">t</span></li></a>
         <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" title="Share on Facebook." target="_blank"><li>Share <span class="icon" id="social-buttons">l</span></li></a>         
      </ul>
      </div>
    </div>
  
    <div class="g-half2">
      <h3><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'kit_title', true); ?></h3>
        <img src="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'kit_thumbnail', true); ?>" / style="margin: 0 0 0.5em 0; -moz-box-shadow: 0px 3px 7px #999; -webkit-box-shadow: 0px 3px 7px #999;">
        <h4><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'kit_subheader', true); ?></h4>
        <p style="margin-bottom: 0.75em;"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'kit_description', true); ?></p>
        <div class="social-buttons">
        <ul class="socs">
           <a href="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=130, 'kit_pdf_link', true); ?>" target="_blank"><li>Download it! <span class="icon" id="social-buttons">D</span></li></a>        
        </ul>
        </div>
      </div>
    </div>
          
<?php include("footer.php"); ?>
