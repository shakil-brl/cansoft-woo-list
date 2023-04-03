<?php
/**
* Plugin Name: Cansoft woo list
* Description: Ads a Cansoft profile list to the end of posts
* Version: 1.0
* Author: Brad Traversy
* Text Domain: cansoft_domain
**/

// Exit if Accessed Directly
if(!defined('ABSPATH')){
	exit;
}


require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
  
function my_acf_notice() {
	?>
	<div class="notice notice-error">
		<p><?php _e( 'Please install and active WooCommerce, it is required for this plugin to work properly!', 'cansoft_domain' ); ?></p>
	</div>
	<?php
  }

  function errot_notificatio_show() {
	?>
	<div class="notice notice-error">
		<p><?php _e( 'Please install and active WooCommerce, it is required for this plugin to work properly!', 'cansoft_domain' ); ?></p>
	</div>
	<?php
  }

if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){ 
	 //success notofication  
	 
}else{
	add_action( 'admin_notices', 'errot_notificatio_show' );
}


// if (is_plugin_active('woocommerce/woocommerce.php')){
//      echo 'plugin is active';
//    }else{
//    
//    }


// Global Options Variable
$cansoft_options = get_option('cansoft_settings');

// Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/cansoft-woo-list-scripts.php');

// Load Content
require_once(plugin_dir_path(__FILE__).'/includes/cansoft-woo-list-content.php');

if(is_admin()){
	// Load Settings
	require_once(plugin_dir_path(__FILE__).'/includes/cansoft-woo-list-settings.php');
}






function add_category_from_list($cat_name)
{
	$cid = wp_insert_term($cat_name, 'product_cat', array());

	var_dump($cid);

	if (!is_wp_error($cid)) {
		$cat_id = isset($cid['term_id']) ? $cid['term_id'] : 0;

		exit($cat_id);

	} else {
		$cat_id = 0;
	}


}

$url = 'https://dummyjson.com/products';
$response = wp_remote_get($url);
if (is_array($response)) {
	$header = $response['headers']; // array of http header lines
	$body = json_decode($response['body']); // use the content
}

$data = [];
for ($i = 0; $i < count($body->products); $i++) {

	$args = array(
		'post_author' => 1,
		'post_content' => $body->products[$i]->description,
		'post_status' => "Publish",
		// (Draft | Pending | Publish)
		'post_title' => $body->products[$i]->title,
		'post_parent' => '',
		'post_type' => "product"
	);

	// Create a simple WooCommerce product
	$post_id = wp_insert_post($args);

	// Setting the product type
	wp_set_object_terms($post_id, 'simple', 'product_type');

	// Setting the product price
	update_post_meta($post_id, '_price', $body->products[$i]->price);
	update_post_meta($post_id, '_regular_price', $body->products[$i]->price - ($body->products[$i]->price * ($body->products[$i]->discountPercentage / 100)));
	update_post_meta($post_id, '_stock_status', 'instock');
	update_post_meta($post_id, '_stock', $body->products[$i]->stock);


	$gallary = [];

	for ($i = 0; $j < $body->products[$i]->images; $j++) {
		$image = media_sideload_image($body->products[$i]->images[$j], $post_id, '', 'id');
		array_push($gallary, $image);
	}
	$image = media_sideload_image($body->products[$i]->thumbnail, $post_id, '', 'id');

	set_post_thumbnail($post_id, $image);

}