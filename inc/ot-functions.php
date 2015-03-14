<?php
function thb_bgecho($array) {
	if(!empty($array)) {
		if (!empty($array['background-color'])) { 
			echo "background-color: " . $array['background-color'] . " !important;\n";
		}
		if (!empty($array['background-image'])) { 
			echo "background-image: url(" . $array['background-image'] . ") !important;\n";
		}
		if (!empty($array['background-repeat'])) { 
			echo "background-repeat: " . $array['background-repeat'] . " !important;\n";
		}
		if (!empty($array['background-attachment'])) { 
			echo "background-attachment: " . $array['background-attachment'] . " !important;\n";
		}
		if (!empty($array['background-position'])) { 
			echo "background-position: " . $array['background-position'] . " !important;\n";
		}
		if (!empty($array['background-size'])) { 
			echo "background-size: " . $array['background-size'] . " !important;\n";
		}
	}
}

function thb_paddingecho($array) {
	if(!empty($array)) {
		if (!empty($array['top'])) { 
			echo "padding-top: " . $array['top'] . $array['unit'].";\n";
		}
		if (!empty($array['right'])) { 
			echo "padding-right: " . $array['right'] . $array['unit'].";\n";
		}
		if (!empty($array['bottom'])) { 
			echo "padding-bottom: " . $array['bottom'] . $array['unit'].";\n";
		}
		if (!empty($array['left'])) { 
			echo "padding-left: " . $array['left'] . $array['unit'].";\n";
		}
	}
}

function thb_linkcolorecho($array, $start) {
	if(!empty($array)) {
		if (!empty($array['link'])) { 
			echo $start." a:link { color: " . $array['link'] ."; }\n";
		}
		if (!empty($array['hover'])) { 
			echo $start." a:hover { color: " . $array['hover'] ."; }\n";
		}
		if (!empty($array['active'])) { 
			echo $start." a:active { color: " . $array['active'] ."; }\n";
		}
		if (!empty($array['visited'])) { 
			echo $start." a:visited { color: " . $array['visited'] ."; }\n";
		}
		if (!empty($array['link'])) { 
			echo $start." a:focus { color: " . $array['focus'] ."; }\n";
		}
	}
}

$thb_fontlist = array();

function thb_google_webfont() {
		global $thb_fontlist;
		$options = array( 
			array( 
					'option' => "body_type", 
					'default' => "Source Code Pro"
			),
			array( 
					'option' => "title_type", 
					'default' => "Montserrat"
			)
		);
		$import = '';	
		
		$subsets = 'latin,latin-ext';
		$subset = ot_get_option('font_subsets');

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';

		foreach($options as $option) {
			$array = ot_get_option($option['option']);
			
			if (!empty($array['font-family'])) { 
				if (!in_array($array['font-family'], $thb_fontlist)) {
					array_push($thb_fontlist, $array['font-family']);
				}
			} else if ($option['default']) {
				if (!in_array($option['default'], $thb_fontlist)) {
					array_push($thb_fontlist, $option['default']);
				}
			}
		}
		$font_list = array_unique($thb_fontlist);
		
		foreach($font_list as $font) {
			$cssfont = str_replace(' ', '+', $font);
			$query_args = array(
				'family' => $cssfont.':200,300,400,500,600,700',
				'subset' => $subsets,
			);
			$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
			$import .= "@import url(".$font_url.");\n";
		}
		return $import;
}

function thb_typeecho($array, $important = false, $default = false) {
	global $thb_fontlist;
	
	if(!empty($array)) {
		
		if (!empty($array['font-family'])) { 
			echo "font-family: '" . $array['font-family'] . "';\n";
		} else if ($default) {
			echo "font-family: '" . $default . "';\n";
		}
		if (!empty($array['font-color'])) { 
			echo "color: " . $array['font-color'] . ";\n";
		}
		if (!empty($array['font-style'])) { 
			echo "font-style: " . $array['font-style'] . ";\n";
		}
		if (!empty($array['font-variant'])) { 
			echo "font-variant: " . $array['font-variant'] . ";\n";
		}
		if (!empty($array['font-weight'])) { 
			echo "font-weight: " . $array['font-weight'] . ";\n";
		}
		if (!empty($array['font-size'])) { 
			
			if ($important) {
				echo "font-size: " . $array['font-size'] . " !important;\n";
			} else {
				echo "font-size: " . $array['font-size'] . ";\n";
			}
		}
		if (!empty($array['text-decoration'])) { 
				echo "text-decoration: " . $array['text-decoration'] . " !important;\n";
		}
		if (!empty($array['text-transform'])) { 
				echo "text-transform: " . $array['text-transform'] . " !important;\n";
		}
		if (!empty($array['line-height'])) { 
				echo "line-height: " . $array['line-height'] . " !important;\n";
		}
		if (!empty($array['letter-spacing'])) { 
				echo "letter-spacing: " . $array['letter-spacing'] . " !important;\n";
		}
	}
	if(empty($array) && !empty($default)) {
		echo "font-family: '" . $default . "';\n";
	}
}

function thb_measurementecho($array) {
	if(!empty($array)) {
		echo $array[0] . $array[1];
	}
}

function thb_hex2rgb($hex) {

   $hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {

      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));

   } else {

      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));

   }

   $rgb = array($r, $g, $b);

   return implode(",", $rgb); // returns the rgb values separated by commas

}
?>