<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://leader.codes
 * @since      1.0.0
 *
 * @package    Leader
 * @subpackage Leader/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Leader
 * @subpackage Leader/includes
 * @author     Ram Segev<ramsegeb@gmail.com>
 */
class Leader {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Leader_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'leader';
		$this->version = '2.6.1';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_Leader_API_hooks();
		//$this->define_POP3_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Leader_Loader. Orchestrates the hooks of the plugin.
	 * - Leader_i18n. Defines internationalization functionality.
	 * - Leader_Admin. Defines all hooks for the admin area.
	 * - Leader_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-leader-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-leader-i18n.php';
		/**
		 * The class responsible for defining API functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-leader-api.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-leader-admin.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-leader-public.php';
		/**
		 * The class responsible for defining all actions that occur in the mailing functionality
		 * for the site.
		 */
		require_once(ABSPATH . 'wp-admin/includes/screen.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$this->loader = new Leader_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Leader_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Leader_i18n();
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'lr_load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Leader_Admin( $this->get_plugin_name(), $this->get_version() );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 20, 1);
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'add_plugin_admin_bar_menu', 99);
		$this->loader->add_filter( 'plugin_action_links', $plugin_admin, 'lr_add_action_plugin', 10, 5 );
		$this->loader->add_action( 'init', $plugin_admin,'register_custom_post_type');
		$this->loader->add_filter( 'init', $plugin_admin, 'register_lr_taxonomy');
		$this->loader->add_filter( 'init', $plugin_admin,'register_mesages_meta_boxes');
		$this->loader->add_filter( 'init', $plugin_admin,'register_meta_boxes');
		$this->loader->add_filter( 'init', $plugin_admin,'register_socials_meta_boxes');
		$this->loader->add_filter( 'manage_edit-leader_columns', $plugin_admin, 'set_table_columns');
		$this->loader->add_filter( 'manage_edit-leader_columns', $plugin_admin, 'reorder_leader_column');
		$this->loader->add_action( 'manage_leader_posts_custom_column', $plugin_admin, 'output_table_columns_data', 10, 2 );
		$this->loader->add_filter( 'manage_edit-leader_sortable_columns', $plugin_admin, 'define_sortable_table_columns' );
		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'extend_admin_search');
		if ( is_admin() ) {
			$this->loader->add_filter( 'posts_join', $plugin_admin, 'leader_post_search_join' );
			$this->loader->add_filter( 'posts_where', $plugin_admin, 'leader_leads_search_where' );
			$this->loader->add_filter( 'posts_groupby', $plugin_admin, 'leader_search_groupby' );

		}		
		$this->loader->add_action( 'init', $plugin_admin,'lr_email_send');
		$this->loader->add_action('wp_mail_failed', $plugin_admin,'log_mailer_errors', 10, 1);	
		$this->loader->add_action('wp_ajax_lr_save_wm_set', $plugin_admin,'lr_save_wm_set', 10, 1);	
		$this->loader->add_action('wp_ajax_lr_save_engaging_set', $plugin_admin,'lr_save_engaging_set', 10, 1);	
		$this->loader->add_action( 'init', $plugin_admin,'get_general_settings', 10, 1);	
		$this->loader->add_action( 'init', $plugin_admin,'get_position_settings', 10, 1);	
		$this->loader->add_action( 'init', $plugin_admin,'get_design_settings', 10, 1);	
		$this->loader->add_action( 'init', $plugin_admin,'get_welcome_mail', 10, 1);	
		$this->loader->add_action( 'admin_notices', $plugin_admin,'lr_admin_notice', 10, 1);	
		
	}
	/**
	 * Register all of the hooks related to the mail chimp area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_Leader_API_hooks() {
		$plugin_api = new Leader_API( $this->get_plugin_name(), $this->get_version() );
		//$this->loader->add_action( 'admin_init ', $plugin_api,'lr_creat_meta_box');				
		$this->loader->add_action( 'init ', $plugin_api,'objToArray');
		$this->loader->add_filter( 'pre_insert_term ', $plugin_api,'add_taxonomy');				
		$this->loader->add_action( 'add_meta_boxes', $plugin_api,'register_lr_meta_boxes');
		$this->loader->add_action( 'wp_ajax_lr_save_wave', $plugin_api,'lr_save_wave');		
		$this->loader->add_action( 'wp_ajax_get_leader_wave_list', $plugin_api,'get_leader_wave_list');		
		$this->loader->add_action( 'wp_ajax_update_user_wave', $plugin_api,'update_user_wave');	
		$this->loader->add_action( 'admin_init ', $plugin_api,'lr_welcome_mail', 10, 2);			
		$this->loader->add_action( 'wp_ajax_nopriv_update_user_wave', $plugin_api,'update_user_wave');		
		$this->loader->add_action( 'save_post', $plugin_api,'save_meta_boxes');			
		$this->loader->add_action( 'wp_trash_post', $plugin_api,'delete_from_duplicated_list');	
		$this->loader->add_filter( 'wp_insert_post_data', $plugin_api,'filter_post_data', 99, 2);	
		$this->loader->add_action('wp_mail_failed', $plugin_api,'log_mailer_errors', 10, 1);		
		$this->loader->add_action( 'wp_ajax_upload_file', $plugin_api,'upload_file');
		$this->loader->add_action( 'admin_init ', $plugin_api,'lr_creat_hooks');				

	}
	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Leader_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts',1,1 );
	}
	
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Leader_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
