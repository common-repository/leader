<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://webcontrol.co.il
 * @since      1.0.0
 *
 * @package    Leader
 * @subpackage Leader/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Leader
 * @subpackage Leader/public
 * @author     Ram Segev<ramsegeb@gmail.com>
 */
class Leader_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Leader_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Leader_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/leader-public.css', array(), $this->version, 'all' );
		if(is_rtl()){
				wp_register_style( 'leader-rtl', plugin_dir_url( __FILE__ ) . 'css/leader-public-rtl.css' , array(), $this->version, 'all');
				wp_enqueue_style('leader-rtl');
			}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Leader_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Leader_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/leader-public.js', array( 'jquery' ), $this->version, true );
		$translation_array = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'contact_form' => esc_html__('Contact Form', $this->plugin_name),
				'hello' => esc_html__('Leader Hello Bar', $this->plugin_name),
				'form' => esc_html__('Leader Contact Form', $this->plugin_name),
				'assistent' => esc_html__('Leader Personal Assistent', $this->plugin_name),
				'video' => esc_html__('Leader Video Popup', $this->plugin_name),
				'new_message' => esc_html__('New message', $this->plugin_name),
				'email_erorr' => esc_html__('Please enter a valid email', $this->plugin_name),
				'phone_erorr' => esc_html__('Please enter a valid phone number', $this->plugin_name),
				'required' => esc_html__('Required', $this->plugin_name),
				'hellobar' => esc_html_x( 'Hello Bar', 'Leader taxonomies', $this->plugin_name ),
				'form' => esc_html_x( 'Contact Form', 'Leader taxonomies', $this->plugin_name ),
				'otherforms' => esc_html_x( 'Other Form', 'Leader taxonomies', $this->plugin_name ),																		
				'videopop' => esc_html_x( 'Video Popup', 'Leader taxonomies', $this->plugin_name ),
				'sendHB' => esc_html_x( 'SEND', 'Leader Hello Bar Settings', $this->plugin_name ),
				'sendVP' => esc_html_x( 'SEND', 'Leader Video Popup Settings', $this->plugin_name ),
			);
		wp_localize_script( $this->plugin_name, 'lr_ajax', $translation_array );

	}
 
}
