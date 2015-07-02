<?php
/*
Plugin Name: Content Menu
Plugin URI: http://wavelengthmedia.ca/
Description: This plugin allows adding a menu to the content area using a shortcode
Version: 1.0
Author: Ryan Lindsey
Author URI: http://wavelengthmedia.ca
*/

//tell wordpress to register the shortcode
add_shortcode("content-menu", "content_menu");

function content_menu($atts) {
	$output = '';
    $atts = shortcode_atts( array(
        'name' => '',
		'class' => '',
    ), $atts );

	if ($atts['name']) {
	if ($atts['class']) $output .= '<div class="agenda-menu '.$atts['class'].'">';
	$output .= wp_nav_menu( array( 'menu' => $atts['name'], 'container_class'=>$atts['class'],'menu_class' => 'content-menu' )); 
	if ($atts['class']) $output .= '</div>';
	return $output;
	}
	else return;
}


add_shortcode("category-list", "category_list");

function category_list($atts) {
	$output = '';
	$atts = shortcode_atts( array(
		'post-type' => 'post',
		'class' => 'category-list',
		'showposts' => '-1',
		'title' => 'Quick Navigation',
		'category' => '',
		'type' => 'list'
		), $atts );
		
	if (is_category( ) && $atts['category'] == '') {
	$cat = get_query_var('cat');
	$yourcat = get_category ($cat);
	}
	
	$loop = new WP_Query( array( 'post_type' => 'works', 'order'=>'ASC', 'orderby'=>'name','category_name' => $yourcat->slug, 'posts_per_page' => -1 ) );
	$output .= '<div class="cat-list list"><h2>'.$atts['title'].'</h2>';
	$dropdown .= '<div class="cat-list dropdown"><h2>'.$atts['title'].'</h2>';
	$dropdown .= '<select name="forma" onchange="location = this.options[this.selectedIndex].value;" "'.$class.'">';
	while ( $loop->have_posts() ) : $loop->the_post();
	
	$dropdown .= '<option value="#'.$loop->post->post_name.'">'.get_the_title().'</option>';
	
	$output .= '<li><h3 class="work-title"><a href="#'.$loop->post->post_name.'">'.get_the_title().'</a></h3></li>';

	endwhile; wp_reset_query();
	$output .= '</ul></div>';
	$dropdown .= '</select></div>';
	if ($atts['type'] == 'dropdown') { return $dropdown;}
	else if ($atts['type'] == 'list') { return $output; } else return;
}
 