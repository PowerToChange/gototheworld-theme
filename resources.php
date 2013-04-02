<?php
/*
Template Name: Resources
*/
?>

<?php include("header.php"); ?>

<div class="wrapper">
		      <?php while ( have_posts() ) : the_post(); ?>

  <div class="g3">
      <h2 class="vision">Resources <span class="icon">&oacute;</span></h2>
      <div class="headline"><?php the_content(); ?></div>
    </div>

      		<?php endwhile; // end of the loop. ?>

    
    <div class="cf"></div>
    
    <?php query_posts('post_type=resources_post_type&posts_per_page=-1');
                   if (have_posts()) : while (have_posts()) : the_post(); $count++; ?>
                   <?php
                   		$res_url = get_post_meta(get_the_ID(), 'resource_url', true);
                   ?>
                   <div class="g-half resource">
                   <table><tr><td valign="top">
                   <a href="<?php echo $res_url; ?>">
                   <span class="icon">&oacute;</span></td><td>
                   <h3><a href="<?php echo $res_url; ?>" rel="bookmark" title="Download <?php the_title(); ?>">
                   <?php the_title(); ?></a></h3>        
                   <?php
                       the_content();               
                       echo '</td></tr></table></div>';   
                       if ( 0 == $count%2 ) {
                             echo '<div class="cf"></div>';
                         }
                     endwhile; endif; //ending the loop
                     if ( 0 != $count%2 ) {
                        echo '<div class="cf"></div>';
                     } 
                     wp_reset_query();
                     ?>

     <div class="g3">
      <?php the_apply_project_button(); ?>
     </div>
  
</div>
<!-- end of wrapper -->
<?php include("footer.php"); ?>