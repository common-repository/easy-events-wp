<?php

/**
 * Plugin Name: Event WP
 * Plugin URI: https://thimpress.com
 * Description: Best simple and useful WordPress Event Plugin.
 * Version: 2.0.0
 * Author: ThimPress
 * Author URI: https://thimpress.com
 * Requires at least: 4.6
 * Tested up to: 4.7.1
 *
 * Text Domain: easy_event
 *
 * @package  Easy_Event
 * @author   WPArena
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'EASY_EVENT_URI', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
define( 'EASY_EVENT_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'EASY_EVENT_VERSION', '2.0.0' );

if ( ! class_exists( 'Easy_Event' ) ) :

	class Easy_Event {
		/**
		 * Easy_Event constructor.
		 */
		function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'admin_init', array( $this, 'admin' ) );
			add_action( 'widgets_init', array( $this, 'widget' ) );
			add_action( 'activated_plugin', array( $this, 'install' ) );

			$this->enqueue();
		}

		/**
		 * Install
		 */
		public function install() {
			$content = file_get_contents( EASY_EVENT_DIR . '/templates-default/single-content.php' );
			update_option( 'easy_event_single_template', $content );
			update_option( 'easy_event_excerpt_length', 250 );
		}

		/**
		 * Init Easy Events
		 */
		public function init() {
			do_action( 'before_easy_event_init' );

			$this->libraries();
			$this->includes();
			$this->template_builder();

			do_action( 'easy_event_init' );
		}

		/**
		 * Include libraries
		 */
		public function libraries() {
		}

		/**
		 * Include libraries in admin area
		 */
		public function admin() {

		}

		/**
		 * Include required core
		 */
		public function includes() {
			require_once 'includes/event-post-type.php';
			require_once 'includes/metabox.php';
			require_once 'functions.php';
			require_once 'includes/setting-admin.php';
		}

		/**
		 * Template builder
		 */
		public function template_builder() {
			require_once 'template-builder/single.php';
		}

		/**
		 * Include Widgets
		 */
		public function widget() {
			require_once 'widget/functions.php';
			require_once 'widget/event-widget.php';
		}

		public function enqueue() {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		}

		public function admin_enqueue_scripts() {
			wp_enqueue_style( 'easy_event_admin', EASY_EVENT_URI . '/assets/css/admin/style.css', array(), EASY_EVENT_VERSION );
			wp_enqueue_style( 'easy_event_datetimepicker', EASY_EVENT_URI . '/assets/css/admin/jquery.datetimepicker.css', array(), '2.5.3' );
			wp_enqueue_script( 'easy_event_datetimepicker', EASY_EVENT_URI . '/assets/js/jquery.datetimepicker.full.min.js', array( 'jquery' ), '2.5.3', true );
			wp_enqueue_script( 'easy_event_admin', EASY_EVENT_URI . '/assets/js/admin.js', array( 'jquery', 'easy_event_datetimepicker' ), EASY_EVENT_VERSION, true );
		}
	}

endif;

$easy_events = new Easy_Event();