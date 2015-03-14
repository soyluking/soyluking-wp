<?php

function thb_excerpt($excerpt_length, $added)
{
    $text = apply_filters( 'the_excerpt', get_the_excerpt() );
    $text = str_replace('[...]', '', $text );
    $chars_text = strlen($text);
    $text = $text." ";
    $text = substr($text,0,$excerpt_length);
    $text = substr($text,0,strrpos($text,' '));
		$text = $text.$added;
		$text = apply_filters('the_content', $text);
    return $text;
}
function thb_ShortenText($text, $chars_limit)
	{
	$text = strip_tags($text);
	$text = strip_shortcodes( $text );
	
	$chars_text = strlen($text);
	$text = $text." ";
	$text = substr($text,0,$chars_limit);
	$text = substr($text,0,strrpos($text,' '));
	
	if ($chars_text > $chars_limit) {
		$text = $text."...";
	}
	$text = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $text);
	$text = apply_filters('the_content', $text);
	return $text;
}
?>