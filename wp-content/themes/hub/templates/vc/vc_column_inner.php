<?php
if (!defined('ABSPATH')) {
	die('-1');
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_id
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $el_id = $width = $align = $responsive_align = $parallax_speed_bg = $parallax_speed_video = $parallax = $parallax_image = $video_bg = $video_bg_url = $video_bg_parallax = $css = $offset = $css_animation = $enable_backdrop_filter = $backfilter_blur = $backfilter_saturation = $backfilter_brightness = $backfilter_contrast = $backfilter_grayscale = $backfilter_hue = $backfilter_sepia = $backfilter_sepia = $enable_hover_move = $hover_move_value = '';
$output = $gradient_bg_color = $enable_overlay = $overlay_bring_front = $gradient_bg = $overlay_bg = $hover_overlay_bg = $bg_position = $bg_pos_h = $bg_pos_v = $bg_attachment = $bg_styles = $before_content = '';

//Paralax vars
$parallax = $parallax_preset = $parallax_from = $parallax_to = $parallax_duration = $parallax_offset = $parallax_trigger = $parallax_trigger_number = $enable_pin = $enable_link = $link = '';

$translate_from_x = $translate_from_y = $translate_from_z = $scale_from_x = $scale_from_y = $scale_from_z = $rotate_from_x = $rotate_from_y = $rotate_from_z = $from_torigin_x = $from_torigin_x_custom = $from_torigin_y = $from_torigin_y_custom = $from_opacity = '';

$translate_to_x = $translate_to_y = $translate_to_z = $scale_to_x = $scale_to_y = $scale_to_z = $rotate_to_x = $otate_to_y = $rotate_to_z = $to_torigin_x = $to_torigin_x_custom = $to_torigin_y = $to_torigin_y_custom = $to_opacity = $to_delay = $to_easy = '';

//Custom Animation
$enable_content_animation = $animation_preset = $ca_duration = $ca_start_delay = $ca_delay = $ca_easing = $ca_direction = $ca_init_translate_x = $ca_init_translate_y = $ca_init_translate_z = $ca_init_scale_x = $ca_init_scale_y = $ca_init_rotate_x = $ca_init_rotate_y = $ca_init_rotate_z = $ca_init_opacity = $ca_an_translate_x = $ca_an_translate_y = $ca_an_translate_z = $ca_an_scale_x = $ca_an_scale_y = $ca_an_rotate_x = $ca_an_rotate_y = $ca_an_rotate_z = $ca_an_opacity = $ca_init_origin_x = $ca_init_origin_y = $ca_init_origin_z = $ca_an_origin_x = $ca_an_origin_y = $ca_an_origin_z = '';

//Shadowbox
$enable_column_shadowbox = $column_box_shadow = $enable_column_hover_shadowbox = $column_hover_box_shadow = $responsive_style = $video_bg_source = $video_local_mp4_url = $video_local_webm_url = $y_start_time = $y_end_time = $mobile_video_bg = $has_video_bg = $video_loop = '';

//Custom CSS
$custom_style = '';

$bg_image = '';

$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);


wp_enqueue_script('wpb_composer_front_js');

$width = wpb_translateColumnWidthToSpan($width);
$width = vc_column_offset_class_merge($offset, $width);

$liquid_id = uniqid('liquid-column-');

$css_classes = array(
	$this->getExtraClass($el_class) . $this->getCSSAnimation($css_animation),
	'wpb_column',
	'vc_column_container',
	$width,
	$align,
	$responsive_align,
	$liquid_id,
);

if (!empty($responsive_css)) {
	$responsive_id = uniqid('liquid-column-responsive-');
	$css_classes[] = $responsive_id;
	$responsive_selector = $responsive_id . ' > .vc_column-inner';
	$responsive_style = Liquid_Responsive_Css_Editor::generate_css($responsive_css, $responsive_selector);
}

if (
	vc_shortcode_custom_css_has_property($css, array(
		'border',
		'background',
	)) || $video_bg || $parallax
) {
	$css_classes[] = 'vc_col-has-fill';
}

if ('lqd-column-move-onhover' === $enable_hover_move) {
	$css_classes[] = $enable_hover_move;
	if (!empty($hover_move_value)) {
		$custom_style .= '.' . $liquid_id . '{ --lqd-move-onhover-val:' . $hover_move_value . '}';
	}
}

if ($enable_column_shadowbox) {
	$column_box_shadow = vc_param_group_parse_atts($column_box_shadow);
	$column_box_shadow_css = liquid_helper()->get_shadow_css($column_box_shadow);
	$custom_style .= '.' . $liquid_id . ' > .vc_column-inner { box-shadow:' . $column_box_shadow_css . '}';
}
if ($enable_column_hover_shadowbox) {
	$column_hover_box_shadow = vc_param_group_parse_atts($column_hover_box_shadow);
	$column_hover_box_shadow_css = liquid_helper()->get_shadow_css($column_hover_box_shadow);
	$custom_style .= '.' . $liquid_id . ' > .vc_column-inner:hover { box-shadow:' . $column_hover_box_shadow_css . '}';
}
if (!empty($gradient_bg_color)) {
	$custom_style .= '.' . $liquid_id . ' > .vc_column-inner { background:' . $gradient_bg_color . '}';
}

if ('yes' === $enable_backdrop_filter) {

	$custom_style .= '.' . $liquid_id . ' > .vc_column-inner { -webkit-backdrop-filter: ' .
		'blur(' . $backfilter_blur . 'px) ' .
		'saturate(' . $backfilter_saturation . ') ' .
		'brightness(' . $backfilter_brightness . ') ' .
		'contrast(' . $backfilter_contrast . ') ' .
		'grayscale(' . $backfilter_grayscale . ') ' .
		'hue-rotate(' . $backfilter_hue . 'deg) ' .
		'sepia(' . $backfilter_sepia . ') ' .
		'opacity(' . $backfilter_opacity . ');' .

		'backdrop-filter: ' .
		'blur(' . $backfilter_blur . 'px) ' .
		'saturate(' . $backfilter_saturation . ') ' .
		'brightness(' . $backfilter_brightness . ') ' .
		'contrast(' . $backfilter_contrast . ') ' .
		'grayscale(' . $backfilter_grayscale . ') ' .
		'hue-rotate(' . $backfilter_hue . 'deg) ' .
		'sepia(' . $backfilter_sepia . ') ' .
		'opacity(' . $backfilter_opacity . ');' .
		'}';
}

$wrapper_attributes = $ca_data_opts = $wrapper_bg_attributes =  array();

//Add background image to data attibute
if (vc_shortcode_custom_css_has_property($css, array('background'))) {

	$matches = array();
	preg_match_all('~\bbackground(-image)?\s*:(.*?)\(\s*(\'|")?(?<image>.*?)\3?\s*\)~i', $css, $matches);
	$images = $matches['image'];
	$bg_image = isset($images[0]) ? esc_url($images[0]) : '';
};

if (!empty($bg_image)) {

	$before_content .= '<span class="row-bg-loader"></span>';

	$wrapper_attributes[] = 'data-row-bg="' . $bg_image . '"';

	$parallax_attrs = array();

	if ('enable_parallax' == $parallax) {

		$parallax_attrs[] = 'data-parallax="true"';
		$parallax_attrs[] = 'data-parallax-from=\'' . wp_json_encode(array('yPercent' => -15)) . '\'';
		$parallax_attrs[] = 'data-parallax-to=\'' . wp_json_encode(array('yPercent' => 0)) . '\'';

		$css_classes[] = 'lqd-parallax-markup-exists';
		$css_classes[] = 'lqd-parallax-bg-enabled';
	}

	$before_content .= '<div class="row-bg-wrap">
		<div class="row-bg-inner">
			<figure class="row-bg" ' . implode(' ', $parallax_attrs) . '></figure>
		</div>
	</div>';

	$css_classes[] = 'lqd-has-bg-markup';
	$css_classes[] = 'row-bg-appended';
}

if ('custom' != $bg_position && !empty($bg_position)) {
	$bg_styles = ' background-position:' . esc_attr($bg_position) . ' !important;';
} elseif ('custom' === $bg_position) {
	$bg_styles = ' background-position:' . esc_attr($bg_pos_h) . ' ' . esc_attr($bg_pos_v) . ' !important; ';
}

if ('scroll' !== $bg_attachment && !empty($bg_attachment)) {
	$bg_attachment = ' background-attachment:' .  esc_attr($bg_attachment) . ' !important; ';
} else {
	$bg_attachment = '';
}

if (!empty($gradient_bg)) {
	$bg_styles = 'background:' . esc_attr($gradient_bg) . ';';
}

if (!empty($bg_styles) || !empty($bg_attachment)) {
	$wrapper_bg_attributes[] = 'style="' . esc_attr(trim($bg_styles . $bg_attachment)) . '"';
}

$video_bg_output = $disable_mobile = '';
if (!empty($video_bg)) {

	wp_enqueue_script('jquery-ytplayer');
	wp_enqueue_style('jquery-ytplayer');

	if ('local' === $video_bg_source) {
		if (!empty($video_local_mp4_url) || !empty($video_local_webm_url)) {

			if ('yes' === $mobile_video_bg) {
				$disable_mobile = 'data-inlinevideo-options=\'' . wp_json_encode(array('disableOnMobile' => true)) . '\'';
			}
			
			if ('yes' === $video_loop) {
				$video_loop = 'loop';
			}

			wp_enqueue_script('wp-mediaelement');
			wp_enqueue_style('wp-mediaelement');

			$video_bg_output = '<div class="lqd-vbg-wrap">
							<div class="lqd-vbg-inner">
								<span class="lqd-vbg-loader"></span>
								<video class="lqd-vbg-video hidden" data-video-bg="true" ' . $disable_mobile . ' playsinline autoplay ' . $video_loop . ' muted>';
			if (!empty($video_local_mp4_url)) {
				$video_bg_output .= '<source src="' . esc_url($video_local_mp4_url) . '" type="video/mp4">';
			}
			if (!empty($video_local_webm_url)) {
				$video_bg_output .= '<source src="' . esc_url($video_local_webm_url) . '" type="video/webm">';
			}
			$video_bg_output .=	'</video>
						</div>
					</div>';
		}
	} else {

		$data_youtube = array();
		if (!empty($video_bg_url)) {
			$data_youtube['videoURL'] = esc_url($video_bg_url);
		}
		if (!empty($y_start_time)) {
			$data_youtube['startAt'] = (int)$y_start_time;
		}
		if (!empty($y_end_time)) {
			$data_youtube['stopAt'] = (int)$y_end_time;
		}
		if ('yes' === $mobile_video_bg) {
			$data_youtube['disableOnMobile'] = true;
		}

		$video_bg_output = '<div class="lqd-vbg-wrap">
						<div class="lqd-vbg-inner">
							<span class="lqd-vbg-loader"></span>
							<div
								class="lqd-vbg-video"
								data-video-bg="true"
								data-youtube-options=\'' . wp_json_encode($data_youtube) . '\'>
							</div>
					</div>
				</div>';
	}
}

if ('yes' == $row_scale_bg_onhover) {
	$css_classes[] = 'lqd-scale-bg-onhover';
}

if ('yes' == $column_top_ontablet) {
	$css_classes[] = 'lqd-column-top-ontablet';
}
if ('yes' == $column_top_onmobile) {
	$css_classes[] = 'lqd-column-top-onmobile';
}

if (!empty($parallax_image)) {
	if ($has_video_bg) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id = preg_replace('/[^\d]/', '', $parallax_image);
		$parallax_image_src = wp_get_attachment_image_src($parallax_image_id, 'full');
		if (!empty($parallax_image_src[0])) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr($parallax_image_src) . '"';
}
if (!$parallax && $has_video_bg) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr($video_bg_url) . '"';
}

$css_class = preg_replace('/\s+/', ' ', apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ', array_filter($css_classes)), $this->settings['base'], $atts));
$wrapper_attributes[] = 'class="' . esc_attr(trim($css_class)) . '"';
if (!empty($el_id)) {
	$wrapper_attributes[] = 'id="' . esc_attr($el_id) . '"';
}

if ('yes' === $enable_content_animation) {

	$presetsValues = array();

	$opts = $init_values = $animations_values = $arr = array();

	$opts['triggerHandler'] = 'inview';
	$opts['animationTarget'] = 'all-childs';

	$opts['duration'] = !empty($ca_duration) ? $ca_duration : 700;
	if (!empty($ca_start_delay)) {
		$opts['startDelay'] = $ca_start_delay;
	}
	$opts['delay'] = !empty($ca_delay) ? $ca_delay : 100;
	$opts['ease'] = $ca_easing;
	$opts['direction'] = $ca_direction;

	if ('custom' !== $animation_preset) {

		$opts['duration'] = !empty($ca_duration) ? $ca_duration : 1600;
		$opts['delay'] = !empty($ca_delay) ? $ca_delay : 250;

		$presetsValues = liquid_get_animation_preset($animation_preset);
		$init_values       = $presetsValues['from'];
		$animations_values = $presetsValues['to'];
	} else {

		//Init values
		if (!empty($ca_init_translate_x) || !empty($ca_an_translate_x)) {
			$init_values['x'] = (int) $ca_init_translate_x;
		}
		if (!empty($ca_init_translate_y) || !empty($ca_an_translate_y)) {
			$init_values['y'] = (int) $ca_init_translate_y;
		}
		if (!empty($ca_init_translate_z) || !empty($ca_an_translate_z)) {
			$init_values['z'] = (int) $ca_init_translate_z;
		}

		if ('1' !== $ca_init_scale_x || '1' !== $ca_an_scale_x) {
			$init_values['scaleX'] = (float) $ca_init_scale_x;
		}
		if ('1' !== $ca_init_scale_y || '1' !== $ca_an_scale_y) {
			$init_values['scaleY'] = (float) $ca_init_scale_y;
		}

		if (!empty($ca_init_rotate_x) || !empty($ca_an_rotate_x)) {
			$init_values['rotationX'] = (int) $ca_init_rotate_x;
		}
		if (!empty($ca_init_rotate_y) || !empty($ca_an_rotate_y)) {
			$init_values['rotationY'] = (int) $ca_init_rotate_y;
		}
		if (!empty($ca_init_rotate_z) || !empty($ca_an_rotate_z)) {
			$init_values['rotationZ'] = (int) $ca_init_rotate_z;
		}

		if (!empty($ca_init_origin_x)) {
			$init_values['transformOriginX'] = (int) $ca_init_origin_x;
		}
		if (!empty($ca_init_origin_y)) {
			$init_values['transformOriginY'] = (int) $ca_init_origin_y;
		}
		if (!empty($ca_init_origin_z)) {
			$init_values['transformOriginZ'] = $ca_init_origin_z;
		}

		if (isset($ca_init_opacity) && '1' !== $ca_init_opacity || '1' !== $ca_an_opacity) {
			$init_values['opacity'] = (float) $ca_init_opacity;
		}

		//Animation values
		if (!empty($ca_init_translate_x) || !empty($ca_an_translate_x)) {
			$animations_values['x'] = (int) $ca_an_translate_x;
		}
		if (!empty($ca_init_translate_y) || !empty($ca_an_translate_y)) {
			$animations_values['y'] = (int) $ca_an_translate_y;
		}
		if (!empty($ca_init_translate_z) || !empty($ca_an_translate_z)) {
			$animations_values['z'] = (int) $ca_an_translate_z;
		}

		if (isset($ca_an_scale_x) && '1' !== $ca_init_scale_x || '1' !== $ca_an_scale_x) {
			$animations_values['scaleX'] = (float) $ca_an_scale_x;
		}
		if (isset($ca_an_scale_y) && '1' !== $ca_init_scale_y || '1' !== $ca_an_scale_y) {
			$animations_values['scaleY'] = (float) $ca_an_scale_y;
		}

		if (!empty($ca_init_rotate_x) || !empty($ca_an_rotate_x)) {
			$animations_values['rotationX'] = (int) $ca_an_rotate_x;
		}
		if (!empty($ca_init_rotate_y) || !empty($ca_an_rotate_y)) {
			$animations_values['rotationY'] = (int) $ca_an_rotate_y;
		}
		if (!empty($ca_init_rotate_z) || !empty($ca_an_rotate_z)) {
			$animations_values['rotationZ'] = (int) $ca_an_rotate_z;
		}

		if (!empty($ca_an_origin_x)) {
			$animations_values['transformOriginX'] = (int) $ca_an_origin_x;
		}
		if (!empty($ca_an_origin_y)) {
			$animations_values['transformOriginY'] = (int) $ca_an_origin_y;
		}
		if (!empty($ca_an_origin_z)) {
			$animations_values['transformOriginZ'] = $ca_an_origin_z;
		}

		if (isset($ca_an_opacity) && '1' !== $ca_init_opacity || '1' !== $ca_an_opacity) {
			$animations_values['opacity'] = (float) $ca_an_opacity;
		}
	}

	$opts['initValues'] = !empty($init_values) ? $init_values : array();
	$opts['animations'] = !empty($animations_values) ? $animations_values : array();

	$ca_data_opts[] = 'data-custom-animations="true"';
	$ca_data_opts[] = 'data-ca-options=\'' . stripslashes(wp_json_encode($opts)) . '\'';
}

if ('yes' === $parallax) {

	$parallax_data = $parallax_data_from = $parallax_data_to = $parallax_opts = array();

	$wrapper_attributes[] = 'data-parallax="true"';

	//Data-options-from
	if (!empty($translate_from_x) || !empty($translate_to_x)) {
		$parallax_data_from['x']      = (int) $translate_from_x;
	}
	if (!empty($translate_from_y) || !empty($translate_to_y)) {
		$parallax_data_from['y']      = (int) $translate_from_y;
	}
	if (!empty($translate_from_z) || !empty($translate_to_z)) {
		$parallax_data_from['z']      = (int) $translate_from_z;
	}

	if ('1' !== $scale_from_x || '1' !== $scale_to_x) {
		$parallax_data_from['scaleX']     = (float) $scale_from_x;
	}
	if ('1' !== $scale_from_y || '1' !== $scale_to_y) {
		$parallax_data_from['scaleY']     = (float) $scale_from_y;
	}

	if (!empty($rotate_from_x) || !empty($rotate_to_x)) {
		$parallax_data_from['rotationX'] = (int) $rotate_from_x;
	}
	if (!empty($rotate_from_y) || !empty($rotate_to_y)) {
		$parallax_data_from['rotationY'] = (int) $rotate_from_y;
	}
	if (!empty($rotate_from_z) || !empty($rotate_to_z)) {
		$parallax_data_from['rotationZ'] = (int) $rotate_from_z;
	}

	if (isset($from_opacity) && '1' !== $from_opacity || '1' !== $to_opacity) {
		$parallax_data_from['opacity']    = (float) $from_opacity;
	}

	if (!empty($from_torigin_x_custom)) {
		$_x_custom = $from_torigin_x_custom;
	} else {
		$_x_custom = !empty($from_torigin_x) ? $from_torigin_x : '';
	}
	if (!empty($from_torigin_y_custom)) {
		$_y_custom = $from_torigin_y_custom;
	} else {
		$_y_custom = !empty($from_torigin_y) ? $from_torigin_y : '';
	}
	if (!empty($_x_custom) && !empty($_y_custom)) {
		$parallax_data_from['transformOrigin'] = $_x_custom . '&nbsp;' . $_y_custom;
	}

	//Data-options-to
	if (!empty($translate_from_x) || !empty($translate_to_x)) {
		$parallax_data_to['x'] = (int) $translate_to_x;
	}
	if (!empty($translate_from_y) || !empty($translate_to_y)) {
		$parallax_data_to['y'] = (int) $translate_to_y;
	}
	if (!empty($translate_from_z) || !empty($translate_to_z)) {
		$parallax_data_to['z'] = (int) $translate_to_z;
	}

	if (isset($scale_to_x) && '1' !== $scale_from_x || '1' !== $scale_to_x) {
		$parallax_data_to['scaleX'] = (float) $scale_to_x;
	}
	if (isset($scale_to_y) && '1' !== $scale_from_y || '1' !== $scale_to_y) {
		$parallax_data_to['scaleY'] = (float) $scale_to_y;
	}

	if (!empty($rotate_from_x) || !empty($rotate_to_x)) {
		$parallax_data_to['rotationX'] = (int) $rotate_to_x;
	}
	if (!empty($rotate_from_y) || !empty($rotate_to_y)) {
		$parallax_data_to['rotationY'] = (int) $rotate_to_y;
	}
	if (!empty($rotate_from_z) || !empty($rotate_to_z)) {
		$parallax_data_to['rotationZ'] = (int) $rotate_to_z;
	}

	if (isset($to_opacity) && '1' !== $from_opacity || '1' !== $to_opacity) {
		$parallax_data_to['opacity'] = (float) $to_opacity;
	}

	if (!empty($to_torigin_x_custom)) {
		$to_x_custom = $to_torigin_x_custom;
	} else {
		$to_x_custom = !empty($to_torigin_x) ? $to_torigin_x : '';
	}
	if (!empty($to_torigin_y_custom)) {
		$to_y_custom = $to_torigin_y_custom;
	} else {
		$to_y_custom = !empty($to_torigin_y) ? $to_torigin_y : '';
	}
	if (!empty($to_x_custom) && !empty($to_y_custom)) {
		$parallax_data_to['transformOrigin'] = $to_x_custom . '&nbsp;' . $to_y_custom;
	}

	//Parallax general options
	if (!empty($parallax_from)) {
		$parallax_data['from'] = $parallax_from;
	} else {
		$parallax_data['from'] = $parallax_data_from;
	}
	if (!empty($parallax_to)) {
		$parallax_data['to'] = $parallax_to;
	} else {
		$parallax_data['to'] = $parallax_data_to;
	}

	if (is_array($parallax_data['from']) && !empty($parallax_data['from'])) {
		$wrapper_attributes[] = 'data-parallax-from=\'' . wp_json_encode($parallax_data['from']) . '\'';
	} elseif (!empty($parallax_from)) {
		$wrapper_attributes[] = 'data-parallax-from=\'{' . $parallax_from . '}\'';
	}

	if (is_array($parallax_data['to']) && !empty($parallax_data['to'])) {

		$wrapper_attributes[] = 'data-parallax-to=\'' . wp_json_encode($parallax_data['to']) . '\'';
	} elseif (!empty($parallax_to)) {
		$wrapper_attributes[] = 'data-parallax-to=\'{' . $parallax_to . '}\'';
	}

	if (isset($to_easy)) {
		$parallax_opts['ease'] = $to_easy;
	}
	if (!empty($to_delay)) {
		$parallax_opts['delay'] = (float) $to_delay;
	}
	if (!empty($parallax_offset)) {
		$parallax_opts['offset'] = esc_attr($parallax_offset);
	}
	if ('number' !== $parallax_trigger) {
		$parallax_opts['start'] = esc_attr($parallax_trigger);
	} elseif (!empty($parallax_trigger_number)) {
		$parallax_opts['start'] = esc_attr($parallax_trigger_number);
	}
	if (!empty($parallax_duration)) {
		$parallax_opts['end'] = esc_attr('bottom'  . $parallax_duration . ' top');
	}
	if (!empty($parallax_opts)) {
		$wrapper_attributes[] = 'data-parallax-options=\'' . wp_json_encode($parallax_opts) . '\'';
	}
}

$overlay_html = '';
if ($enable_overlay) {

	if (!empty($hover_overlay_bg)) {
		$overlay_html = '<div class="liquid-column-overlay pointer-events-none liquid-column-overlay-hover" style="background:' . esc_attr($hover_overlay_bg) . '"></div>';
	}
	if (!empty($overlay_bg)) {
		$overlay_html .= '<div class="liquid-column-overlay pointer-events-none" style="background:' . esc_attr($overlay_bg) . '"></div>';
	}
}

$check = apply_filters('liquid_dinamic_css_output', '__return_true');

if ('enable_column_link' === $enable_link) {
	$link_attributes = liquid_get_link_attributes($link, '#');
	$link_attributes['class'] = 'liquid-overlay-link z-index-3';
}

if (!empty($responsive_style) && $check || !empty($custom_style) && $check) {
	$output .= '<style>' . $responsive_style . $custom_style . '</style>';
}


$output .= '<div ' . implode(' ', $wrapper_attributes) . '>';
$output .= '<div class="vc_column-inner ' . esc_attr(trim(vc_shortcode_custom_css_class($css))) . '" ' . implode(' ', $wrapper_bg_attributes) . '>';
$output .= $video_bg_output;
$output .= $before_content;
if (!$overlay_bring_front) {
	$output .= $overlay_html;
}
$output .= '<div class="wpb_wrapper" ' . implode(' ', $ca_data_opts) . '>';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
if ($overlay_bring_front) {
	$output .= $overlay_html;
}
if ('enable_column_link' === $enable_link) {
	$output .= '<a' . ld_helper()->html_attributes($link_attributes) . '></a>';
}
$output .= '</div>';
$output .= '</div>';

echo apply_filters('liquid_vc_column_inner', $output);
