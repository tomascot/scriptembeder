<?php
/*
Plugin Name: Script Embeder
Plugin URI: 
Description: 
Author: Tomas Cot
Version: 0.3
Author URI: http://cibergeek.com
*/



// ACTIONS GO HERE
add_action('add_meta_boxes', 'script_embeder_meta_box');
add_action('save_post', 'script_embeder_save_data');
add_action('admin_enqueue_scripts', 'script_embeder_post_js_script');
//add_action('admin_print_scripts', 'script_embeder_post_js_script');
add_action('wp_head', 'script_embeder_head');
add_action('wp_footer', 'script_embeder_footer');

function script_embeder_meta_box(){
	add_meta_box('script_embeder_div', 'Script Embeder', 'script_embeder_box_generator', 'post', 'normal', 'high');
}

function script_embeder_box_generator($post){
	$content = '';
	if(get_post_meta($post->ID, 'script_embeder')){
		$script_embeder_values = get_post_meta($post->ID, 'script_embeder')[0];
		$keys = array_keys($script_embeder_values);
		sort($keys);
		$last_key = $keys[sizeOf($keys)-1];
		//$script_embeder_values_length = sizeOf($script_embeder_values);
		$content ='<script type="text/javascript">var script_embeder_add_count=' . ($last_key). ';</script>
		<div><input type="button" name="script_embeder_ok" onClick="script_embeder_add_script()" value="Add"></div>';
		//for ($i = 0; $i < $script_embeder_values_length; $i++){
		foreach($script_embeder_values as $i=>$elem){
			
			$content .= '<div id="script_embeder_' . $i . '" ><select name="script_embeder[' . $i . '][type]">
			<option value="script" ' . (($script_embeder_values[$i]["type"] == "script") ? 'selected' : 'none') . '>Script</option>
			<option value="src" ' . (($script_embeder_values[$i]["type"] == "src") ? 'selected' : 'none') . '>SRC</option>
			</select>
			<select name="script_embeder[' . $i . '][position]">
			<option value="head" ' . (($script_embeder_values[$i]["position"] == "head") ? 'selected' : 'none') . '>HEAD</option>
			<option value="footer" ' . (($script_embeder_values[$i]["position"] == "footer") ? 'selected' : 'none') . '>FOOTER</option>
			</select>
			<label>Order</label><input type="number" name="script_embeder[' . $i . '][order]" value="' . $script_embeder_values[$i]["order"] . '">
			<label>Content</label><textarea name="script_embeder[' . $i . '][js]" value="">' . $script_embeder_values[$i]["js"] . '</textarea>
			<input type="button" name="script_embeder_ok" onClick="script_embeder_delete_script(' . $i . ')" value="Remove">
			</div>';
			
		}
	
	} else{
		$content .= '<script type="text/javascript">var script_embeder_add_count=0;</script>
		<div><input type="button" name="script_embeder_ok" onClick="script_embeder_add_script()" value="Add"></div>
		<div id="script_embeder_0"><select name="script_embeder[0][type]">
		<option value="script">Script</option>
		<option value="src">SRC</option>
		</select>
		<select name="script_embeder[0][position]">
		<option value="head">HEAD</option>
		<option value="footer">FOOTER</option>
		</select>
		<label>Order</label><input type="number" name="script_embeder[0][order]" value="">
		<label>Content</label><input type="text" name="script_embeder[0][js]" value="">
		<input type="button" name="script_embeder_ok" onClick="script_embeder_delete_script(0)" value="Remove">
		</div>';
	}
	
	echo $content;
}

function script_embeder_save_data($post_id){
	if (isset($_POST['script_embeder'])){
		
		/*$new_keys = array_keys($_POST['script_embeder']);
		$saved_keys = array_keys(get_post_meta($post_id, 'script_embeder')[0]);
		foreach($saved_keys as $key){
			if(!in_array($key, $saved_keys)){
				
			}
		}*/
		//var_dump((get_post_meta($post_id, 'script_embeder')[0]));
		//var_dump($_POST['script_embeder']);
		//die();
		update_post_meta($post_id, 'script_embeder', $_POST['script_embeder']);
		
		
	}
	
	

}

function script_embeder_post_js_script(){
	wp_enqueue_script('script_embeder_append_script', plugins_url('/script-embeder/js/script_embeder_post_js.js'), array('jquery'));
}

/**
* Sort function used to sort the scripts depending on the order assigned by the user.
*/
function script_embeder_sort_function($a, $b){
	if($a['order']<$b['order']){
		return -1;
	}else{
		return ($a['order']>$b['order'])? 1 : 0;
	}
}


function script_embeder_head(){
	if(is_single() && get_post_meta(get_queried_object_id(), 'script_embeder')){
		$pm = get_post_meta(get_queried_object_id(), 'script_embeder')[0];
		$res = usort($pm, 'script_embeder_sort_function');
		
		$scripts = '';
		for($i = 0; $i < sizeOf($pm); $i++){
			if($pm[$i]['position'] == 'head'){
				if($pm[$i]['type'] == 'src'){
						$scripts .= '<script src="' . $pm[$i]['js'] . '"></script>';
					} else{
						$scripts .= '<script type="text/javascript">' . $pm[$i]['js'] . '</script>';
					}
			}	
		}
		echo $scripts;
		
	}
}

function script_embeder_footer(){
	if(is_single() && get_post_meta(get_queried_object_id(), 'script_embeder')){
		$pm = get_post_meta(get_queried_object_id(), 'script_embeder')[0];
		$res = usort($pm, 'script_embeder_sort_function');
		
		$scripts = '';
		for($i = 0; $i < sizeOf($pm); $i++){
			if($pm[$i]['position'] == 'footer'){
				if($pm[$i]['type'] == 'src'){
					$scripts .= '<script src="' . $pm[$i]['js'] . '"></script>';
				} else{
					$scripts .= '<script type="text/javascript">' . $pm[$i]['js'] . '</script>';
				}
				
			}
			
		}
		echo $scripts;
		
	}
}


?>