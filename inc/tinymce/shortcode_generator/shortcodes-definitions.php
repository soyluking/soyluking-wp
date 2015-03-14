<?php

#-----------------------------------------------------------------
# Elements 
#-----------------------------------------------------------------

$thb_shortcodes['header_2'] = array( 
	'type'=>'heading', 
	'title'=>__('Elements')
);
$thb_shortcodes['small_title'] = array( 
	'type'=>'regular', 
	'title'=>__('Small Title'), 
	'attr'=>array( 
		'title'=>array(
			'type'=>'text', 
			'title'=>'Title'
		)
	)
);
$thb_shortcodes['medium_title'] = array( 
	'type'=>'regular', 
	'title'=>__('Medium Title'), 
	'attr'=>array( 
		'title'=>array(
			'type'=>'text', 
			'title'=>'Title'
		)
	)
);
$thb_shortcodes['large_title'] = array( 
	'type'=>'regular', 
	'title'=>__('Large Title'), 
	'attr'=>array( 
		'title'=>array(
			'type'=>'text', 
			'title'=>'Title'
		)
	)
);
$thb_shortcodes['extra_large_title'] = array( 
	'type'=>'regular', 
	'title'=>__('Extra Large Title'), 
	'attr'=>array( 
		'title'=>array(
			'type'=>'text', 
			'title'=>'Title'
		)
	)
);
$thb_shortcodes['thb_button'] = array( 
	'type'=>'regular', 
	'title'=>__('Button', THB_THEME_NAME ), 
	'attr'=>array(
		'size'=>array(
			'type'=>'radio', 
			'title'=>__('Size', THB_THEME_NAME),
			'opt'=>array(
				'small'=>'Small',
				'medium'=>'Medium',
				'large'=>'Large'
			)
		),
		'color'=>array(
			'type'=>'radio', 
			'title'=>__('Color', THB_THEME_NAME),
			'opt'=>array(
				'regular' => 'Regular',
				'black' =>  'Black',
				'white' =>  'White'
			)
		),
		'animation'=>array(
			'type'=>'radio', 
			'title'=>__('Animation', THB_THEME_NAME),
			'opt'=>array(
				"" => "None",
				"animation right-to-left" => "Left",
				"animation left-to-right" => "Right",
				"animation bottom-to-top" => "Top",
				"animation top-to-bottom" => "Bottom",
				"animation scale" => "Scale",
				"animation fade-in" => "Fade"
			)
		),
		'icon'=>array(
			'type'=>'text', 
			'title'=>__('Icon', THB_THEME_NAME)
		),
		'title'=>array(
			'type'=>'text', 
			'title'=>__('Buton Text', THB_THEME_NAME)
		),
		'link'=>array(
			'type'=>'text', 
			'title'=>__('Buton Link', THB_THEME_NAME)
		),
		'target_blank'=> array(
			'type'=>'checkbox', 
			'title'=>__('Open in New Window?', THB_THEME_NAME ),
			'desc'=>'Opens the button link in new window'
		)
	)
);
$thb_shortcodes['quote'] = array( 
	'type'=>'regular', 
	'title'=>__('Quotes'), 
	'attr'=>array( 
		'align'=>array(
			'type'=>'radio', 
			'title'=>__('Alignment'), 
			'opt'=>array(
				'normal'=>'Normal',
				'pullleft'=>'Pull Left',
				'pullright'=>'Pull Right'
			)
		),
		'content'=>array(
			'type'=>'textarea', 
			'title'=>__('Content')
		),
		'author'=>array(
			'type'=>'text', 
			'title'=>'Quote Author'
		)
		
	)
);
$thb_shortcodes['tags'] = array( 
	'type'=>'regular', 
	'title'=>__('Highlights', THB_THEME_NAME ), 
	'attr'=>array(
		'color'=>array(
			'type'=>'radio', 
			'title'=>__('Color', THB_THEME_NAME),
			'opt'=>array(
				'accent'=>'Accent',
				'black'=>'Black',
			)
		),
		'text'=>array(
			'type'=>'text', 
			'title'=>__('Text', THB_THEME_NAME)
		)
	)
);
$thb_shortcodes['dropcap'] = array( 
	'type'=>'regular', 
	'title'=>__('Dropcap', THB_THEME_NAME ),
	'attr'=>array( 
		'title'=>array(
			'type'=>'text', 
			'title'=>'Letter'
		)
	)
);

$thb_shortcodes['single_icon'] = array( 
	'type'=>'regular', 
	'title'=>__('Single Icon'), 
	'attr'=>array( 
		'icon'=>array(
			'type'=>'select', 
			'title'=>__('Icon'),
			'values'=> thb_getIconArray()
		),
		'size'=>array(
			'type'=>'radio', 
			'title'=>__('Icon Size'),
			'opt'=>array(
				'icon-1x'=>'1x',
				'icon-2x'=>'2x',
				'icon-3x'=>'3x',
				'icon-4x'=>'4x'
			)
		),
		'boxed'=> array(
			'type'=>'checkbox', 
			'title'=>__('Boxed?'),
			'desc'=>'Boxed contains the icon inside a box'
		),
		'icon_link'=>array(
			'type'=>'text', 
			'title'=>__('Icon Link'),
			'desc'=>'If you would like to link the icon to an url, enter it here. (Boxed option should be checked)'
		)
	)
);
?>