<?php
/*
 Basic Post Type
 Description: Pour faire des post types
 Author: Jacques Robitaille
 Version: 1.0
 Author URI: http://www.jacquesrobitaille.com/
 */

// die if called directly
if ( !function_exists( 'add_action' ) ) {
	exit;
}
 

class BasicPostType {
	var $post_type_name;
	var $name;
	var $slug;
	var $name_plur;
	var $meta_fields;
	
	
	function BasicPostType($singulier, $supports = array('title', 'editor', 'thumbnail'), $special_fields = array(), $pluriel = "", $slug = "")
	{
		$this->slug = str_replace(' ', '-', strtolower($singulier));
		if($slug != "") $this->slug = $slug;
		if($slug != 'projects') $this->post_type_name = $this->slug . "_post_type";
		else $this->post_type_name = $this->slug;
		$this->name = $singulier;
		$this->name_plur = $singulier . "s";
		if($pluriel != "") $this->name_plur = $pluriel;
		$this->meta_fields = $special_fields; 
		
		// Register custom post types
		register_post_type($this->post_type_name, array(
			'label' => __($this->name_plur),
			'singular_label' => __($this->name),
			'labels' => array(			
								'name' => $this->name_plur,
								'add_new_item' => 'Add New ' . $this->name,
								'edit_item' => 'Edit ' . $this->name,
								'new_item' => 'New ' . $this->name,
								'view_item' => 'View ' . $this->name,
								'not_found' => 'No ' . $this->name . ' found'
							),
			'public' => true,
			'show_ui' => true, // UI in admin panel
			'_builtin' => false, // It's a custom post type, not built in
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'rewrite' => array("slug" => $this->slug, 'with_front' => false), // Permalinks
			'query_var' => $this->post_type_name, // This goes to the WP_Query schema
			'supports' => $supports
		));
				

		// Admin interface init
		add_action("admin_init", array(&$this, "admin_init"));
		
		// Insert post hook
		add_action("wp_insert_post", array(&$this, "wp_insert_post"), 10, 2);
	}
	
	
	function save_meta($post_id, $key, $value)
	{
		// If value is a string it should be unique
		if (!is_array($value)) { if (!update_post_meta($post_id, $key, $value))	{ add_post_meta($post_id, $key, $value); }}
		else {
			delete_post_meta($post_id, $key); 
			foreach ($value as $entry) add_post_meta($post_id, $key, $entry);
		}
	}

	function display_field($post, $field) { return false; }
	function special_save($post_id, $field, $value)	{ return false; }
	
	// When a post is inserted or updated
	function wp_insert_post($post_id, $post = null)
	{
		if ($post->post_type == $this->post_type_name)
		{
			// Loop through the POST data
			foreach ($this->meta_fields as $key)
			{
				$value = @$_POST[$key];
				if(!$this->special_save($post_id, $key, $value))
				{
				 // Regular treatement for saving a value
					if (empty($value))
					{
						delete_post_meta($post_id, $key);
						continue;
					}
	
					$this->save_meta($post_id, $key, $value);
				}	
			}
		}
	}
	
	function admin_init() {	add_meta_box('cpt-meta', 'Display', array(&$this, 'admin_box'), $this->post_type_name, 'normal' );}
	
	function admin_box() {
		global $post;
		?><table><?php
			foreach ($this->meta_fields as $key)
			{
				if(!$this->display_field($post, $key))
				{
					$this->Text($post, $key, $key);
				}
			}
		?></table><?php		
	}
	
	function Text($the_post, $label, $field_name)
	  {
	  	?>
	<tr>
		<td><label for="<?php echo $field_name?>"><?php echo $label?></label></td>
		<td><input type="text" id= "<?php echo $field_name?>" name="<?php echo $field_name?>" value="<?php echo get_post_meta($the_post->ID, $field_name, true); ?>" size="75" /></td>	
	</tr>  	
		<?php
	  }
	  
	function CheckBox($the_post, $label, $field_name)
	{
		$check_value = get_post_meta($the_post->ID, $field_name, true);
		$checked = '';
		if($check_value) $checked = ' checked'
		
		?>
		<tr>
		<td><label for="<?php echo $field_name?>"><?php echo $label?></label>
		
		</td>
		<td><input type="checkbox" id= "<?php echo $field_name?>" name="<?php echo $field_name?>"<?php echo $checked; ?> />
		</td>
		
		</tr>  	
		<?php
		
	}
	  
}

 
 ?>