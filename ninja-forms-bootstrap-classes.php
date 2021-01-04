<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;}

/*
 * Plugin Name: Ninja Forms - Bootstrap classes
 * Plugin URI:
 * Description: Add bootstrap classes to your forms
 * Version: 3.0.0
 * Author: Tom Broucke
 * Author URI: https://tombroucke.be
 * Text Domain: ninja-forms-bootstrap-classes
 *
 * Copyright 2020 Tom Broucke.
 */

if ( version_compare( get_option( 'ninja_forms_version', '0.0.0' ), '3', '<' ) || get_option( 'ninja_forms_load_deprecated', false ) ) {

	// include 'deprecated/ninja-forms-bootstrap-classes.php';

} else {

	/**
	 * Class NF_BootstrapClasses
	 */
	final class NF_BootstrapClasses {

		const VERSION = '0.0.1';
		const SLUG    = 'bootstrap-classes';
		const NAME    = 'Bootstrap classes';
		const AUTHOR  = 'Tom Broucke';
		const PREFIX  = 'NF_BootstrapClasses';

		/**
		 * @var NF_BootstrapClasses
		 * @since 3.0
		 */
		private static $instance;

		/**
		 * Plugin Directory
		 *
		 * @since 3.0
		 * @var string $dir
		 */
		public static $dir = '';

		/**
		 * Plugin URL
		 *
		 * @since 3.0
		 * @var string $url
		 */
		public static $url = '';

		/**
		 * Main Plugin Instance
		 *
		 * Insures that only one instance of a plugin class exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 3.0
		 * @static
		 * @static var array $instance
		 * @return NF_BootstrapClasses Highlander Instance
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof NF_BootstrapClasses ) ) {
				self::$instance = new NF_BootstrapClasses();

				self::$dir = plugin_dir_path( __FILE__ );

				self::$url = plugin_dir_url( __FILE__ );
			}

			return self::$instance;
		}

		public function __construct() {
			/*
			 * Required for all Extensions.
			 */
			add_action( 'admin_init', array( $this, 'setup_license' ) );

			add_filter( 'ninja_forms_localize_field_textarea', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_textbox', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_email', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_phone', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_number', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_password', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_listcountry', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_listselect', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_city', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_address', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_firstname', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_lastname', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_date', array( $this, 'add_form_control_class' ) );
			add_filter( 'ninja_forms_localize_field_zip', array( $this, 'add_form_control_class' ) );

			add_filter( 'ninja_forms_localize_field_submit', array( $this, 'add_btn_class' ) );

			add_filter( 'ninja_forms_field_template_file_paths', array( $this, 'custom_template_file_path' ) );
		}

		public function add_form_control_class( $field ) {
			$field['settings']['container_class'] = $field['settings']['container_class'] . ' form-group';
			$field['settings']['element_class']   = $field['settings']['element_class'] . ' form-control';
			return $field;
		}

		public function add_btn_class( $field ) {
			$field['settings']['container_class'] = $field['settings']['container_class'] . ' form-group';
			$field['settings']['element_class']   = $field['settings']['element_class'] . ' btn btn-primary';
			return $field;
		}

		public function custom_template_file_path( $paths ) {
			array_unshift( $paths, self::$dir . 'templates/' );
			return $paths;
		}

		/**
		 * Template
		 *
		 * @param string $file_name
		 * @param array  $data
		 */
		public static function template( $file_name = '', array $data = array() ) {
			if ( ! $file_name ) {
				return;
			}

			extract( $data );

			include self::$dir . 'includes/Templates/' . $file_name;
		}

		/**
		 * Config
		 *
		 * @param $file_name
		 * @return mixed
		 */
		public static function config( $file_name ) {
			return include self::$dir . 'includes/Config/' . $file_name . '.php';
		}

		/*
		 * Required methods for all extension.
		 */

		public function setup_license() {
			if ( ! class_exists( 'NF_Extension_Updater' ) ) {
				return;
			}

			new NF_Extension_Updater( self::NAME, self::VERSION, self::AUTHOR, __FILE__, self::SLUG );
		}
	}

	/**
	 * The main function responsible for returning The Highlander Plugin
	 * Instance to functions everywhere.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * @since 3.0
	 * @return {class} Highlander Instance
	 */
	function NF_BootstrapClasses() {
		return NF_BootstrapClasses::instance();
	}

	NF_BootstrapClasses();
}
