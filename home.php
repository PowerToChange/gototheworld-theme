<?php
/*
Template Name: Home
*/
?>

<?php include("header.php"); ?>

<div class="g3">
  <div id="homevideo">
    <div class="vendor">
            <?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=119, 'homepagevideo', true); ?>
      </div>
    </div>
</div>

<div class="g3">
 <?php the_apply_project_button(); ?> <a href="/projects/" target="_blank">
         <div class="reg-button">
           Projects&nbsp;<span class="icon">J</span>
         </div></a>
</div>

  <div class="g3">
    <h2 class="vision"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'vision_title_home', true); ?> <span class="icon">2</span></h2>
    <p class="headline"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=122, 'vision', true); ?></p>
  </div>
  
	<div class="g3 project_imgs">
	<?php 
	//list_projects_img(); 
	?>
	</div>

	<div class="g3">
		<?php summer_list(); ?><?php spring_break_list(); ?><image class="project_map" src="<?php echo get_bloginfo('template_url'); ?>/images/map.gif" />
	</div>
	


<?php include("footer.php"); ?>