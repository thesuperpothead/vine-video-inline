<?php
/*
Plugin Name: Video Inline
Description: Allows creating inline video as easy as pie.
Version: 1.1
Author: Viktor Novikov
Author URI: http://v-novicov.pro/
*/
?>
<?php

define('VINE_PURL', plugin_dir_url( __FILE__ ));

add_action('wp', function(){
	if (function_exists('get_field') && !empty(get_field( 'videos_inline' ))) {
		wp_enqueue_style( 'plyr', VINE_PURL.'assets/dist/plyr-master/plyr.css' );
		wp_enqueue_style( 'vil-style', VINE_PURL.'assets/styles.css' );
		wp_enqueue_script( 'plyr', VINE_PURL.'assets/dist/plyr-master/plyr.js', [], false, true );
		wp_enqueue_script( 'vil-script', VINE_PURL.'assets/scripts.js', ['plyr'], false, true );
	}
});

add_shortcode( 'video_inline', function($attrs){
	$videos = get_field( 'videos_inline' );
	if (!empty($videos[$attrs['id']-1])) {
		$video = $videos[$attrs['id']-1];
		if ($video['type'] == 'Self-hosted') {
			return '<video class="vil-player" playsinline controls data-poster="'.$video['video']['poster']['url'].'">'
				.'<source src="'.$video['video']['video_file']['url'].'" type="video/mp4" />'
				.'</video>';
		}
		if ($video['type'] == 'YouTube') {
			return '<div class="plyr__video-embed vil-player">'
				.'<iframe src="https://www.youtube.com/embed/'.$video['video']['youtube_video_id'].'?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" '
    			.'allowfullscreen allowtransparency allow="autoplay"></iframe></div>';
		}
		if ($video['type'] == 'Vimeo') {
			return '<div class="plyr__video-embed vil-player">'
				.'<iframe src="https://player.vimeo.com/video/'.$video['video']['vimeo_video_id'].'?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" '
				.'allowfullscreen allowtransparency allow="autoplay"></iframe></div>';
		}
	} else {
		return '[settings for video with id="'.$attrs['id'].'" was not obtained]';
	}
} );

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5fa3ba3a14daa',
	'title' => 'Inline Videos',
	'fields' => array(
		array(
			'key' => 'field_5fa3bb73cfd94',
			'label' => '',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Create Videos and use them as shortcodes: <b>[video_inline id="X"]</b>.',
			'new_lines' => 'br',
			'esc_html' => 0,
		),
		array(
			'key' => 'field_5fa3babecfd93',
			'label' => 'Videos',
			'name' => 'videos_inline',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'field_5fa3bc792be08',
					'label' => 'Type',
					'name' => 'type',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '30',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'Self-hosted' => 'Self-hosted',
						'YouTube' => 'YouTube',
						'Vimeo' => 'Vimeo',
					),
					'default_value' => false,
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 1,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5fa3bcaa2be0z',
					'label' => 'Video',
					'name' => 'video',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '70',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_5fa3bcd62be0a',
							'label' => 'Video File',
							'name' => 'video_file',
							'type' => 'file',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5fa3bc792be08',
										'operator' => '==',
										'value' => 'Self-hosted',
									),
								),
							),
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'library' => 'all',
							'min_size' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array(
							'key' => 'field_5fa3bd1a2be0b',
							'label' => 'Poster',
							'name' => 'poster',
							'type' => 'image',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5fa3bc792be08',
										'operator' => '==',
										'value' => 'Self-hosted',
									),
								),
							),
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'return_format' => 'array',
							'preview_size' => 'medium',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => '',
						),
						array(
							'key' => 'field_5fa3bd2e2be0c',
							'label' => 'YouTube Video ID',
							'name' => 'youtube_video_id',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5fa3bc792be08',
										'operator' => '==',
										'value' => 'YouTube',
									),
								),
							),
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
						array(
							'key' => 'field_5fa3bd736b26c',
							'label' => 'Vimeo Video ID',
							'name' => 'vimeo_video_id',
							'type' => 'text',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array(
								array(
									array(
										'field' => 'field_5fa3bc792be08',
										'operator' => '==',
										'value' => 'Vimeo',
									),
								),
							),
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => '',
							'prepend' => '',
							'append' => '',
							'maxlength' => '',
						),
					),
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
	),
	'menu_order' => 20,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
?>
