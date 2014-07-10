function script_embeder_add_script(){
	script_embeder_add_count +=1; 
	script_embeder_content = '<div id="script_embeder_' + script_embeder_add_count + '"><select name="script_embeder[' + script_embeder_add_count + '][type]">' +
		'<option value="script">Script</option>' +
		'<option value="src">SRC</option>' +
		'</select>' +
		'<select name="script_embeder[' + script_embeder_add_count + '][position]">' +
		'<option value="head" >HEAD</option>' +
		'<option value="footer" >FOOTER</option>' +
		'</select>' +
		'<label>Order</label><input type="number" name="script_embeder[' + script_embeder_add_count + '][order]">' +
		'<label>Content</label><input type="text" name="script_embeder[' + script_embeder_add_count + '][js]">' +
		'<input type="button" name="script_embeder_ok" onClick="script_embeder_delete_script(' + script_embeder_add_count + ')" value="Remove">' +
		'</div>';
		
	jQuery('#script_embeder_div .inside').append(script_embeder_content);
	
}

function script_embeder_delete_script(id){
	jQuery("#script_embeder_" + id).remove();
	
}