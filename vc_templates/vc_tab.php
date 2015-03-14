<?php
$output = $title = $tab_id = '';
extract(shortcode_atts($this->predefined_atts, $atts));

$output .= "\n\t\t\t" . '<li id="'. (empty($tab_id) ? sanitize_title( $title ) : $tab_id) .'Tab" role="tabpanel">';
$output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t" . '</li> ' . $this->endBlockComment('.wpb_tab');

echo $output;