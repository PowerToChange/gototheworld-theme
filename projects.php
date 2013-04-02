<?php
/*
Template Name: Projects
*/
?>

<?php include("header.php"); ?>

<div class="wrapper projects">
		      <?php while ( have_posts() ) : the_post(); ?>

  <div class="g3">
      <h2 class="vision">projects <span class="icon">J</span></h2>
      <div class="headline"><?php the_content(); ?></div>
    </div>

      		<?php endwhile; // end of the loop. ?>

    
    <div class="cf"></div>
    
    <?php query_posts('post_type=projects&posts_per_page=-1&orderby=title&order=ASC');
                   if (have_posts()) : while (have_posts()) : the_post(); $count++; ?>
                   <div class="g1">
                   <a href="<?php the_permalink() ?>">
                   <?php echo the_post_thumbnail('full');?>
                   <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
                   <?php project_title(); ?></h3>
                   <h4><?php //echo get_post_meta($post->ID, 'location-specifics', true);
                   	?></h4></a>        
                   <?php
                       global $more;
                       $more = 0;
                       the_excerpt();               
                       echo '</div></a>';   
                       if ( 0 == $count%3 ) {
                             echo '<div class="cf"></div>';
                         }
                     endwhile; endif; //ending the loop
                     if ( 0 != $count%3 ) {
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