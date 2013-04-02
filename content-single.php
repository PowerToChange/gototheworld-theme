<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage P2C Plus
 * @since P2C Plus 1.0
 */
?>
    
		<h3><?php the_title(); ?></h3>
		<h4><?php echo get_post_meta($post->ID, 'who_when_where', true);?></h4>
		<?php if ( 'post' == get_post_type() ) : ?>
		<?php endif; ?>

		<?php the_content(); ?>
		
		<div class="social-buttons">
    <ul class="socs">
       <a href="#"><li>Share <span class="icon" id="social-buttons">l</span></li></a>
       <a href="#"><li>Tweet <span class="icon" id="social-buttons">t</span></li></a>         
    </ul>
    </div>
