<?php

// Add Scripts
function cansoft_add_scripts(){
	wp_enqueue_style('cansoft-main-style', plugins_url() . '/cansoft-woo-list/css/style.css');
	wp_enqueue_script('cansoft-main-script', plugins_url() . '/cansoft-woo-list/js/main.js');
}

add_action('wp_enqueue_scripts', 'cansoft_add_scripts');