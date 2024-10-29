<?php

/**
 * Show event upcoming
 *
 * @param $show
 */
function easy_event_upcoming_loop_to_widget( $show ) {
	$args = array(
		'post_type'      => array( 'easy_event' ),
		'posts_per_page' => - 1,
	);

	$the_query = new WP_Query( $args );

	/**
	 * Filter the upcoming event
	 */
	$date_format = 'd/m/Y';
	$arr         = array();

	$today = date_create( 'now' );
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();

			$date_event = get_post_meta( get_the_ID(), 'easy_event_date_start', true );

			if ( $date_event == '' || $date_event == false ) {
				continue;
			}
			$date_event = date_create()->createFromFormat(
				$date_format,
				$date_event
			);
			if ( $date_event->getTimestamp() >= $today->getTimestamp() ) {
				$arr[ get_the_ID() ] = $date_event->getTimestamp();
			}
		}
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	/**
	 * Show the upcoming event post
	 */
	asort( $arr );
	$post_event_ids = array_keys( $arr );
	if ( count( $post_event_ids ) > 0 ) {
		echo '<div class="easy-event vticker">';
		echo '<ul class="list-events" data-number="' . $show . '">';
		foreach ( $post_event_ids as $id ) {
			$date_event = get_post_meta( $id, 'easy_event_date_start', true );
			$date_event = date_create()->createFromFormat(
				$date_format,
				$date_event
			);

			echo '<li data-date="' . get_post_meta( $id, 'easy_event_date_start', true ) . '">
					<div class="left">
						<span class="day">' . $date_event->format( 'd' ) . '</span>
						<span class="moth">' . $date_event->format( 'M' ) . '</span>
					</div>
					<a href="'
			     . esc_url( get_permalink( $id ) ) . '" title="'
			     . esc_attr( get_the_title( $id ) ) . '">'
			     . get_the_title( $id ) . '</a>
				</li>';
		}
		echo '</ul>';
		echo '</div>';
	}

	/**
	 * Register script
	 */
	wp_enqueue_script(
		'jquery-vticker',
		EASY_EVENT_URI . '/assets/js/jquery.vticker.min.js', array( 'jquery' ), EASY_EVENT_VERSION
	);
	wp_enqueue_script(
		'easy-event',
		EASY_EVENT_URI . '/assets/js/easy-event.js',
		array( 'jquery', 'jquery-vticker' ),
		EASY_EVENT_VERSION
	);

	wp_enqueue_style( 'easy_event', EASY_EVENT_URI . '/assets/css/style.min.css', array(), EASY_EVENT_VERSION );
}

function easy_event_get_time( $post_id ) {
	$args = array(
		'type' => 'date',
	);
	$date = rwmb_meta( 'easy_event_date_start', $args, $post_id );

	return $date;
}