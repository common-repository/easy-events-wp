<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 11/1/2016
 * Time: 9:21 AM
 */

/**
 *  Override Easy Event Template
 *
 * @param $single_template
 *
 * @return mixed
 */
function easy_event_override_template( $single_template ) {

	if ( is_post_type_archive( 'easy_event' ) ) {
		if ( locate_template( 'ee-templates/archive.php' ) != '' ) {
			return locate_template( 'ee-templates/archive.php' );
		}
	}

	global $post;
	if ( $post != null && $post->post_type == 'easy_event' ) {


		if ( locate_template( 'ee-templates/single.php' ) != '' ) {
			return locate_template( 'ee-templates/single.php' );
		}
	}

	return $single_template;
}

add_filter( 'template_include', 'easy_event_override_template' );

/**
 * Filter Easy Event default
 *
 * @param $content
 *
 * @return mixed
 */
function easy_event_filter_the_content( $content ) {
	$content_temp = $content;
	if ( get_post_type() == 'easy_event' ) {
		$single_template = get_option( 'easy_event_single_template' );
		if ( $single_template == '' || $single_template == false ) {
			$single_template = file_get_contents( EASY_EVENT_DIR . '/templates-default/single-content.php' );
		}

		$post_id = get_the_ID();

		// Description
		$description = get_post_meta( $post_id, 'easy_event_description', true );
		$content     = str_replace( '[ee_description]', $description, $single_template );

		// Content
		$content = str_replace( '[ee_content]', $content_temp, $content );

		// Start time
		$start_time = get_post_meta( $post_id, 'easy_event_time_start', true );
		$content    = str_replace( '[ee_start_time]', $start_time, $content );

		// Start date
		$start_date = get_post_meta( $post_id, 'easy_event_date_start', true );
		$content    = str_replace( '[ee_start_date]', $start_date, $content );

		// Finish time
		$finish_time = get_post_meta( $post_id, 'easy_event_time_finish', true );
		$content     = str_replace( '[ee_finish_time]', $finish_time, $content );

		// Finish date
		$finish_date = get_post_meta( $post_id, 'easy_event_date_finish', true );
		$content     = str_replace( '[ee_finish_date]', $finish_date, $content );

		// Address
		$address = get_post_meta( $post_id, 'easy_event_address', true );
		$content = str_replace( '[ee_address]', $address, $content );

		// Map
		$ee_map = '';
		$map    = get_post_meta( $post_id, 'easy_event_address', true );
		if ( $map != false && $map != '' ) {
			$map_size       = __( '200x150', 'easy_event' );
			$map_zoom       = __( '13', 'easy_event' );
			$map_icon_lable = __( 'Here', 'easy_event' );
			$ee_image_map   = sprintf( '//maps.googleapis.com/maps/api/staticmap?center=%s&zoom=%s&scale=false&size=%s&maptype=roadmap&format=png&visual_refresh=true&markers=size:mid|label:%s', $map, $map_zoom, $map_size, $map_icon_lable );

			$ee_map = '<img class="ee_map" src="' . $ee_image_map . '" alt="' . $address . '" >';
		}

		$content = str_replace( '[ee_map]', $ee_map, $content );

		// Top
		$top_html = '';
		$image    = get_post_thumbnail_id( $post_id );
		if ( $image != '' ) {
			$featured_image = wp_get_attachment_image_src( $image, 'full' );

			$top_html .= '<div class="ee-thumbnail" style="background-image: url(\'' . $featured_image[0] . '\');"></div>';
		}

		/**
		 * Count down
		 */
		$my_time = easy_event_get_my_time();
		if ( $start_date != '' ) {
			$time_start_event = $start_date . ' ';
			if ( $start_time == '' ) {
				$time_start_event .= '00:00:00';
			} else {
				$time_start_event .= $start_time . ':00';
			}
			$time_start_event_builder = date_create()->createFromFormat(
				'd/m/Y H:i:s',
				$time_start_event
			);

			$time_finish_event = $time_start_event;
			if ( $finish_date != '' ) {
				$time_finish_event = $finish_date . ' ';

				if ( $finish_time == '' ) {
					$time_finish_event .= '00:00:00';
				} else {
					$time_finish_event .= $finish_time . ':00';
				}
			}
			$time_finish_event_builder = date_create()->createFromFormat(
				'd/m/Y H:i:s',
				$time_finish_event
			);

			$my_time_timestamp = $my_time->getTimestamp();
			$start_timestamp   = $time_start_event_builder->getTimestamp();
			$finish_timestamp  = $time_finish_event_builder->getTimestamp();

			// Took place
			if ( $my_time_timestamp > $finish_timestamp ) {
				$top_html .= '<div class="ee-top-inner"><div class="ee-notify">' . esc_html__( 'This event took place.', 'easy_event' ) . '</div></div>';
			} elseif ( $my_time_timestamp < $start_timestamp ) {//Upcoming
				$top_html .= '<div class="ee-top-inner"><div class="ee-count-down" data-time="' . $time_start_event_builder->format( 'Y/m/d H:i:s' ) . '">
					<div class="days ee_round">
						<div class="number">0</div>
						<div class="text">' . esc_html__( 'Days', 'easy_event' ) . '</div>
					</div>
					<div class="hours ee_round">
						<div class="number">0</div>
						<div class="text">' . esc_html__( 'Hours', 'easy_event' ) . '</div>
					</div>
					<div class="minutes ee_round">
						<div class="number">0</div>
						<div class="text">' . esc_html__( 'Minutes', 'easy_event' ) . '</div>
					</div>
					<div class="seconds ee_round">
						<div class="number">0</div>
						<div class="text">' . esc_html__( 'Seconds', 'easy_event' ) . '</div>
					</div>
				</div></div>';
			} else {//Happening
				$top_html .= '<div class="ee-top-inner"><div class="ee-notify">' . esc_html__( 'This event is taking place...', 'easy_event' ) . '</div></div>';
			}
		}

		if ( $top_html != '' ) {
			$top_html = '<div class="ee-top">' . $top_html . '</div>';
		}
		$content = str_replace( '[ee_top]', $top_html, $content );

		wp_enqueue_style( 'easy_event', EASY_EVENT_URI . '/assets/css/style.min.css', array(), EASY_EVENT_VERSION );
		wp_enqueue_script(
			'jquery-countdown',
			EASY_EVENT_URI . '/assets/js/jquery.countdown.min.js', array( 'jquery' ), EASY_EVENT_VERSION
		);
		wp_enqueue_script(
			'easy-event',
			EASY_EVENT_URI . '/assets/js/easy-event.js',
			array( 'jquery', 'jquery-countdown' ),
			EASY_EVENT_VERSION
		);
	}

	return $content;
}

add_filter( 'the_content', 'easy_event_filter_the_content' );