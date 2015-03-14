<?php
$output = $title = $el_class = $open = $css_animation = '';
extract(shortcode_atts(array(
    'title' => __("Click to toggle", "js_composer"),
    'el_class' => '',
    'open' => 'false',
    'css_animation' => '',
    'style'	=> ''
), $atts));

$el_class = $this->getExtraClass($el_class);
$open = ( $open == 'true' ) ? ' wpb_toggle_title_active' : '';
$el_class .= ( $open == ' wpb_toggle_title_active' ) ? ' wpb_toggle_open' : '';

$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle'.$open, $this->settings['base']);
$css_class .= $this->getCSSAnimation($css_animation);
$output .= '<div class="toggle '.$style.'">';
$output .= apply_filters('wpb_toggle_heading', '<div class="title '.$css_class.'">'.$title.'</div>', array('title'=>$title, 'open'=>$open));
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_toggle_content'.$el_class, $this->settings['base']);
$output .= '<div class="inner '.$css_class.'">'.wpb_js_remove_wpautop($content, true).'</div>'.$this->endBlockComment('toggle')."\n";
$output .= '</div>';
echo $output;