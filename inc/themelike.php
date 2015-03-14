<?php

function thb_likeThis($post_id,$action = 'get') {
		if(!is_numeric($post_id)) {
			error_log("Error: Value submitted for post_id was not numeric");
			return;
		}
	
		switch($action) {
		
		case 'get':
			if(get_post_meta($post_id, '_likes')) {
				$data = get_post_meta($post_id, '_likes');
			} else {
				$data = array();
					$data[0] = '0';
					add_post_meta($post_id, '_likes', '0', true);
			}	
				return $data[0];
		break;
		
		
		case 'update':
			if(isset($_COOKIE["like_" + $post_id])) {
				return;
			} //if
			
			$currentValue = get_post_meta($post_id, '_likes');
			
			if(!is_numeric($currentValue[0])) {
				$currentValue[0] = 0;
				add_post_meta($post_id, '_likes', '1', true);
			} //if
			
			$currentValue[0]++;
			update_post_meta($post_id, '_likes', $currentValue[0]);
			
			setcookie("like_" + $post_id, $post_id,time()*20, '/');
		break;
	
		} //switch
} //thb_likeThis

function thb_printLikes($post_id) {
	if (ot_get_option('like_system') == 'on') {
		$likes = thb_likeThis($post_id);
		
		if(isset($_COOKIE["like_" + $post_id])) {
	
		return '<a href="#" class="likeThis active" data-id="'.$post_id.'">
						<i class="icon-budicon-476"></i> <span class="count">'.$likes.'</span>
					</a>';
			return;
		} //if
	
		return '<a href="#" class="likeThis" data-id="'.$post_id.'">
						<i class="icon-budicon-476"></i> <span class="count">'.$likes.'</span>
					</a>';
	}
} //thb_printLikes


function setUpPostLikes($post_id) {
	if(!is_numeric($post_id)) {
		return;
	} //if
	
	add_post_meta($post_id, '_likes', '0', true);

} //setUpPost


function checkHeaders() {
	if(isset($_POST["likepost"])) {
		thb_likeThis($_POST["likepost"],'update');
	} //if

} //checkHeaders


add_action ('publish_post', 'setUpPostLikes');
add_action ('init', 'checkHeaders');
?>