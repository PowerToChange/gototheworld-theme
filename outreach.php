<?php
/*
Template Name: Outreach
*/
?>

<?php include("header.php"); ?>

<div class="wrapper">
  
  <div class="g3">
      <h2 class="vision"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=148, 'outreach_title', true); ?> <span class="icon">9</span></h2>
        <p class="headline"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=90, 'outreach-tease', true); ?></p>
      </div>

      <div class="cf"></div>
      
      <h2 id="post-<?php the_ID(); ?>">
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
      <?php the_title(); ?></a></h2>

      <?php query_posts('post_type=outreach&posts_per_page=-1');
                     if (have_posts()) : while (have_posts()) : the_post(); $count++; ?>
                     <div class="g1">
                     <a href="<?php the_permalink() ?>">
                     <?php echo the_post_thumbnail('full');?>
                     <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
                     <?php the_title(); ?></h3>
                     <h4><?php echo get_post_meta($post->ID, 'location-specifics', true);?></h4></a>        
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
      <a href="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'eventbrite_url', true); ?>" target="_blank">
         <div class="reg-button">
           <?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=120, 'register_now_text', true); ?>&nbsp;<span class="icon">-</span>
         </div></a>
     </div>
    
  </div>
  <!-- end of wrapper -->

<?php include("footer.php"); ?>
