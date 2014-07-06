<?php
/**
 * @package 
 * @version 1.6
 */
/*
Plugin Name: Script Embeder
Plugin URI: 
Description: 
Author: Tomas Cot
Version: 0.3
Author URI: http://cibergeek.com
*/

add_action('add_meta_boxes', 'script_embeder_meta_box');

function script_embeder_meta_box(){
	add_meta_box('script_embeder_id', 'Script Embeder', 'script_embeder', 'post', 'normal', 'high');
}

function script_embeder(){
	echo 'Prueba';
}










?>