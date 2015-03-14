<?php

/* Custom Language Switcher */

function thb_language_switcher () {

	if ( function_exists('icl_get_languages')) {
	global $data;
	?>
		<div class="select-wrapper">
		<select id="thb_language_selector">
			<?php
				$languages = icl_get_languages('skip_missing=0');
				if(1 < count($languages)){
					foreach($languages as $l){
						
						$selected = $l['active'] ? ' selected' : '';
						echo '<option value="'.$l['url'].'"'.$selected.'>'.$l['native_name'].'</option>';
					}
				} else {
					echo '<option value="">'.__('Add Languages', THB_THEME_NAME).'</option>';	
				}
			?>
			</select>
		</div>
	<?php 
	}
}
add_action( 'thb_language_switcher', 'thb_language_switcher',3 );

function thb_language_switcher_text () {

	if ( function_exists('icl_get_languages')) {
	global $data;
	?>
			<?php
				$languages = icl_get_languages('skip_missing=0');
				if(1 < count($languages)){
					$out = '';
					foreach($languages as $l){
						$selected = $l['active'] ? ' class="active"' : '';
						$out .= '<h6><a href="'.$l['url'].'"'.$selected.'>'.$l['native_name'].'</a></h6> / ';
					}
					echo substr($out, 0, -2);
				} else {
					_e('Add Languages', THB_THEME_NAME);	
				}
			?>
	<?php 
	}
}
add_action( 'thb_language_switcher_text', 'thb_language_switcher_text',3 );
?>