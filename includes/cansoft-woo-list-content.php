<?php

function cansoft_add_woo($content){
	$woo_output = '<hr>';
	$woo_output .= '<div class="woo_content">';
	$woo_output .= '<span class="dashicons dashicons-Cansoft"></span> Find me On <a target="_blank" href="http://www.Cansoft.com">Cansoft</a>';
	$woo_output .= '</div>';


	return $content . $woo_output;
		

	return $content;

}

add_filter('the_content', 'cansoft_add_woo');