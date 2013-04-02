<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header(); ?>

<div class="g3">
  <div id="homevideo">
    <div class="vendor">
            <?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=119, 'homepagevideo', true); ?>
      </div>
    </div>
</div>

<div class="g3">
 <a href="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'eventbrite_url', true); ?>" target="_blank">
    <div class="reg-button">
      <?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'register_now_text', true); ?>&nbsp;<span class="icon">-</span>
    </div></a>
</div>
  
  <div class="g3">
    <h2 class="vision"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'vision_title_home', true); ?> <span class="icon">M</span></h2>
    <p class="headline"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'vision', true); ?></p>
  </div>


  <div class="g3-speakers">
    
  <div class="g-half">
    <h2><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'speakers_bands_title_home', true); ?> <span class="icon">O</span></h2>
    <p class="second"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'speakers_bands_home', true); ?></p>
  </div>    

  <div class="g-half">
    <h2><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'workshops_title_home', true); ?> <span class="icon">@</span></h2>
    <p class="second"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'workshops_home', true); ?></p>
  </div>
  </div>
  
  <div class="cf"></div>

  <div class="g1">
    <h2><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'outreach_title_home', true); ?> <span class="icon">9</span></h2>
    <p><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'outreach_home', true); ?></p>
  </div>

  <div class="g1">
    <h2><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'travel_and_hotel_title_home', true); ?> <span class="icon">J</span></h2>
    <p><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'travel_and_hotel_home', true); ?></p>
  </div>

  <div class="g1">
    <h2><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'cost_title_home', true); ?> <span class="icon">C</span></h2>
    <p><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'cost_home', true); ?></p>
  </div>

  <div class="cf"></div>

  <div class="g3">
   <a href="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'eventbrite_url', true); ?>" target="_blank">
      <div class="reg-button">
        <?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'register_now_text', true); ?>&nbsp;<span class="icon">-</span>
      </div></a>
  </div>

<?php include("footer.php"); ?>