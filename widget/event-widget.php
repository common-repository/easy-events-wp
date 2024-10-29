<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 13/10/2015
 * Time: 4:11 PM
 */

/**
 * Class Easy_Event_Widget widget.
 */
class Easy_Event_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Easy_Event_Widget', // Base ID
			__( 'Upcoming Events', 'easy_event' ), // Name
			array(
				'description' => __( 'Upcoming Events, Widget just shows upcoming events.', 'easy_event' ),
			)
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters(
					'widget_title',
					$instance['title']
				) . $args['after_title'];
		}
		if ( ! empty( $instance['per_page'] ) ) {
			$show = $instance['per_page'];
		} else {
			$show = 5;
		}
		easy_event_upcoming_loop_to_widget( $show );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @return string
	 */
	public function form( $instance ) {
		$title    = ! empty( $instance['title'] ) ? $instance['title']
			: __( 'Upcoming events', 'easy_event' );
		$per_page = ! empty( $instance['per_page'] ) ? $instance['per_page']
			: 5;
		?>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat"
			       id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>"
			       type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'per_page' ); ?>"><?php _e( 'Number event per page:' ); ?></label>
			<input class="widefat"
			       id="<?php echo $this->get_field_id( 'per_page' ); ?>"
			       name="<?php echo $this->get_field_name( 'per_page' ); ?>"
			       type="number" value="<?php echo esc_attr( $per_page ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) )
			? strip_tags( $new_instance['title'] ) : '';
		$instance['per_page'] = ( ! empty( $new_instance['per_page'] ) )
			? strip_tags( $new_instance['per_page'] ) : '';

		return $instance;
	}

} // class Easy_Event_Widget

register_widget( 'Easy_Event_Widget' );