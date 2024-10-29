<?php

function easy_event_settings_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Event WP', 'easy_event' ); ?></h1>

		<form method="post" action="options.php">
			<?php
			settings_fields( 'ee_section' );
			do_settings_sections( 'easy-event-options' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

function easy_event_add_theme_menu_item() {
	add_submenu_page( 'edit.php?post_type=easy_event', esc_html__( 'Setting', 'easy_event' ), esc_html__( 'Setting', 'easy_event' ), 'manage_options', 'easy-event-setting', 'easy_event_settings_page' );
}

add_action( 'admin_menu', 'easy_event_add_theme_menu_item' );


/**
 * Input Single Content Template
 */
function easy_event_display_input_content_template() {
	$single_template = get_option( 'easy_event_single_template' );
	if ( $single_template == '' || $single_template == false ) {
		$single_template = file_get_contents( EASY_EVENT_DIR . '/templates-default/single-content.php' );
	}

	?>
	<textarea name="easy_event_single_template" id="easy_event_single_template" cols="100" rows="10"><?php echo $single_template; ?></textarea>
	<?php
}

/**
 * Input excerpt length
 */
function easy_event_display_input_excerpt_length() {
	$excerpt_length = get_option( 'easy_event_excerpt_length' );
	if ( $excerpt_length == false ) {
		$excerpt_length = 250;
	}

	?>
	<input type="number" name="easy_event_excerpt_length" id="easy_event_excerpt_length" value="<?php echo esc_attr( $excerpt_length ); ?>">
	<?php
}

function easy_event_display_theme_panel_fields() {
	add_settings_section( 'ee_section', 'All Settings', null, 'easy-event-options' );

	add_settings_field( 'easy_event_single_template', esc_html__( 'Content Template', 'easy_event' ), 'easy_event_display_input_content_template', 'easy-event-options', 'ee_section' );
	register_setting( 'ee_section', 'easy_event_single_template' );

	add_settings_field( 'easy_event_excerpt_length', esc_html__( 'Excerpt Length', 'easy_event' ), 'easy_event_display_input_excerpt_length', 'easy-event-options', 'ee_section' );
	register_setting( 'ee_section', 'easy_event_excerpt_length' );
}

add_action( 'admin_init', 'easy_event_display_theme_panel_fields' );