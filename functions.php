<?php
/**
 * Twenty Eleven functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyeleven_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

/**
 * Tell WordPress to run twentyeleven_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'twentyeleven_setup' );

if ( ! function_exists( 'twentyeleven_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyeleven_setup() in a child theme, add your own twentyeleven_setup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, custom headers
 * 	and backgrounds, and post formats.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_setup() {

	/* Make Twenty Eleven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Eleven, use a find and replace
	 * to change 'twentyeleven' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyeleven', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Load up our theme options page and related code.
	require( get_template_directory() . '/inc/theme-options.php' );

	// Grab Twenty Eleven's Ephemera widget.
	require( get_template_directory() . '/inc/widgets.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentyeleven' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	$theme_options = twentyeleven_get_theme_options();
	if ( 'dark' == $theme_options['color_scheme'] )
		$default_background_color = '1d1d1d';
	else
		$default_background_color = 'f1f1f1';

	// Add support for custom backgrounds.
	add_theme_support( 'custom-background', array(
		// Let WordPress know what our default background color is.
		// This is dependent on our current color scheme.
		'default-color' => $default_background_color,
	) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// Add support for custom headers.
	$custom_header_support = array(
		// The default header text color.
		'default-text-color' => '000',
		// The height and width of our custom header.
		'width' => apply_filters( 'twentyeleven_header_image_width', 1000 ),
		'height' => apply_filters( 'twentyeleven_header_image_height', 288 ),
		// Support flexible heights.
		'flex-height' => true,
		// Random image rotation by default.
		'random-default' => true,
		// Callback for styling the header.
		'wp-head-callback' => 'twentyeleven_header_style',
		// Callback for styling the header preview in the admin.
		'admin-head-callback' => 'twentyeleven_admin_header_style',
		// Callback used to display the header preview in the admin.
		'admin-preview-callback' => 'twentyeleven_admin_header_image',
	);
	
	add_theme_support( 'custom-header', $custom_header_support );

	if ( ! function_exists( 'get_custom_header' ) ) {
		// This is all for compatibility with versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR', $custom_header_support['default-text-color'] );
		define( 'HEADER_IMAGE', '' );
		define( 'HEADER_IMAGE_WIDTH', $custom_header_support['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $custom_header_support['height'] );
		add_custom_image_header( $custom_header_support['wp-head-callback'], $custom_header_support['admin-head-callback'], $custom_header_support['admin-preview-callback'] );
		add_custom_background();
	}

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be the size of the header image that we just defined
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( $custom_header_support['width'], $custom_header_support['height'], true );

	// Add Twenty Eleven's custom image sizes.
	// Used for large feature (header) images.
	add_image_size( 'large-feature', $custom_header_support['width'], $custom_header_support['height'], true );
	// Used for featured posts if a large-feature doesn't exist.
	add_image_size( 'small-feature', 500, 300 );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'wheel' => array(
			'url' => '%s/images/headers/wheel.jpg',
			'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Wheel', 'twentyeleven' )
		),
		'shore' => array(
			'url' => '%s/images/headers/shore.jpg',
			'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Shore', 'twentyeleven' )
		),
		'trolley' => array(
			'url' => '%s/images/headers/trolley.jpg',
			'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Trolley', 'twentyeleven' )
		),
		'pine-cone' => array(
			'url' => '%s/images/headers/pine-cone.jpg',
			'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Pine Cone', 'twentyeleven' )
		),
		'chessboard' => array(
			'url' => '%s/images/headers/chessboard.jpg',
			'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Chessboard', 'twentyeleven' )
		),
		'lanterns' => array(
			'url' => '%s/images/headers/lanterns.jpg',
			'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Lanterns', 'twentyeleven' )
		),
		'willow' => array(
			'url' => '%s/images/headers/willow.jpg',
			'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Willow', 'twentyeleven' )
		),
		'hanoi' => array(
			'url' => '%s/images/headers/hanoi.jpg',
			'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Hanoi Plant', 'twentyeleven' )
		)
	) );
}
endif; // twentyeleven_setup

if ( ! function_exists( 'twentyeleven_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( $text_color == HEADER_TEXTCOLOR )
		return;
		
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $text_color ) :
	?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo $text_color; ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // twentyeleven_header_style

if ( ! function_exists( 'twentyeleven_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in twentyeleven_setup().
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		font-family: "Helvetica Neue", Arial, Helvetica, "Nimbus Sans L", sans-serif;
	}
	#headimg h1 {
		margin: 0;
	}
	#headimg h1 a {
		font-size: 32px;
		line-height: 36px;
		text-decoration: none;
	}
	#desc {
		font-size: 14px;
		line-height: 23px;
		padding: 0 0 3em;
	}
	<?php
		// If the user has set a custom color for the text use that
		if ( get_header_textcolor() != HEADER_TEXTCOLOR ) :
	?>
		#site-title a,
		#site-description {
			color: #<?php echo get_header_textcolor(); ?>;
		}
	<?php endif; ?>
	#headimg img {
		max-width: 1000px;
		height: auto;
		width: 100%;
	}
	</style>
<?php
}
endif; // twentyeleven_admin_header_style

if ( ! function_exists( 'twentyeleven_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in twentyeleven_setup().
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_admin_header_image() { ?>
	<div id="headimg">
		<?php
		$color = get_header_textcolor();
		$image = get_header_image();
		if ( $color && $color != 'blank' )
			$style = ' style="color:#' . $color . '"';
		else
			$style = ' style="display:none"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( $image ) : ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // twentyeleven_admin_header_image

/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function twentyeleven_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function twentyeleven_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( '<br/>Check this out <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyeleven_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function twentyeleven_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyeleven_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyeleven_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function twentyeleven_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyeleven_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyeleven_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function twentyeleven_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyeleven_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' );

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentyeleven' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Showcase Sidebar', 'twentyeleven' ),
		'id' => 'sidebar-2',
		'description' => __( 'The sidebar for the optional Showcase Template', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'twentyeleven' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'twentyeleven' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'twentyeleven' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentyeleven_widgets_init' );

if ( ! function_exists( 'twentyeleven_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function twentyeleven_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // twentyeleven_content_nav

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 * @return string|bool URL or false when no link is present.
 */
function twentyeleven_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function twentyeleven_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'twentyeleven_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyeleven_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for twentyeleven_comment()

if ( ! function_exists( 'twentyeleven_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twentyeleven_posted_on to override in a child theme
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentyeleven' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'twentyeleven_body_classes' );


// The list of custom post types in the Admin Area of the theme
include_once("classes/BasicPostType.class.php");


class ProjectPostType extends BasicPostType
{
	function ProjectPostType()
	{
		parent::BasicPostType("Project", array('title', 'editor', 'excerpt','thumbnail'), array('cost', 'location', 'length', 'dates', 'deadline', 'spring_break', 'summer', 'gain_partnership'), '', 'projects');
	}
	
	function display_field($post, $field) 
	{
		$res = true;
		switch ($field) {
			case "cost": $this->Text($post, 'Cost', $field); break;
			case "location": $this->Text($post, 'Location', $field); break;
			case "length": $this->Text($post, 'Length', $field); break;
			case "dates": $this->Text($post, 'Dates', $field); break;
			case "deadline": $this->Text($post, 'Deadline', $field); break;
			case "spring_break": $this->CheckBox($post, 'Spring break', $field); break;
			case "summer": $this->CheckBox($post, 'Summer', $field); break;
			case "gain_partnership": $this->CheckBox($post, 'Gain partnership', $field); break;
			default:  $res = false; break;
		}
		return $res; 
	}
}

global $project_post_type; $project_post_type = new ProjectPostType(); 


// Creates Long Term post type
register_post_type('long-term', array(
'label' => 'Long Term',
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => false,
'rewrite' => array('slug' => 'long-term'),
'query_var' => true,
'menu_position' => 5,
'supports' => array(
'title',
'custom-fields',
'editor',
'excerpt',
'thumbnail',)
) );



class ResourcesPostType extends BasicPostType
{
	function ResourcesPostType()
	{
		parent::BasicPostType("Resource", array('title', 'editor'), array('resource_url'), '', 'resources');
	}
	
	function display_field($post, $field) 
	{
		$res = true;
		switch ($field) {
			case "resource_url": $this->Text($post, 'Resource url', $field); break;
			default:  $res = false; break;
		}
		return $res; 
	}
}

// Initiate the post type
add_action("init", "ResourcesPostTypeInit");
function ResourcesPostTypeInit() { global $resources_post_type; $resources_post_type = new ResourcesPostType(); }

// Creates Homepage Video post type
register_post_type('homepage', array(
'label' => 'Home Page',
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => false,
'rewrite' => array('slug' => 'homepage'),
'query_var' => true,
'menu_position' => 5,
'supports' => array(
'title',
'custom-fields',)
) );

// Creates Footer post type
register_post_type('footer', array(
'label' => 'Footer',
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => false,
'rewrite' => array('slug' => 'footer'),
'query_var' => true,
'menu_position' => 5,
'supports' => array(
'title',
'custom-fields',)
) );


// Creates Navigation post type
register_post_type('navigation', array(
'label' => 'Navigation',
'public' => true,
'show_ui' => true,
'capability_type' => 'post',
'hierarchical' => false,
'rewrite' => array('slug' => 'navigation'),
'query_var' => true,
'menu_position' => 5,
'supports' => array(
'title',
'custom-fields',)
) );

// Styling for the custom post type icon
add_action( 'admin_head', 'wpt_portfolio_icons' );
function wpt_portfolio_icons() {
    ?>
    <style type="text/css" media="screen">
        #menu-posts-speakersbands .wp-menu-image {
            background: url(/wp-content/themes/p2cplus/images/speakersbands-icon.png) no-repeat 6px 6px !important;
        }
    #menu-posts-speakersbands:hover .wp-menu-image, #menu-posts-speakersbands.wp-has-current-submenu .wp-menu-image {
            background:url(/wp-content/themes/p2cplus/images/speakersbands-hover-icon.png) no-repeat 6px 6px !important;
        }
    #icon-edit.icon32-posts-speakersbands {background: url(/wp-content/themes/p2cplus/images/speakersbands-32x32.png) no-repeat;}
 
        #menu-posts-schedule .wp-menu-image {
            background: url(/wp-content/themes/p2cplus/images/schedule-icon.png) no-repeat 6px 6px !important;
        }
    #menu-posts-schedule:hover .wp-menu-image, #menu-posts-schedule.wp-has-current-submenu .wp-menu-image {
            background:url(/wp-content/themes/p2cplus/images/schedule-hover-icon.png) no-repeat 6px 6px !important;
        }
    #icon-edit.icon32-posts-schedule {background: url(/wp-content/themes/p2cplus/images/schedule-32x32.png) no-repeat;}

    
        #menu-posts-workshops .wp-menu-image {
            background: url(/wp-content/themes/p2cplus/images/workshops-icon.png) no-repeat 6px 6px !important;
        }
    #menu-posts-workshops:hover .wp-menu-image, #menu-posts-workshops.wp-has-current-submenu .wp-menu-image {
            background:url(/wp-content/themes/p2cplus/images/workshops-hover-icon.png) no-repeat 6px 6px !important;
        }
    #icon-edit.icon32-posts-workshops {background: url(/wp-content/themes/p2cplus/images/workshops-32x32.png) no-repeat;}

    
        #menu-posts-outreach .wp-menu-image {
            background: url(/wp-content/themes/p2cplus/images/outreach-icon.png) no-repeat 6px 6px !important;
        }
    #menu-posts-outreach:hover .wp-menu-image, #menu-posts-outreach.wp-has-current-submenu .wp-menu-image {
            background:url(/wp-content/themes/p2cplus/images/outreach-hover-icon.png) no-repeat 6px 6px !important;
        }
    #icon-edit.icon32-posts-outreach {background: url(/wp-content/themes/p2cplus/images/outreach-32x32.png) no-repeat;}
    
        #menu-posts-opportunities .wp-menu-image {
            background: url(/wp-content/themes/p2cplus/images/opportunities-icon.png) no-repeat 6px 6px !important;
        }
    #menu-posts-opportunities:hover .wp-menu-image, #menu-posts-opportunities.wp-has-current-submenu .wp-menu-image {
            background:url(/wp-content/themes/p2cplus/images/opportunities-hover-icon.png) no-repeat 6px 6px !important;
        }
    #icon-edit.icon32-posts-opportunities {background: url(/wp-content/themes/p2cplus/images/opportunities-32x32.png) no-repeat;}
    
    #menu-posts-homepage .wp-menu-image {
        background: url(/wp-content/themes/p2cplus/images/video-icon.png) no-repeat 6px 6px !important;
    }
#menu-posts-homepage:hover .wp-menu-image, #menu-posts-homepage.wp-has-current-submenu .wp-menu-image {
        background:url(/wp-content/themes/p2cplus/images/video-hover-icon.png) no-repeat 6px 6px !important;
    }
#icon-edit.icon32-posts-homepage {background: url(/wp-content/themes/p2cplus/images/video-32x32.png) no-repeat;}

    #menu-posts-footer .wp-menu-image {
        background: url(/wp-content/themes/p2cplus/images/footer-icon.png) no-repeat 6px 6px !important;
    }
#menu-posts-footer:hover .wp-menu-image, #menu-posts-footer.wp-has-current-submenu .wp-menu-image {
        background:url(/wp-content/themes/p2cplus/images/footer-hover-icon.png) no-repeat 6px 6px !important;
    }
#icon-edit.icon32-posts-footer {background: url(/wp-content/themes/p2cplus/images/footer-32x32.png) no-repeat;}

    #menu-posts-randp .wp-menu-image {
        background: url(/wp-content/themes/p2cplus/images/randp-icon.png) no-repeat 6px 6px !important;
    }
#menu-posts-randp:hover .wp-menu-image, #menu-posts-randp.wp-has-current-submenu .wp-menu-image {
        background:url(/wp-content/themes/p2cplus/images/randp-hover-icon.png) no-repeat 6px 6px !important;
    }
#icon-edit.icon32-posts-randp {background: url(/wp-content/themes/p2cplus/images/randp-32x32.png) no-repeat;}

    #menu-posts-faq .wp-menu-image {
        background: url(/wp-content/themes/p2cplus/images/faq-icon.png) no-repeat 6px 6px !important;
    }
#menu-posts-faq:hover .wp-menu-image, #menu-posts-faq.wp-has-current-submenu .wp-menu-image {
        background:url(/wp-content/themes/p2cplus/images/faq-hover-icon.png) no-repeat 6px 6px !important;
    }
#icon-edit.icon32-posts-faq {background: url(/wp-content/themes/p2cplus/images/faq-32x32.png) no-repeat;}

    #menu-posts-navigation .wp-menu-image {
        background: url(/wp-content/themes/p2cplus/images/navigation-icon.png) no-repeat 6px 6px !important;
    }
#menu-posts-navigation:hover .wp-menu-image, #menu-posts-navigation.wp-has-current-submenu .wp-menu-image {
        background:url(/wp-content/themes/p2cplus/images/navigation-hover-icon.png) no-repeat 6px 6px !important;
    }
#icon-edit.icon32-posts-navigation {background: url(/wp-content/themes/p2cplus/images/navigation-32x32.png) no-repeat;}

    
    // These are the teaser icons for the WP Admin Nav

        #menu-posts-speakersbands-tease .wp-menu-image {
            background: url(/wp-content/themes/p2cplus/images/speakersbands-icon.png) no-repeat 6px 6px !important;
        }
    #menu-posts-speakersbands-tease:hover .wp-menu-image, #menu-posts-speakersbands-tease.wp-has-current-submenu .wp-menu-image {
            background:url(/wp-content/themes/p2cplus/images/speakersbands-hover-icon.png) no-repeat 6px 6px !important;
        }
    #icon-edit.icon32-posts-speakersbands-tease {background: url(/wp-content/themes/p2cplus/images/speakersbands-32x32.png) no-repeat;}

            #menu-posts-workshop-tease .wp-menu-image {
                background: url(/wp-content/themes/p2cplus/images/workshops-icon.png) no-repeat 6px 6px !important;
            }
        #menu-posts-workshop-tease:hover .wp-menu-image, #menu-posts-workshop-tease.wp-has-current-submenu .wp-menu-image {
                background:url(/wp-content/themes/p2cplus/images/workshops-hover-icon.png) no-repeat 6px 6px !important;
            }
        #icon-edit.icon32-posts-workshop-tease {background: url(/wp-content/themes/p2cplus/images/workshops-32x32.png) no-repeat;}
        
            #menu-posts-outreach-tease .wp-menu-image {
                background: url(/wp-content/themes/p2cplus/images/outreach-icon.png) no-repeat 6px 6px !important;
            }
        #menu-posts-outreach-tease:hover .wp-menu-image, #menu-posts-outreach-tease.wp-has-current-submenu .wp-menu-image {
                background:url(/wp-content/themes/p2cplus/images/outreach-hover-icon.png) no-repeat 6px 6px !important;
            }
        #icon-edit.icon32-posts-outreach-tease {background: url(/wp-content/themes/p2cplus/images/outreach-32x32.png) no-repeat;}
        
            #menu-posts-opportunities-tease .wp-menu-image {
                background: url(/wp-content/themes/p2cplus/images/opportunities-icon.png) no-repeat 6px 6px !important;
            }
        #menu-posts-opportunities-tease:hover .wp-menu-image, #menu-posts-opportunities-tease.wp-has-current-submenu .wp-menu-image {
                background:url(/wp-content/themes/p2cplus/images/opportunities-hover-icon.png) no-repeat 6px 6px !important;
            }
        #icon-edit.icon32-posts-opportunities-tease {background: url(/wp-content/themes/p2cplus/images/opportunities-32x32.png) no-repeat;}
    
    </style>
    
<?php }

// Increase Excerpt field height

add_action('admin_head', 'excerpt_textarea_height');
function excerpt_textarea_height() {
        echo'
        <style type="text/css">
                #excerpt{ height:100px; }
        </style>
        ';
}

add_action('admin_head','custom_field_css');
function custom_field_css() {
	echo '
	<style type="text/css">
		textarea#metavalue {
			height:100px!important
		}
	</style>
	';
}
function my_custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/custom-login-logo.gif) !important; background-size: 310px !important;}
    </style>';
}

function the_apply_project_button(){
	echo '<a href="http://join.powertochange.org" target="_blank">
         <div class="reg-button">
           Apply!&nbsp;<span class="icon">-</span>
         </div></a>';
}

function the_donate_button($gain = false){
	$url = 'https://secure.powertochange.org/p-505-mission-trips-tours.aspx';
	if($gain) $url = 'http://globalaid.net/give';
	echo '<iframe src="http://player.vimeo.com/video/46493942?byline=0&amp;portrait=0&amp;badge=0&amp;color=ffffff" width="375" height="210" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		<br /><a href="' . $url . '" target="_blank">
         <div class="reg-button">
           Donate&nbsp;<span class="icon">8</span>
         </div></a>';
}

function project_img_path() 
{
	global $project_img_path; 
	if(!$project_img_path) 
		$project_img_path = get_theme_root() . '/p2cplus/images/projects';
	return $project_img_path;
}

function project_img_url()
{
	global $project_img_url; 
	if(!$project_img_url) 
		$project_img_url = get_bloginfo('template_url') . '/images/projects';
	return $project_img_url;
}

function list_and_sort_projects()
{
	global $projects_a, $summer_projects_a, $spring_break_projects_a, $post;
	if(!$projects_a)
	{
		$projects_a = array();
		$summer_projects_a = array();
		$spring_break_projects_a = array();
		query_posts('post_type=projects&posts_per_page=-1&orderby=title&order=ASC');
	   if (have_posts())
	   {
		   while (have_posts()) : the_post(); $count++;
		   $id = get_the_ID();
		   $title = get_the_title();
		   $link = get_permalink();
		   $slug = $post->post_name;
		   $is_summer = get_post_meta($id, 'summer', true);
		   $is_spring_break = get_post_meta($id, 'spring_break', true);
		   array_push($projects_a, array('title' => $title, 'slug' => $slug, 'link' => $link));
		   if($is_summer) array_push($summer_projects_a, array('title' => $title, 'slug' => $slug, 'link' => $link));
		   if($is_spring_break) array_push($spring_break_projects_a, array('title' => $title, 'slug' => $slug, 'link' => $link));
		   endwhile; 
	   }
	     wp_reset_query();
     }
}

function write_project_list($a)
{
	foreach($a as $project)
	{
		$title = $project['title'];
		$link = $project['link'];
		echo "<br/><a href=\"$link\">$title</a>";
	}
}

function spring_break_list()
{
	global $spring_break_projects_a;
	list_and_sort_projects();
	
	if(count($spring_break_projects_a))
	{
		$spimg = project_img_url() . "/spring-break.png";
		echo "<div id=\"spring_break_projects\"><img src=\"$spimg\">";
		write_project_list($spring_break_projects_a);
		echo "</div>";
	}
	
}

function summer_list()
{
	global $summer_projects_a;
	list_and_sort_projects();
	
	if(count($summer_projects_a))
	{
		$spimg = project_img_url() . "/summer.png";
		echo "<div id=\"summer_projects\"><img src=\"$spimg\">";
		write_project_list($summer_projects_a);
		echo "</div>";
	}
	
}

function list_projects_img()
{
	if ($handle = opendir(project_img_path())) 
	{	
	    /* This is the correct way to loop over the directory. */
	    while (false !== ($entry = readdir($handle))) {
			if(preg_match('/.png/i', $entry))
			{
				$pname = str_replace('.png', '', strtolower($entry));
				if(project_exists($pname))
				{
					$img_url = project_img_url() . '/' . $entry;
					$page_url = 'projects/' . $pname;
					echo "<a class=\"project_link\" href=\"$page_url\"><img class=\"project_title_img\" src=\"$img_url\" /></a>";
				}
			}
	    }
	
	    closedir($handle);
	}
}

function project_exists($slug)
{
	global $projects_array, $urloflastprojecttested;
	$urloflastprojecttested = "projects/$slug";
	if(!$projects_array)
	{
		$projects_array = array();
		// todo: change get_posts for a sql request pulling only post_name
		$pages = get_posts(array( 'post_type' => 'projects', 'posts_per_page' => '-1' ));
		foreach ($pages as $page) $projects_array[$page->post_name] = true; 
	}
	return array_key_exists($slug, $projects_array);
}

function project_title()
{
	$title = get_the_title();

	$img_name = str_replace(' ', '-', strtolower($title)) . '.png';

	$img_path = project_img_path() . '/' . $img_name;
	$img_url = project_img_url() . '/' . $img_name;

	if(file_exists($img_path)) $title = "<img class=\"project_title_img\" src=\"$img_url\" />";
	echo $title;
}

function find_images()
{
	$imgs = array();
	//option 1: preview image
	if ( has_post_thumbnail()) {
		$at_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
		$imgs[] = $at_img[0];
	}	
	//option 2: first image in content
	$content = get_the_content();
	if (preg_match_all("#<img[^>]*src *= *[\"']([^\"']+)[\"']#isU", $content, $regs, PREG_PATTERN_ORDER))
	{
		foreach ($regs[1] as $img_url) {
			$imgs[] = $img_url;
		}
	}
	//option 3: default image
	$imgs[] = get_bloginfo('template_url') . '/images/gttw_logo.jpg';
	
	return $imgs;
}

function facebook_preview_stuff()
{
	
	while ( have_posts() ) : the_post();
		$title = get_the_title();
		$url = get_permalink();
		$img_urls = find_images();
		$img_url = $img_urls[0];
		$the_excerpt = strip_tags(get_the_excerpt());
	endwhile;
	wp_reset_query();
	if($img_urls) foreach ($img_urls as $a_img_url) echo "<link rel=\"image_src\" href=\"$a_img_url\" />";
	
	echo "<meta property=\"fb:admins\" content=\"\"/>		
	<meta property=\"og:title\" content=\"$title\"/>
	<meta property=\"og:type\" content=\"article\"/>
	<meta property=\"og:url\" content=\"$url\"/>
	<meta property=\"og:image\" content=\"$img_url\"/>
	<meta property=\"og:site_name\" content=\"gototheworld.com\"/>
	<meta property=\"og:description\" content=\"$the_excerpt\"/>";
	
}

/* 
	Rewrite .com emails to not get spammed. 
*/ 

add_filter('the_content', 'please_rewrite_emails'); 

function please_rewrite_emails($content) 
{ 


  while(preg_match('/([a-zA-Z\.0-9\-_]+)@([a-zA-Z0-9\-]+).com/', $content, $m))
  {
    $content = str_replace($m[0], "<script>courrielCOM('$m[2]', '$m[1]');</script>", $content); 
  }

  while(preg_match('/([a-zA-Z\.0-9\-_]+)@([a-zA-Z0-9\-]+).org/', $content, $m))
  {
    $content = str_replace($m[0], "<script>courrielORG('$m[2]', '$m[1]');</script>", $content); 
  }

  while(preg_match('/([a-zA-Z\.0-9\-_]+)@([a-zA-Z0-9\-]+).net/', $content, $m))
  {
    $content = str_replace($m[0], "<script>courrielNET('$m[2]', '$m[1]');</script>", $content); 
  }

	return $content;
}

add_action('login_head', 'my_custom_login_logo');
?>