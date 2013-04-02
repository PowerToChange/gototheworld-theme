<?php global $donor; ?>
  </div><!-- End of the wrapper -->

  <footer>
<?php if(!$donor) { ?> 
    <div id="footer-container"><!-- Begin the Footer Container -->


      <div class="g1-footer">

        <ul class="footer">
        <h4 class="footer-header"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=124, 'useful_links', true); ?></h4>
        <a href="<?php bloginfo('url'); ?>/project-faq/"><li>Project FAQ<span class="icon" id="small">_</span></li></a>
        <a href="<?php bloginfo('url'); ?>/long-term-faq/"><li>Long Term FAQ<span class="icon" id="small">?</span></li></a>
        <a href="#top"><li>Take me to the top<span class="icon" id="small">&igrave;</span></li></a>
        </ul>
        
        <br/>
      </div>
      
      <div class="g1-footer">

        <!-- Twitter Feed -->
              <script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script>
              <script> new TWTR.Widget({ version: 2, type: 'profile', rpp: 3, interval: 30000, width: 'auto', height: 250, theme: { shell: { background:'transparent', color: '#ffffff' }, tweets: { background: '#2B80AE', color: '#ffffff', links: '#b8b8b8' } }, features: { scrollbar: false, loop: false, live: false, behavior: 'all', profile: false} }).render().setUser('<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=126, 'twitter_username', true); ?>').start();</script>
      
      </div>
      
      <div class="g1-footer">
        <p class="social">
          <a href="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=128, 'footer_facebook_link', true); ?>" target="_blank" style="color: #ECECEC;"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=128, 'footer_facebook_text', true); ?> <span class="icon" id="social">G</span></a>
           <a href="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=128, 'footer_twitter_link', true); ?>" target="_blank" style="color: #ECECEC;"><?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=128, 'footer_twitter_text', true); ?> <span class="icon" id="social">U</span></a>
        </p>
      </div>
      
    </div><!-- End of the Footer Container -->
          <div class="cf"></div>
<?php } ?>
<div id="footerlogo-container"><!-- Begin the Footer Logo Container -->

      <div class="g3">
        <p class="copyright"><a href="http://powertochange.com/students/" target="_blank"><img src="<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=144, 'footer_students_logo', true); ?>" /></a><br />&copy;&nbsp;&nbsp;<?php global $wp_query; $postid = $wp_query->post->ID; echo get_post_meta($post=144, 'footer_copyright', true); ?></p>
      </div>
      <div class="cf"></div>
    </div>

</footer><!-- End the Footer -->

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- HTML5 IE Enabling Script --> <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- CSS3 Media Queries -->
  <script src="<?php bloginfo('template_url'); ?>/js/respond.min.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/functions.js"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/fitvids.js"></script>
  <script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
  <script type="text/javascript">stLight.options({publisher: "38483da9-ea69-4c15-ba13-0369b13a7bed"}); </script>
  <script>
    $(document).ready(function(){
      // Target your .container, .wrapper, .post, etc.
      $("#homevideo").fitVids();
    });
  </script>

  	<!-- Optimized Google Analytics. Change UA-XXXXX-X to your site ID -->
  	<script>var _gaq=[['_setAccount','UA-2437988-26'],['_trackPageview']];(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.src='//www.google-analytics.com/ga.js';s.parentNode.insertBefore(g,s)}(document,'script'))</script>

  </body>
  </html>