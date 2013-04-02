<?php
global $donor;
$donor = false;
if($_GET['show'] == 'support') $donor = true;

?>
<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"><![endif]-->
<!--[if IE 7 ]> <html class="ie ie7 no-js" lang="en"> <![endif]--><!--[if IE 8 ]>
<html class="ie ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9 ]> <html class="ie ie9 no-js" lang="en"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->

<html id="top">

<head> 

<!--
***************************************************************** 
Fluid Baseline Grid v1.0.0 Designed & Built by Josh Hopkins and 40 Horse, http://40horse.com Licensed under Unlicense, http://unlicense.org/
*****************************************************************
-->

  <title>gototheworld.com</title>
  <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
  <?php facebook_preview_stuff(); ?>
  <meta charset="utf-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
  <meta name="description" content="The website for Power To Change Students Conference P2C Plus." />
  <meta name="author" content="Justin Alm">
  <meta name="keywords" content="conference, schedule, students, mobile first, power to change, P2C+, Christian, evangelism, Jesus Christ" />

  <!-- Optimized mobile viewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico and apple-touch-icon.png in root directory -->
  <link href="<?php bloginfo('template_url'); ?>/style.css" rel="stylesheet" />
  <script src="<?php bloginfo('template_url'); ?>/js/rewriteemails.js"></script>
  <!-- Minimized jQuery from Google CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<?php if($donor){ ?>
	<style>
		.not_for_support { display: none; }
	</style> 
<?php } ?>
</head>

<body>
  
    <header><!-- Begin the Header Container -->
       <div class="logo">    
         <a href="/home/"><img src="<?php bloginfo('template_url'); ?>/images/logo.png"></a>
       </div>
       <div class="logo-full">    
         <?php if(!$donor){ ?><a href="/home/"><?php } ?><img src="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=141, 'header_logo', true); ?>"><?php if(!$donor){ ?></a><?php } ?>
       </div>

       <div id="nav">
           <a class="drawer" href="#"><li><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=155, 'nav_menu', true); ?> <span class="icon" id="smallmenu">i</span></li></a>
<?php if(!$donor){ ?> 
         <ul class="info">
           <a href="<?php bloginfo('url'); ?>/home"><li>home <span class="icon" id="smallmenuhome">&iuml;</span></li></a>
           <a href="<?php bloginfo('url'); ?>/projects/"><li>projects <span class="icon" id="smallmenu">J</span></li></a>
           <a href="<?php bloginfo('url'); ?>/long-term/"><li>long term <span class="icon" id="smallmenu">3</span></li></a>
       		<a href="<?php bloginfo('url'); ?>/resources/"><li>resources <span class="icon" id="smallmenu">&oacute;</span></li></a>
         </ul>
<?php } ?>
      </header>
      
    </div><!-- End of Header Contianer -->

<div class="wrapper">
