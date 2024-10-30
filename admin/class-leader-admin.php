<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://leader.codes
 * @since      1.0.0
 *
 * @package    Leader
 * @subpackage Leader/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Leader
 * @subpackage Leader/admin
 * @author     Ram Segev <ramsegev@gmail.com>
 */
class Leader_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	 
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->api = new Leader_API($plugin_name, $version );
		$this->member_details = array();
		$this->plugin_location = plugin_dir_url(dirname(__FILE__));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {
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
		 $screen = get_current_screen();
		 $post_type = get_post_type();
		 $leader_screan = strpos($screen->id, "leader_page");
		if(($post_type === $this->plugin_name) || ($leader_screan !== false) || ($screen->id == "edit-leader")){
			wp_register_style( 'material-icons', '//fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons' , array(), null, 'all');
			wp_enqueue_style( 'material-icons' );
			wp_register_style( 'font-awesom-css', '//use.fontawesome.com/releases/v5.1.0/css/all.css' , array(), null, 'all');
			wp_enqueue_style( 'font-awesom-css' );
			wp_register_style( 'material-dashboard', plugin_dir_url( __FILE__ ) . 'css/material-dashboard.css', array(), null, 'all');
			wp_enqueue_style( 'material-dashboard' );
			wp_register_style( 'animate', plugin_dir_url( __FILE__ ) . 'css/animate.min.css', array(), null, 'all');
			wp_enqueue_style( 'animate' );
			wp_register_style( 'minicolors.css', plugin_dir_url( __FILE__ ) . 'css/jquery.minicolors.css', array(), null, 'all');
			wp_enqueue_style( 'minicolors.css' );
			wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/leader-admin.css' , array(), $this->version, 'all');
			wp_enqueue_style($this->plugin_name);
			if(is_rtl()){
				wp_register_style( 'leader-rtl', plugin_dir_url( __FILE__ ) . 'css/leader-admin-rtl.css' , array(), null, 'all');
				wp_enqueue_style('leader-rtl');
			}
		}
	}
	
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

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
		$screen = get_current_screen();
		$post_type = get_post_type();
		$leader_screan = strpos($screen->id, "leader_page");
		if(($post_type === $this->plugin_name) || ($leader_screan !== false)){

			$handler = 'jquery';	
			wp_register_script('popper', plugin_dir_url( __FILE__ ) . 'js/plugins/popper.js',array($handler),null, true);
			wp_enqueue_script('popper'); 
			wp_register_script('bootstrap-material-design', plugin_dir_url( __FILE__ ) . 'js/plugins/bootstrap-material-design.js',array('jquery'), null, true);
			wp_enqueue_script('bootstrap-material-design');
			wp_register_script('perfect-scrollbar-jquery',plugin_dir_url( __FILE__ ) . 'js/plugins/perfect-scrollbar.jquery.min.js',array( $handler), null, true);
			wp_enqueue_script('perfect-scrollbar-jquery');
			//Google Maps Plugin
			//Plugin for Date Time Picker and Full Calendar Plugin
			wp_register_script('moment-min', plugin_dir_url( __FILE__ ) . 'js/plugins/moment.min.js',array( $handler), null, true);
			wp_enqueue_script('moment-min');
			//Plugin for Tags
			wp_register_script('bootstrap-tagsinput', plugin_dir_url( __FILE__ ) . 'js/plugins/bootstrap-tagsinput.js',array( $handler), null, true);
			wp_enqueue_script('bootstrap-tagsinput');
			//Plugin for Fileupload
			wp_register_script('jasny-bootstrap', plugin_dir_url( __FILE__ ) . 'js/plugins/jasny-bootstrap.min.js',array( $handler), null, true);
			wp_enqueue_script('jasny-bootstrap');
			//Plugins for presentation and navigation
			wp_register_script('modernizr', plugin_dir_url( __FILE__ ) . 'js/modernizr.js',array( $handler), null, true);
			wp_enqueue_script('modernizr');
			//Material Dashboard Core initialisations of plugins and Bootstrap Material Design Library
			wp_register_script('material-dashboard', plugin_dir_url( __FILE__ ) .  'js/material-dashboard.js',array($handler), '2.0.1', true);
			wp_enqueue_script('material-dashboard');
			//Dashboard scripts
			//Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert
			wp_register_script('core.js', plugin_dir_url( __FILE__ ) . 'js/plugins/core.js',array($handler),'2.4.1', true);
			wp_enqueue_script('core.js'); 
			//Library for adding dinamically elements
			wp_register_script('arrive', plugin_dir_url( __FILE__ ) . 'js/plugins/arrive.min.js',array( $handler), null, true);
			wp_enqueue_script('arrive');
			//Forms Validations Plugin
			wp_register_script('validate', plugin_dir_url( __FILE__ ) . 'js/plugins/jquery.validate.min.js',array($handler), null, true);
			wp_enqueue_script('validate');
			//Plugin for the Wizard
			wp_register_script('bootstrap-wizard', plugin_dir_url( __FILE__ ) . 'js/plugins/jquery.bootstrap-wizard.js',array($handler), null, true);
			wp_enqueue_script('bootstrap-wizard');
			//Notifications Plugin
			wp_register_script('bootstrap-notify', plugin_dir_url( __FILE__ ) . 'js/plugins/bootstrap-notify.js',array($handler), null, true);
			wp_enqueue_script('bootstrap-notify');
			//Sliders Plugin
			wp_register_script('nouislider', plugin_dir_url( __FILE__ ) . 'js/plugins/nouislider.min.js',array($handler), null, true);
			wp_enqueue_script('nouislider');
			//Plugin for Select
			wp_register_script('select-bootstrap', plugin_dir_url( __FILE__ ) . 'js/plugins/jquery.select-bootstrap.js',array($handler), null, true);
			wp_enqueue_script('select-bootstrap');
			//DataTables.net Plugin
			wp_register_script('datatables', plugin_dir_url( __FILE__ ) . 'js/plugins/jquery.datatables.js',array($handler), null, true);
			wp_enqueue_script('datatables');
			//Sweet Alert 2 plugin
			wp_register_script('sweetalert2', plugin_dir_url( __FILE__ ) . 'js/plugins/sweetalert2.all.js',array($handler), null, true);
			wp_enqueue_script('sweetalert2');
			wp_register_script('promise', plugin_dir_url( __FILE__ ) . 'js/plugins/promise.min.js',array($handler), null, true);
			wp_enqueue_script('promise');
			//Plugin for Fileupload
			wp_register_script('jasny-bootstrap', plugin_dir_url( __FILE__ ) . 'js/plugins/jasny-bootstrap.min.js',array($handler), null, true);
			wp_enqueue_script('jasny-bootstrap');
			//Full Calendar Plugin
			wp_register_script('fullcalendar', plugin_dir_url( __FILE__ ) . 'js/plugins/fullcalendar.min.js',array($handler), null, true);
			wp_enqueue_script('fullcalendar');
			//demo init
			wp_register_script('demo', plugin_dir_url( __FILE__ ) . 'js/plugins/demo.js',array('jquery'), null, true);
			wp_enqueue_script('demo'); 
			 //Plugin for the Sliders
			wp_register_script('nouislider', plugin_dir_url( __FILE__ ) . 'js/plugins/nouislider.min.js',array( $handler), null, true);
			wp_enqueue_script('nouislider');
			wp_register_script('minicolors', plugin_dir_url( __FILE__ ) . 'js/plugins/jquery.minicolors.js',array( $handler), null, true);
			wp_enqueue_script('minicolors');
			//Plugin for Select
			wp_register_script('bootstrap-selectpicker', plugin_dir_url( __FILE__ ) . 'js/plugins/bootstrap-selectpicker.js',array( $handler), null, true);
			wp_enqueue_script('bootstrap-selectpicker');
			wp_register_script('watch', plugin_dir_url( __FILE__ ) . 'js/plugins/watch.js',array( $handler),null, true);
			wp_enqueue_script('watch'); 	 	
			wp_register_script('leader-admin', plugin_dir_url( __FILE__ ) . 'js/leader-admin.js',array($handler), $this->version, true);
			wp_enqueue_media();
			wp_enqueue_script('leader-admin');
			$translation_array_demo = array(
			'success_saving_wm' => esc_html__('Success!<br> Your welcome email<br> is ready', $this->plugin_name),
			'error_saving_wm' => esc_html__('Oh no! something went wrong<br> Please try again later', $this->plugin_name),
			'success_saving_engaging' => esc_html__('Success!<br> Your Digital Signature<br> is saved', $this->plugin_name),
			'error_saving_engaging' => esc_html__('Oh no! something went wrong<br> Please try again later', $this->plugin_name),
			'error_saving_engaging' => esc_html__('Oh no! something went wrong<br> Please try again later', $this->plugin_name),
			'error' => esc_html__('Oh no! something went wrong<br> Please try again later', $this->plugin_name),
			);
			wp_localize_script('demo', 'popup_notification', $translation_array_demo);
			$translation_array = array(
				'name' => $this->plugin_name,
				'open' => esc_html__('Open', $this->plugin_name),
				'closed' => esc_html__('Closed', $this->plugin_name),
				'on_hold' => esc_html__('On hold', $this->plugin_name),
				'reply' => esc_html__('Reply', $this->plugin_name),
				'forward' => esc_html__('Forward', $this->plugin_name),
				'email_to' => esc_html__('Email to:', $this->plugin_name),
				'status' => esc_html__('Status', $this->plugin_name),
				'send' => esc_html__('Mail it', $this->plugin_name),
			);
			wp_localize_script('leader-admin', 'leader_type', $translation_array );
		}
	}
	public function add_plugin_admin_menu() {
		add_submenu_page( 'edit.php?post_type=leader', $this->plugin_name, esc_html_x( 'Welcome Mail','admin menu',$this->plugin_name), 'manage_options', 'leader_welcoming', array($this, 'display_leader_welcoming'));
		add_submenu_page( 'edit.php?post_type=leader', $this->plugin_name, esc_html_x( 'Social Signature','admin menu',$this->plugin_name), 'manage_options', 'leader_engaging', array($this, 'display_leader_engaging'));
		remove_submenu_page( 'edit.php?post_type=leader', 'edit-tags.php?taxonomy=lr_categories&amp;post_type=leader' );
	}
	public function display_leader_welcoming(){
        include_once(plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/leader-welcoming.php');
	}
	public function display_leader_engaging(){
        include_once(plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/leader-engaging.php');
	}
	public function add_plugin_admin_bar_menu($wp_admin_bar){
		if ( !is_super_admin() || !is_admin_bar_showing() )
		return;
		$wp_admin_bar->add_menu( array(
			'id' => $this->plugin_name,
			'title' => esc_html_x( 'Leader', 'post type singular name', $this->plugin_name ),
			'href' => get_site_url().'/wp-admin/edit.php?post_type=leader',
			'meta'   => array(
			'class' => 'lr-wp-admin-bar',),
		) );
		$wp_admin_bar->add_menu( array(
			'parent' => $this->plugin_name,
			'id'     => 'leader_crm',
			'title' =>esc_html__( 'Leader Box', $this->plugin_name, $this->plugin_name ),
			'href' => get_site_url().'/wp-admin/edit.php?post_type=leader',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => $this->plugin_name,
			'id'     => 'leader_add_new',
			'title' =>esc_html__( 'Add New Leader', $this->plugin_name, $this->plugin_name ),
			'href' => get_site_url().'/wp-admin/post-new.php?post_type=leader',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => $this->plugin_name,
			'id'     => 'leader_welcoming',
			'title' => esc_html_x( 'Welcome Mail','admin menu',$this->plugin_name),
			'href' => get_site_url().'/wp-admin/edit.php?post_type=leader&page=leader_welcoming',
		));
		$wp_admin_bar->add_menu( array(
			'parent' => $this->plugin_name,
			'id'     => 'leader_engaging',
			'title' => esc_html_x( 'Social Signature','admin menu',$this->plugin_name),
			'href' => get_site_url().'/wp-admin/edit.php?post_type=leader&page=leader_engaging',
		));
	}
	
	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function lr_add_action_plugin( $actions, $plugin_file ) 
	{
		static $plugin;
		if (!isset($plugin))
			$plugin = 'leader/leader.php';
		if ($plugin == $plugin_file) {

				$leader_welcoming = array('Leader Welcome' => '<a href="' . admin_url( "admin.php?page=leader_welcoming").'">' . __('Leader Welcome', 'General') . '</a>');
				$leader_engaging = array('Leader Signature' => '<a href="' . admin_url( "admin.php?page=leader_engaging").'">' . __('Leader Signature', 'General') . '</a>');
				$site_link = array('support' => '<a href="https://wordpress.org/support/plugin/leader" target="_blank">' . __('Support', 'General') . '</a>');
			
					$actions = array_merge($leader_welcoming, $actions);
					$actions = array_merge($leader_engaging, $actions);
					$actions = array_merge($site_link, $actions);
				
			}			
			return $actions;
	}
	/**
	 * Registers a Custom Post Type called leader
	 */
	
	public function register_custom_post_type() {
		register_post_type( $this->plugin_name, array(
			'labels' => array(
				'name'               => esc_html_x( 'Leader Box', 'post type general name', $this->plugin_name ),
				'singular_name'      => esc_html_x( 'Leader', 'post type singular name', $this->plugin_name ),
				'menu_name'          => esc_html_x( 'Leader', 'admin menu', $this->plugin_name ),
				'name_admin_bar'     => esc_html_x( 'Leader', 'add new on admin bar', $this->plugin_name ),
				'add_new'            => esc_html__( 'Add New Leader', $this->plugin_name, $this->plugin_name ),
				'add_new_item'       => esc_html__( 'Add New Leader', $this->plugin_name ),
				'new_item'           => esc_html__( 'New Leader' ),
				'edit_item'          => esc_html__( 'Edit Leader', $this->plugin_name ),
				'view_item'          => esc_html__( 'View Leader', $this->plugin_name ),
				'all_items'          => esc_html__( 'Leader Box', $this->plugin_name ),
				'search_items'       => esc_html__( 'Search Leaders', $this->plugin_name ),
				'parent_item_colon'  => esc_html__( 'Parent Leaders:', $this->plugin_name ),
				'not_found'          => esc_html__( 'No leaders found.', $this->plugin_name ),
				'not_found_in_trash' => esc_html__( 'No leaders found in Trash.', $this->plugin_name ),
			),
			 
			// Frontend
			'has_archive'        => true,
			'public'             => false,
			'publicly_queryable' => false,
			 
			// Admin
			'capability_type' => 'post',
			//'menu_icon'     => 'dashicons-businessman',
			'menu_icon'     => plugin_dir_url( __FILE__ ) . '/images/leader-avater15X15.png',
			'menu_position' => 10,
			'query_var'     => true,
			'show_in_menu'  => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'show_ui'       => true,
			'rewrite' =>array( 'slug' => $this->plugin_name, 'with_front' => false ),
			'supports'      => array(
				'title',
				'author' =>false,
				'comments' => false,
				'revisions' => true,
			),
			'can_export' => true,
			'taxonomies' => array('lr_categories'),
			
		));
	}
		/** 
	 * Registers a Custom Post Type taxonomy called lr_categories
	 */
	public function register_lr_taxonomy() {  

		$labels = array(
			'name'              => esc_html_x( 'Leader category', 'taxonomy general name', $this->plugin_name ),
			'singular_name'     => esc_html_x( 'Leader category', 'taxonomy singular name', $this->plugin_name ),
			'search_items'      => esc_html__( 'Search Leader categories', $this->plugin_name ),
			'all_items'         => esc_html__( 'All Leader categories', $this->plugin_name ),
			'parent_item'       => esc_html__( 'Parent Leader category', $this->plugin_name ),
			'parent_item_colon' => esc_html__( 'Parent Leader category:', $this->plugin_name ),
			'edit_item'         => esc_html__( 'Edit Leader categories', $this->plugin_name ),
			'update_item'       => esc_html__( 'Update Leader categories', $this->plugin_name ),
			'add_new_item'      => esc_html__( 'Add New Leader categories', $this->plugin_name ),
			'new_item_name'     => esc_html__( 'New Lead Leader categories', $this->plugin_name ),
			'menu_name'         => esc_html__( 'Leader categories', $this->plugin_name ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => $this->plugin_name, 'with_front' => false ),
            'show_count'      =>  true, // Show # listings in parens
		);

		register_taxonomy( 'lr_categories', $this->plugin_name , $args );
	}  
	/**
	* Registers a Meta Box on our Lead Custom Post Type, called 'Lead Details'
	*/
	public function user_add_meta_box($lr_args){
		$title = '';
		if(isset($lr_args['id'])){
			$this->api->lr_creat_meta_box($lr_args);
		}
		if(isset($_GET['metaBoxTitle'])){
			$title = sanitize_text_field($_GET['metaBoxTitle']);
			$id  = str_replace(' ', '-', $title);
			$args = array(
				'id' => 'lr_' .$id,
				'options' =>array(
					'id' => 'lr_' .$id,
					'title' => $title,
					'context' => 'normal',
					'priority' => 'core',
					'category_title' =>$title,
					'category_slug' => 'lr_taxonomy_'. $title,
				),
				
			);
			$this->api->lr_creat_meta_box($args);
			wp_die('');
		} 		
	}
	public function register_meta_boxes() {
		$field_bs_col_4 = 'col-md-4';
		$field_bs_col_12 = 'col-md-12';
		$args =array(
			'id' => 'main-leader-box',
			'options' => array(
				'id' => 'main-leader-box',
				'title' => esc_html__('Edit Leader', $this->plugin_name),
				'context' => 'normal',
				'priority' => 'high',
				'category_title' =>'Main Leader Box',
				'category_slug' => 'lr-main-leader-box',
				'meta_box_class' => 'far fa-address-card fa-2x',
				'lr_email' => array(
						'field_title' => esc_html__(' Email address', $this->plugin_name),
						'field_type' => 'email',
						'filed_icon' => 'fas fa-at',
						'filed_meta' => 'lr_email',
						'field_class' => 'form-control lr-email lr-check-mail',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_full_name' => array(
						'field_title' => esc_html__(' Full name', $this->plugin_name),
						'field_type' => 'text',
						'filed_icon' => 'fas fa-user-circle',
						'filed_meta' => 'lr_full_name',
						'field_class' => 'form-control lr-full-name',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_birthday' => array(
						'field_title' => esc_html__(' Birthday', $this->plugin_name),
						'field_type' => 'date',
						'filed_icon' => 'fas fa-birthday-cake',
						'filed_meta' => 'lr_birthday',
						'field_class' => 'form-control lr-birthday',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_phone_number' => array(
						'field_title' => esc_html__(' Telephone', $this->plugin_name),
						'field_type' => 'tel',
						'filed_icon' => 'fas fa-phone-square',
						'filed_meta' => 'lr_phone_number',
						'field_class' => 'form-control lr-phone-number',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_mobile_number' => array(
						'field_title' => esc_html__(' Mobile', $this->plugin_name),
						'field_type' => 'tel',
						'filed_icon' => 'fas fa-mobile-alt',
						'filed_meta' => 'lr_mobile_number',
						'field_class' => 'form-control lr-mobile-number',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_website' => array(
						'field_title' => esc_html__(' Website', $this->plugin_name),
						'field_type' => 'url',
						'filed_icon' => 'fas fa-link',
						'filed_meta' => 'lr_website',
						'field_class' => 'form-control lr-website',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_city' => array(
						'field_title' => esc_html__(' City', $this->plugin_name),
						'field_type' => 'text',
						'filed_icon' => 'fas fa-university',
						'filed_meta' => 'lr_city',
						'field_class' => 'form-control lr-city',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_country' => array(
						'field_title' => esc_html__(' Country', $this->plugin_name),
						'field_type' => 'text',
						'filed_icon' => 'fas fa-globe',
						'filed_meta' => 'lr_country',
						'field_class' => 'form-control lr-country ',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_postal_code' => array(
						'field_title' => esc_html__(' Postal Code', $this->plugin_name),
						'field_type' => 'text',
						'filed_icon' => 'far fa-envelope',
						'filed_meta' => 'lr_postal_code',
						'field_class' => 'form-control lr-postal-code',
						'field_bs_col'=> $field_bs_col_4
					),
					'lr_address' => array(
						'field_title' => esc_html__(' Address', $this->plugin_name),
						'field_type' => 'textarea',
						'filed_icon' => 'far fa-map',
						'filed_meta' => 'lr_address',
						'field_class' => 'form-control lr-address',
						'field_bs_col'=> $field_bs_col_12
					),
					'lr_notes' => array(
						'field_title' => esc_html__(' Notes', $this->plugin_name),
						'field_type' => 'textarea',
						'filed_icon' => 'far fa-comment',
						'filed_meta' => 'lr_notes',
						'field_class' => 'form-control lr-notes',
						'field_bs_col'=> $field_bs_col_12
					),
			)
		);
		$this->user_add_meta_box($args);
	}
	public function register_mesages_meta_boxes() {
		$field_bs_col_12 = 'col-md-12';
		$args =array(
			'id' => 'lr_wave',
			'options' => array(
				'id' => 'lr_wave',
				'title' => esc_html__('Waves', $this->plugin_name),
				'context' => 'normal',
				'priority' => 'core',
				'category_title' =>esc_html__('Waves', 'Leader\'s status',$this->plugin_name),
				'category_slug' => 'lr-wave',
				'meta_box_class' => 'far fa-comments fa-2x lr-blue-background',
				'lr_wave_table' => array(
					'field_title' => esc_html__('Table', 'Leader Wave', $this->plugin_name),
					'field_type' => 'html',
					'filed_meta' => 'lr_wave_save',
					'field_value' => '
					<div class="table-responsive lr-wave-list">
					<table class="table">
						<thead>
						<tr>
							<th class="text-center">#</th>
							<th>'.esc_html_x('URL', 'Leader Wave', $this->plugin_name).'</th>
							<th>'.esc_html_x('Subject', 'Leader Wave', $this->plugin_name).'</th>
							<th>'.esc_html_x('Preview', 'Leader Wave', $this->plugin_name).'</th>
							<th class="text-right lr-wave-status">'.esc_html_x('Status', 'Leader Wave', $this->plugin_name).'</th>
							<th class="text-center">'.esc_html_x('Date', 'Leader Wave', $this->plugin_name).'</th>
							<th class="text-center">'.esc_html_x('Connection', 'Leader Wave', $this->plugin_name).'</th>
						</tr>
						</thead>
						<tbody class="waves_table">
						</tbody>
					</table>
				</div>',
				),
			)
		);
		$this->user_add_meta_box($args);
	}
	public function register_socials_meta_boxes() {
		$field_bs_col = 'col-md-12';
		$args =array(
			'id' => 'lr-social-presence',
			'options' => array(
				'id' => 'lr-social-presence',
				'title' => esc_html__('Connections', $this->plugin_name),
				'context' => 'side',
				'priority' => 'high',
				'category_title' =>'Social Presence',
				'category_slug' => 'lr-social-presence',
				'meta_box_class' => 'fas fa-link fa-2x',
				'lr_fb_address' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-facebook',
					'filed_meta' => 'lr_fb_address',
					'field_class'=> 'form-control lr-fb-address',
					'field_bs_col'=> $field_bs_col . ' lr-fb-area'
				),
				'lr_whatsapp_address' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-whatsapp',
					'filed_meta' => 'lr_wa_address',
					'field_class' => 'form-control lr-whatsapp-address',
					'field_bs_col'=> $field_bs_col
				),
				'lr_facebook_messenger_address' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-facebook-messenger',
					'filed_meta' => 'lr_facebook_messenger_address',
					'field_class' => 'form-control lr-facebook-messenger-address',
					'field_bs_col'=> $field_bs_col
				),
				'lr_linkedin_in' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-linkedin-in',
					'filed_meta' => 'lr_linkedin_in',
					'field_class' => 'form-control lr-linkedin-in',
					'field_bs_col'=> $field_bs_col
				),
				'lr_google_plus_g' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-google-plus-g',
					'filed_meta' => 'lr_google_plus_g',
					'field_class' => 'form-control lr-google-plus-g',
					'field_bs_col'=> $field_bs_col
				),
				'lr_fa_twitter' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-twitter',
					'filed_meta' => 'lr_fa_twitter',
					'field_class' => 'form-control  lr-fa-twitter',
					'field_bs_col'=> $field_bs_col
				),
				'lr_fa_youtube' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-youtube',
					'filed_meta' => 'lr_fa_youtube',
					'field_class' => 'form-control lr-fa-youtube',
					'field_bs_col'=> $field_bs_col
				),
				'lr_instegram_address' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-instagram',
					'filed_meta' => 'lr_instegram_address',
					'field_class' => 'form-control lr-instegram-address',
					'field_bs_col'=> $field_bs_col
				),
				'lr_snapchat_ghost' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-snapchat-ghost',
					'filed_meta' => 'lr_snapchat_ghost',
					'field_class' => 'form-control lr-snapchat-ghost ',
					'field_bs_col'=> $field_bs_col
				),
				'lr_fa_pinterest_p' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-pinterest-p',
					'filed_meta' => 'lr_fa_pinterest_p',
					'field_class' => 'form-control lr-fa-pinterest-p',
					'field_bs_col'=> $field_bs_col
				),
				'lr_fa_skype' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-skype',
					'filed_meta' => 'lr_fa_skype',
					'field_class' => 'form-control lr-fa-skype',
					'field_bs_col'=> $field_bs_col
				),
				'lr_telegram' => array(
					'field_title' => ' ',
					'field_type' => 'text',
					'filed_icon' => 'fab fa-telegram-plane',
					'filed_meta' => 'lr_telegram',
					'field_class' => 'form-control lr-telegram',
					'field_bs_col'=> $field_bs_col
				),
			)
		);
		$this->user_add_meta_box($args);
	}
	/**
	* Adds table columns to the Leads WP_List_Table
	*
	* @param array $columns Existing Columns
	* @return array New Columns
	*/
	public function set_table_columns( $columns ) {
		
		$columns['title'] = esc_html__( 'Leader', $this->plugin_name );
		$columns['email'] = esc_html__( 'Email Address', $this->plugin_name );
		$columns['mobile'] = esc_html__( 'Phone Number', $this->plugin_name );
		$columns['last_msg'] = esc_html__( 'Last Message', $this->plugin_name );
		$columns['photo'] = esc_html__( 'Photo', $this->plugin_name );
		 
		return $columns;
		 
	}
	public function reorder_leader_column($defaults) {  
		$new = array();
		$tags = $defaults['photo'];  // save the tags column
		foreach($defaults as $key=>$value) {
			if($key=='title') {  // when we find the date column
			   $new['photo'] = $defaults['photo'];  // put the tags column before it
			}  
			if($key=='date') {  // when we find the date column
			   $new['email'] = $defaults['email'];  // put the tags column before it
			   $new['mobile'] = $defaults['mobile'];  // put the tags column before it
			   $new['last_msg'] = $defaults['last_msg'];  // put the tags column before it
			} 
			$new[$key]=$value;
		}  

		return $new;  
	} 
	/* Outputs our Lead custom field data, based on the column requested
	*
	* @param string $columnName Column Key Name
	* @param int $post_id Post ID
	*/
	public function output_table_columns_data( $columnName, $post_id ) {
		$email = get_post_meta( $post_id, '_lr_email', true );
		$phone = get_post_meta( $post_id, '_lr_mobile_number', true );
		$timestamp = get_post_meta( $post_id, '_lr_last_correspond', true );
		$_lr_last_correspond = '';
		if(strlen($timestamp) > 0 ){
			$_lr_last_correspond = date_i18n( get_option('date_format'). ' H:i:s', $timestamp );
		}
		if ( 'email' == $columnName ) {
			echo $email;
		}
		else if ( 'mobile' == $columnName ) {
			echo $phone;
		}
		else if ( 'last_msg' == $columnName ) {
			echo $_lr_last_correspond;
		}
		else if ( 'photo' == $columnName ) {
			$photo = get_avatar( $email, 64 );
			echo $photo;
		} 
	}
	
	/**
	* Defines which Lead columsn are sortable
	*
	* @param array $columns Existing sortable columns
	* @return array New sortable columns
	*/
	public function define_sortable_table_columns( $columns ) {
	 
		$columns['email'] = '_lr_email';
		$columns['mobile'] = '_lr_mobile_number';
		$columns['last_msg'] = '_lr_last_correspond';
	 
		return $columns;
		 
	}
	/**
	* Inspect the request to see if we are on the Leads WP_List_Table and attempting to
	* sort by email address or phone number.  If so, amend the Posts query to sort by
	* that custom meta key
	*
	* @param array $vars Request Variables
	* @return array New Request Variables
	*/
	//function orderby_sortable_table_columns( $var ) {
	function orderby_sortable_table_columns( $vars ) {
		// Don't do anything if we are not on the leader Custom Post Type
		if ( $this->plugin_name != $vars['post_type'] ) return $vars;
     
		// Don't do anything if no orderby parameter is set
		if ( ! isset( $vars['orderby'] ) ) return $vars;
		 
		// Check if the orderby parameter matches one of our sortable columns
		if (  $vars['orderby'] == 'email' OR
			$vars['orderby'] == 'mobile' OR
			$vars['orderby'] == 'last_msg' ) {
			// Add orderby meta_value and meta_key parameters to the query
			$vars = array_merge( $vars, array(
				'meta_key' => $vars['orderby'],
				'orderby' => 'meta_value',
			));
		}
		 
		return $vars;
	}
	function extend_admin_search( $query ) {
		// Extend search for document post type
	 	$post_type = $this->plugin_name;
		// Custom fields to search for
		$custom_fields = array(
			"_lr_email",
			"_lr_mobile_number",
			"_lr_last_correspond",
		);

		if( ! is_admin() )
			return;
		$screen = get_current_screen();
		if((isset($screen->id)) && ($screen->id  == 'edit-leader')){
			$query->set( 'meta_key', '_lr_last_correspond' );
			$query->set( 'orderby', 'meta_value' );
		}else{
			return;
		}
		return $query;
	}
	/**
 * Join postmeta in admin post search
 *
 * @return string SQL join
 */
	public function leader_post_search_join( $join ){
		global $pagenow, $wpdb;
		if ( is_admin() && $pagenow == 'edit.php' && ! empty( $_GET['post_type'] ) && $_GET['post_type'] == $this->plugin_name && ! empty( $_GET['s'] ) ) {
			$join = 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
		}
		return $join;
	}
	/**
 * Filtering the where clause in admin post search query
 *
 * @return string SQL WHERE
 */
	public function leader_leads_search_where( $where ){
		global $pagenow, $wpdb;
		if ( is_admin() && $pagenow == 'edit.php' && ! empty( $_GET['post_type'] ) && $_GET['post_type'] == $this->plugin_name && ! empty( $_GET['s'] ) ) {
			$where = preg_replace(
		   "/\(\s*" . $wpdb->posts . ".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
		   "(" . $wpdb->posts . ".post_title LIKE $1) OR (" . $wpdb->postmeta . ".meta_value LIKE $1)", $where );
		}
		return $where;
	}
	public function leader_search_groupby($groupby) {
		global $pagenow, $wpdb;
		if(isset($_GET['s'])){
			if ( is_admin() && $pagenow == 'edit.php' && $_GET['post_type']==$this->plugin_name && $_GET['s'] != '' ) {
				$groupby = "$wpdb->posts.ID";
			}
		}
		return $groupby;
	}
	public function lr_email_send() {
		$lr_email_to = '';
		$lr_email_subject = '';
		$lr_email_message = '';
		$current_user = wp_get_current_user();
		$lr_signature = '';
		if(get_option('lr_engaging')){
			$engaging_settings =(get_option('lr_engaging'));
			$lr_engaging_active = $engaging_settings->lr_engaging_active;
			if(get_option('lr_engaging_signature') && (boolean)$lr_engaging_active){
				$lr_signature = get_option('lr_engaging_signature');
			}
		}
		if((isset($_GET['lr_email_to'])) || (isset($_GET['lr_email_subject'])) || (isset($_GET['lr_email_message']))){
			if (isset($_GET['lr_email_to'])) {
				$lr_email_to = sanitize_email($_GET['lr_email_to']);    
			}
			if (isset($_GET['lr_email_subject'])) {
				$lr_email_subject = sanitize_text_field($_GET['lr_email_subject']);    
			}
			if (isset($_GET['lr_email_message'])) {
				$allowed_html = array(
					  'br' => array(),
					);
				$field_textarea .= wp_kses( $_GET['lr_email_message'], $allowed_html );
				$lr_email_message = '<span style="white-space: pre-wrap;">' . $field_textarea .'</span><br><br>'.$lr_signature.'<p style="text-align: center;">Sent with &#128140; using <a href="mailto:ramsegev@gmail.com" >Leader</a></p>' ;
			}
			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-Type: text/html; charset=UTF-8' . "\r\n";
			$headers[] = 'Reply-To: '.$current_user->user_firstname .' '. $current_user->user_lastname.' <'.get_option('admin_email').'>';
			$headers[] = 'CC: <'.get_option('admin_email').'>';
			$sent = wp_mail($lr_email_to, $lr_email_subject, $lr_email_message, $headers);

			wp_die($sent);
		}
	}
	function log_mailer_errors($wp_error){
	   $fn = ABSPATH . '/mail.log'; // say you've got a mail.log file in your server root
	   $fp = fopen($fn, 'a');
	   fputs($fp, "Mailer Error: " . $wp_error->ErrorInfo ."\n");
	   fclose($fp);
	}
	
	function lr_save_wm_set(){
		$this->lr_save_wm('lr_wm');
		wp_die('');
	}
	private function lr_save_wm($db){
		$wm_settings = array();
		$lr_wm_active = '';
		$lr_wm_subject = esc_html__( 'Welcome', 'Leader Welcome Mail Settings', $this->plugin_name );
		$lr_wm_message = esc_html__( 'Thank you for contacting us. We will get back to you as soon as we can.', 'Leader Welcome Mail Settings', $this->plugin_name );
		if((isset($_GET['lr_wm_subject'])) || (isset($_GET['lr_wm_message']))){
			if (isset($_GET['lr_wm_active'])) {
				$lr_wm_active = sanitize_text_field($_GET['lr_wm_active']);
				if($lr_wm_active  == 'true'){
					$lr_wm_active = 'checked';
				} else{
					$lr_wm_active = '';
				}
			}if (isset($_GET['lr_wm_subject'])) {
				$lr_wm_subject = sanitize_text_field($_GET['lr_wm_subject']); 
			}if (isset($_GET['lr_wm_message'])) {
				$lr_wm_message = implode( "\n", array_map( 'wp_kses_post', explode( "\n", $_GET['lr_wm_message'])));   
			}
		}
		$wp_settings = array(
			'lr_wm_active' => $lr_wm_active,
			'lr_wm_subject' => $lr_wm_subject,
			'lr_wm_message' => $lr_wm_message,
		);
		update_option($db,json_decode(json_encode($wp_settings)));
	}
	function lr_save_engaging_set(){
		$lr_engaging_html = '';
		if((isset($_GET['lr_full_name'])) || (isset($_GET['lr_position'])) 
		|| (isset($_GET['lr_phone_number'])) || (isset($_GET['lr_mobile_number'])) 
		|| (isset($_GET['lr_email'])) || (isset($_GET['lr_website'])) 
		|| (isset($_GET['lr_address'])) || (isset($_GET['lr_notes'])) 
		|| (isset($_GET['lr_fb_address'])) || (isset($_GET['lr_instegram_address'])) 
		|| (isset($_GET['lr_whatsapp_address']))|| (isset($_GET['lr_fa_youtube'])) 
		|| (isset($_GET['lr_fa_twitter'])) || (isset($_GET['lr_linkedin_in'])) 
		|| (isset($_GET['lr_engaging_active'])) 
		){
			if (isset($_GET['lr_engaging_active'])) {
				$lr_engaging_active = sanitize_text_field($_GET['lr_engaging_active']);
				if($lr_engaging_active == 'true'){
					$lr_engaging_active = 'checked';
				} else{
					$lr_engaging_active = '';
				}
			}if (isset($_GET['lr_full_name'])) {
				$lr_full_name = sanitize_text_field($_GET['lr_full_name']); 
			}if (isset($_GET['lr_position'])) {
				$lr_position = sanitize_text_field($_GET['lr_position']); 
			}if (isset($_GET['lr_phone_number'])) {
				$lr_phone_number = sanitize_text_field($_GET['lr_phone_number']); 
			}if (isset($_GET['lr_mobile_number'])) {
				$lr_mobile_number = sanitize_text_field($_GET['lr_mobile_number']); 
			}if (isset($_GET['lr_email'])) {
				$lr_email = sanitize_email($_GET['lr_email']); 
			}if (isset($_GET['lr_website'])) {
				$lr_website = sanitize_text_field($_GET['lr_website']); 
			}if (isset($_GET['lr_address'])) {
				$lr_address = wp_kses( $_GET['lr_address'], $allowed_html );
			}if (isset($_GET['lr_notes'])) {
				$lr_notes = wp_kses( $_GET['lr_address'], $lr_notes );
			}if (isset($_GET['lr_fb_address'])) {
				$lr_fb_address = sanitize_text_field($_GET['lr_fb_address']); 
			}if (isset($_GET['lr_instegram_address'])) {
				$lr_instegram_address = sanitize_text_field($_GET['lr_instegram_address']); 
			}if (isset($_GET['lr_whatsapp_address'])) {
				$lr_whatsapp_address = sanitize_text_field($_GET['lr_whatsapp_address']); 
			}if (isset($_GET['lr_fa_youtube'])) {
				$lr_fa_youtube = sanitize_text_field($_GET['lr_fa_youtube']); 
			}if (isset($_GET['lr_fa_twitter'])) {
				$lr_fa_twitter = sanitize_text_field($_GET['lr_fa_twitter']); 
			}if (isset($_GET['lr_linkedin_in'])) {
				$lr_linkedin_in = sanitize_text_field($_GET['lr_linkedin_in']); 
			}if (isset($_GET['lr_linkedin_in'])) {
				$lr_linkedin_in = sanitize_text_field($_GET['lr_linkedin_in']); 
			}if (isset($_GET['image_attachment_id'])) {
				$image_attachment_id = sanitize_text_field($_GET['image_attachment_id']);
			}
			$wp_settings = array(
				'lr_full_name' => $lr_full_name,
				'lr_position' => $lr_position,
				'lr_phone_number' => $lr_phone_number,
				'lr_mobile_number' => $lr_mobile_number,
				'lr_email' => $lr_email,
				'lr_website' => $lr_website,
				'lr_address' => $lr_address,
				'lr_fb_address' => $lr_fb_address,
				'lr_instegram_address' => $lr_instegram_address,
				'lr_whatsapp_address' => $lr_whatsapp_address,
				'lr_fa_youtube' => $lr_fa_youtube,
				'lr_fa_twitter' => $lr_fa_twitter,
				'lr_linkedin_in' => $lr_linkedin_in,
				'lr_engaging_active' => $lr_engaging_active,
				'image_attachment_id' => $image_attachment_id,
			);
			if($image_attachment_id > 0){
				$lr_engaging_html = $lr_engaging_html. '<img class="lr-engaging-pic" src="'.wp_get_attachment_url($image_attachment_id).'"  style="width:100px;height:100px;display: inline-block; margin-bottom: 10px;overflow: hidden;text-align: center;vertical-align: middle;max-width: 250px;box-shadow: 0 10px 30px -12px rgba(0, 0, 0, 0.42), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);}" />';
			}
			if(strlen($lr_full_name) > 0){
				$lr_engaging_html = $lr_engaging_html. '<div style="font-size:22px;color:#333;font-weight:bold;margin-bottom:10px">'. $lr_full_name .'</div>';
			}
			if(strlen($lr_position) > 0){
				$lr_engaging_html = $lr_engaging_html. '<div style="font-size:18px;color:#333;font-weight:bold;">'. $lr_position .'</div>';
			}
			if(strlen($lr_mobile_number) > 0){
				$lr_engaging_html = $lr_engaging_html. '<div style="font-size:16px;"><a style="color:#333" href = "tel:'. $lr_mobile_number .'">'. $lr_mobile_number .'</a></div>';
			}
			if(strlen($lr_phone_number) > 0){
				$lr_engaging_html = $lr_engaging_html. '<div style="font-size:16px;"><a style="color:#333" href = "tel:'. $lr_phone_number .'">'. $lr_phone_number .'</a></div>';
			}
			if(strlen($lr_email) > 0){
				$lr_engaging_html = $lr_engaging_html. '<div style="font-size:16px;"><a style="color:#333" href = "mailto:'. $lr_email .'">'. $lr_email .'</a></div>';
			}
			if(strlen($lr_address) > 0){
				$lr_engaging_html = $lr_engaging_html. '<div style="font-size:16px;color:#333">'. $lr_address .'</div>';
			}
			if(strlen($lr_website) > 0){
				$lr_engaging_html = $lr_engaging_html. '<div style="font-size:16px;"><a style="color:#333" href="'.$lr_website.'">'. $lr_website .'</a></div>';
			}
			$lr_engaging_html = $lr_engaging_html.'<p style="margin-top:10px;">';
			if(strlen($lr_fb_address) > 0){
				$lr_engaging_html = $lr_engaging_html. '<a href="'.$lr_fb_address.'"><img style="width: 40px;" src="'.plugin_dir_url( __FILE__ ) .'images/leader-facebook.png" /></a>';
			}
			if(strlen($lr_instegram_address) > 0){
				$lr_engaging_html = $lr_engaging_html. '<a href="'.$lr_instegram_address.'"><img style="width: 40px;" src="'.plugin_dir_url( __FILE__ ) .'images/leader-instegram.png" /></a>';
			}
			if(strlen($lr_whatsapp_address) > 0){
				$lr_engaging_html = $lr_engaging_html. '<a href="https://wa.me/'.$lr_whatsapp_address.'"><img style="width: 40px;" src="'.plugin_dir_url( __FILE__ ) .'images/leader-wu.png" /></a>';
			}
			if(strlen($lr_fa_youtube) > 0){
				$lr_engaging_html = $lr_engaging_html. '<a href="'.$lr_fa_youtube.'"><img style="width: 40px;" src="'.plugin_dir_url( __FILE__ ) .'images/leader-youtube.png" /></a>';
			}
			if(strlen($lr_fa_twitter) > 0){
				$lr_engaging_html = $lr_engaging_html. '<a href="'.$lr_fa_twitter.'"><img style="width: 40px;" src="'.plugin_dir_url( __FILE__ ) .'images/leader-tweet.png" /></a>';
			}
			if(strlen($lr_linkedin_in) > 0){
				$lr_engaging_html = $lr_engaging_html. '<a href="'.$lr_linkedin_in.'"><img style="width: 40px;" src="'.plugin_dir_url( __FILE__ ) .'images/leader-linkdin.png" /></a>';
			}
			$lr_engaging_html = $lr_engaging_html. '</p>';
			$signature = wp_kses_post($lr_engaging_html);
			/* $lr_bcard_html = '<div id="lr_bcard">
				<div id="lr_bcard_head"></div>
				<div class="lr-bcard-hidden">
					'.$lr_engaging_html.'
				</div>
			</div>'; */
			$lr_bcard_html = '<div id="lr_bcard">
				<div id="lr_bcard_head" class="lr-menu-click">
					<div id="lr_bcard_menu" class="lr-card-menu lr-menu-click">
						<span class="lr-menu-click"></span>
						<span class="lr-menu-click"></span>
						<span class="lr-menu-click"></span>
					</div>
				</div>
				<div id="lr_bcard_hidden" class="lr-bcard-hidden">
					<div class="lr-card-wrapper">
						<div class="lr-card-header">
							<img src="http://lorempixel.com/400/200/business/" />
						</div>
						<div class="lr-card-body">
							<img class="lr-card-body-person" src="'.wp_get_attachment_url($image_attachment_id).'" />
							<h1>'. $lr_full_name .'</h1>
							<h2>'. $lr_position .'</h2>
							<div class="lr-bcard-links">
								<a class="lr-menu-click"><img class="lr-menu-click" src="'.plugin_dir_url( __FILE__ ) .'images/bcard/home.png"></a>
								<a href = "mailto:'. $lr_email .'"><img src="'.plugin_dir_url( __FILE__ ) .'images/bcard/message.png"></a>
								<a href = "tel:'. $lr_mobile_number .'"><img src="'.plugin_dir_url( __FILE__ ) .'images/bcard/phone.png"></a>
								<a href="https://wa.me/'.$lr_whatsapp_address.'"><img src="'.plugin_dir_url( __FILE__ ) .'images/bcard/chat.png"></a>
								<a href="https://goo.gl/maps/Eja61YHen1v2oB2XA"><img src="'.plugin_dir_url( __FILE__ ) .'images/bcard/location.png"></a>
								<a href="https://www.waze.com/ul?ll=32.06564270%2C34.78851410&navigate=yes&zoom=16"><img src="'.plugin_dir_url( __FILE__ ) .'images/bcard/location2.png"></a>
							</div>
						</div>
						<div class="lr-card-footer">
						
						</div>
					</div>
				</div>
			</div>';
			$allowed_html = array(
				'div' => (bool)true,
				'p' => (bool)true,
				'form' => (bool)true,
				'input' => (bool)true,
				'button' => (bool)true,
				'a' => (bool)true,
			);
			$allowed_tags = wp_kses_allowed_html( $allowed_html  );
			//$lr_bcard_html = esc_html( $lr_bcard_html );
			$lr_bcard = wp_kses_post($lr_bcard_html);
			update_option('lr_engaging_signature',$signature);
			update_option('lr_bcard_html',$lr_bcard);
			update_option('lr_engaging',json_decode(json_encode($wp_settings)));
			$PageGuid = site_url() . '/'.$lr_full_name.'-bcard';
			$my_post  = array( 
				'post_title'    => $lr_full_name.' bcard',
				'post_type'      => 'page',
				'post_name'      =>  $lr_full_name.'-bcard',
				'post_content'   =>  $lr_bcard,
				'post_status'    => 'publish',
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_author'    => 1,
				'menu_order'     => 0,
				'guid'           => $PageGuid );
			$PageID = get_page_by_title($my_post->post_title);
			if($PageID->ID > 0){
				array_push($my_post,"'ID' => $PageID->ID");
				wp_update_post( $my_post, FALSE );
			}else{
				$PageID = wp_insert_post( $my_post, FALSE );
			}
			wp_die($lr_engaging_html);
		}
	}
	private function lr_save_gs($db){
		$lr_delay = '2';
		$lr_pages = 'Entire website';
		$lr_platform = 'Both';
		$gs_settings = array();
		if (isset($_GET['lr_delay'])) {
			$lr_delay = sanitize_text_field($_GET['lr_delay']);
		}if (isset($_GET['lr_pages'])) {
			$lr_pages = sanitize_text_field($_GET['lr_pages']);
		}
		if (isset($_GET['lr_platform'])) {
			$lr_platform = sanitize_text_field($_GET['lr_platform']);
		}
		$gs_settings = array(
			'lr_delay' => $lr_delay,
			'lr_pages' => $lr_pages,
			'lr_platform' => $lr_platform,
		);
		update_option($db,json_decode(json_encode($gs_settings)));
		return json_decode(json_encode($gs_settings));
	}
	private function lr_save_pos($db){
		$lr_pos_horizontal = '';
		$lr_pos_vertical = '';
		if (isset($_GET['lr_pos_horizontal'])) {
			$lr_pos_horizontal = sanitize_text_field($_GET['lr_pos_horizontal']);
			if($lr_pos_horizontal  == 'true'){
				$lr_pos_horizontal = 'checked';
			}
		}if (isset($_GET['lr_pos_vertical'])) {
			$lr_pos_vertical = sanitize_text_field($_GET['lr_pos_vertical']);
			if($lr_pos_vertical  == 'true'){
				$lr_pos_vertical = 'checked';
			}
		}
		$pos_settings = array(
			'lr_pos_horizontal' => $lr_pos_horizontal,
			'lr_pos_vertical' => $lr_pos_vertical,
		);
		update_option($db,json_decode(json_encode($pos_settings)));
		return json_decode(json_encode($pos_settings));
	}
	private function lr_save_dn($db){
		$dn_settings = array();
		$lr_text_font_family = 'Verdana';
		$lr_text_font_size = '20';
		$lr_button_font_family = 'Verdana';
		$lr_button_font_size = '20';
		$lr_bg_color = 'rgba(123, 194, 212, 1)';
		$lr_text_color = 'rgba(255, 255, 255, 1)';
		$lr_button_text_color = 'rgba(255, 255, 255, 1)';
		$lr_button_bg_color = 'rgba(255, 196, 0, 1)';
		$lr_border_color = 'rgba(255, 5, 5, 1)';
		$lr_border_type = 'none';
		if (isset($_GET['lr_text_font_family'])) {
			$lr_text_font_family = sanitize_text_field($_GET['lr_text_font_family']); 
		}if (isset($_GET['lr_text_font_size'])) {
			$lr_text_font_size = sanitize_text_field($_GET['lr_text_font_size']); 
		}if (isset($_GET['lr_button_font_family'])) {
			$lr_button_font_family = sanitize_text_field($_GET['lr_button_font_family']); 
		}if (isset($_GET['lr_button_font_size'])) {
			$lr_button_font_size = sanitize_text_field($_GET['lr_button_font_size']); 
		}if (isset($_GET['lr_bg_color'])) {
			$lr_bg_color = sanitize_text_field($_GET['lr_bg_color']); 
		}if (isset($_GET['lr_text_color'])) {
			$lr_text_color = sanitize_text_field($_GET['lr_text_color']); 
		}if (isset($_GET['lr_button_text_color'])) {
			$lr_button_text_color = sanitize_text_field($_GET['lr_button_text_color']); 
		}if (isset($_GET['lr_button_bg_color'])) {
			$lr_button_bg_color = sanitize_text_field($_GET['lr_button_bg_color']); 
		}if (isset($_GET['lr_border_color'])) {
			$lr_border_color = sanitize_text_field($_GET['lr_border_color']); 
		}if (isset($_GET['lr_border_type'])) {
			$lr_border_type = sanitize_text_field($_GET['lr_border_type']); 
		}
		$dn_settings = array(
			'lr_text_font_family' => $lr_text_font_family,
			'lr_text_font_size' => $lr_text_font_size,
			'lr_button_font_family' => $lr_button_font_family,
			'lr_button_font_size' => $lr_button_font_size,
			'lr_bg_color' => $lr_bg_color,
			'lr_text_color' => $lr_text_color,
			'lr_button_text_color' => $lr_button_text_color,
			'lr_button_bg_color' => $lr_button_bg_color,
			'lr_border_color' => $lr_border_color,
			'lr_border_type' => $lr_border_type,
		);
		update_option($db,json_decode(json_encode($dn_settings)));
		return json_decode(json_encode($dn_settings));
	}
	
	
	///components
	public function get_general_settings($db){
		$lr_delay = '2';
		$lr_pages = 'Entire website';
		$lr_platform = 'Both';
		if(get_option($db)){
			$gs_settings =get_option($db);
			if(isset($gs_settings->lr_delay)){$lr_delay = $gs_settings->lr_delay;}
			if(isset($gs_settings->lr_pages)){$lr_pages = $gs_settings->lr_pages;}
			if(isset($gs_settings->lr_platform)){$lr_platform = $gs_settings->lr_platform;}
		}
		$lr_pages_home = '';
		if($lr_pages=="Home page only"){
			$lr_pages_home = "selected";
		} 
		$lr_pages_entire = '';
		if($lr_pages=="Entire website"){
			$lr_pages_entire = "selected";
		} 
		$lr_platform_both = '';
		$lr_platform_desktop = '';
		$lr_platform_mobile = '';
		if($lr_platform=="Both"){
			$lr_platform_both = "selected";
		}		
		if($lr_platform=="Desktop"){
			$lr_platform_desktop = "selected";
		}		
		if($lr_platform=="Mobile"){
			$lr_platform_mobile = "selected";
		}		
		$lr_gs_html = '<h6 class="lr-pa-title">'. esc_html_x( "General Settings", "Leader Personal Assistent Settings", $this->plugin_name ).'</h6>
			<br>
			<div class="row">
				<!-- <div class="form-group bmd-form-group col-4 lr-pa-delay select-with-transition">
						<label for="lr_opacity" class="bmd-label-floating always-float">'.  esc_html_x( "Opacity", "Leader General Settings", $this->plugin_name ).'</label>
						<div id="lr_opacity"  class="slider"></div>
				</div> -->
				<div class="form-group bmd-form-group col-4 lr-line-with-select select-with-transition">
						<label for="lr_delay" class="bmd-label-floating always-float">'.  esc_html_x( "Appear In (Seconds)", "Leader General Settings", $this->plugin_name ).'</label>
						<input id="lr_delay"  type="number"  class="form-control"  value="'.esc_attr($lr_delay) .'" />
				</div>
				<div class="form-group bmd-form-group col-4">
					<label for="lr_pages" class="bmd-label-floating always-float">'. esc_html_x( "Show On", "Leader General Settings", $this->plugin_name ).'</label>
					<select id="lr_pages" class="selectpicker" data-style="btn select-with-transition" title="Show On" tabindex="-98" value="'.esc_attr($lr_pages) .'">
						<option value="Home page only" '. $lr_pages_home.'>Home page only</option>
						<option value="Entire website" '.$lr_pages_entire.'>Entire website</option>
					</select>
				</div>
				<div class="form-group bmd-form-group col-4">
					<label for="lr_platform" class="bmd-label-floating always-float">'. esc_html_x( "Platform", "Leader General Settings", $this->plugin_name ).'</label>
					<select id="lr_platform" class="selectpicker" data-style="btn select-with-transition" title="Platform" tabindex="-98" value="'.esc_attr($lr_platform) .'">
						<option value="Both"  '.$lr_platform_both.'>Both</option>
						<option value="Desktop"  '.$lr_platform_desktop.'>Desktop</option>
						<option value="Mobile"  '.$lr_platform_mobile.'>Mobile</option>
					</select>
				</div>
			</div>';
			return $lr_gs_html;
	}
	// lr_position values - all/horizontal/vertical
	public function get_position_settings($lr_settings){
		$lr_pos_horizontal = '';
		$lr_pos_vertical = '';
		$lr_pos_show_horizontal = '';
		$lr_pos_show_vertical = '';
		if(isset($lr_settings['lr_db'])){
			$db = $lr_settings['lr_db'];
			if(get_option($db)){
				$pos_settings = get_option($db);
				if(isset($pos_settings->lr_pos_horizontal)){$lr_pos_horizontal = $pos_settings->lr_pos_horizontal;}
				if(isset($pos_settings->lr_pos_vertical)){$lr_pos_vertical = $pos_settings->lr_pos_vertical;}
			}
			if(($lr_settings['lr_position'] === 'horizontal') || ($lr_settings['lr_position'] === 'all')){
				$lr_pos_show_horizontal = '<div class="togglebutton">
						<label class="lr-pos-left-right">
							<div>'. esc_html_x( 'Left', 'Leader position Settings', $this->plugin_name ).'</div>
							<input id="lr_pos_horizontal" type="checkbox" '. esc_attr($lr_pos_horizontal) .' />
							<span class="toggle"></span>
							<div>'. esc_html_x( 'Right', 'Leader position Settings', $this->plugin_name ).'</div>
						</label>
					</div>';
			}
			if(($lr_settings['lr_position'] === 'vertical') || ($lr_settings['lr_position'] === 'all')){
				$lr_pos_show_vertical = '<div class="togglebutton">
						<label class="lr-pos-top-bottom">
							<div>'. esc_html_x( 'Top', 'Leader position Settings', $this->plugin_name ).'</div>
							<input id="lr_pos_vertical" type="checkbox" '. esc_attr($lr_pos_vertical) .' />
							<span class="toggle"></span>
							<div>'. esc_html_x( 'Bottom', 'Leader position Settings', $this->plugin_name ).'</div>
						</label>
					</div>';
			}
			$lr_pos_html = '<h6 class="lr-pa-title">'. esc_html_x( "Position Settings", "Leader position Settings", $this->plugin_name ).'</h6>
				<div class="row">
					<div class="form-group bmd-form-group col-4">
						<div class="form-group">
							'.$lr_pos_show_horizontal.'
							'.$lr_pos_show_vertical.'
						</div>
					</div>
				</div>';
			return $lr_pos_html;
		}
	}
	public function get_design_settings($db){
		$lr_text_font_family = 'Verdana';
		$lr_text_font_size = '20';
		$lr_button_font_family = 'Verdana';
		$lr_button_font_size = '20';
		$lr_bg_color = 'rgba(123, 194, 212, 1)';
		$lr_text_color = 'rgba(255, 255, 255, 1)';
		$lr_button_text_color = 'rgba(255, 255, 255, 1)';
		$lr_button_bg_color = 'rgba(255, 196, 0, 1)';
		$lr_border_color = 'rgba(255, 5, 5, 1)';
		$lr_border_type = 'none';
		if(get_option($db)){
			$dn_settings = get_option($db);
			if(isset($dn_settings->lr_bg_color)){$lr_bg_color = $dn_settings->lr_bg_color;}
			if(isset($dn_settings->lr_text_color)){$lr_text_color = $dn_settings->lr_text_color;}
			if(isset($dn_settings->lr_button_text_color)){$lr_button_text_color = $dn_settings->lr_button_text_color;}
			if(isset($dn_settings->lr_button_bg_color)){$lr_button_bg_color = $dn_settings->lr_button_bg_color;}
			if(isset($dn_settings->lr_border_color)){$lr_border_color = $dn_settings->lr_border_color;}
			if(isset($dn_settings->lr_border_type)){$lr_border_type = $dn_settings->lr_border_type;}
			if(isset($dn_settings->lr_text_font_family)){$lr_text_font_family = $dn_settings->lr_text_font_family;}
			if(isset($dn_settings->lr_text_font_size)){$lr_text_font_size = $dn_settings->lr_text_font_size;}
			if(isset($dn_settings->lr_button_font_family)){$lr_button_font_family = $dn_settings->lr_button_font_family;}
			if(isset($dn_settings->lr_button_font_size)){$lr_button_font_size = $dn_settings->lr_button_font_size;}
		}
		$lr_border_solid = '';
		$lr_border_none = '';
		$lr_border_hidden = '';
		$lr_border_dotted = '';
		$lr_border_dashed = '';
		$lr_border_double = '';
		$lr_border_groove = '';
		$lr_border_ridgee = '';
		$lr_border_inset = '';
		$lr_border_outset = '';
		if($lr_border_type=="solid"){
			$lr_border_solid = "selected";
		}if($lr_border_type=="none"){
			$lr_border_none = "selected";
		}if($lr_border_type=="hidden"){
			$lr_border_hidden = "selected";
		}if($lr_border_type=="dotted"){
			$lr_border_dotted = "selected";
		}if($lr_border_type=="dashed"){
			$lr_border_dashed = "selected";
		}if($lr_border_type=="double"){
			$lr_border_double = "selected";
		}if($lr_border_type=="groove"){
			$lr_border_groove = "selected";
		}if($lr_border_ridgee=="inset"){
			$lr_border_inset = "selected";
		}if($lr_border_type=="outset"){
			$lr_border_outset = "selected";
		}
		$lr_text_font_inhirit = '';
		$lr_text_font_arial = '';
		$lr_text_font_arial_b = '';
		$lr_text_font_helvetica = '';
		$lr_text_font_tnr = '';
		$lr_text_font_times = '';
		$lr_text_font_courier_new = '';
		$lr_text_font_courier = '';
		$lr_text_font_verdana = '';
		$lr_text_font_georgia = '';
		$lr_text_font_palatino = '';
		$lr_text_font_garamond = '';
		$lr_text_font_bookman = '';
		$lr_text_font_comic_sans_ms = '';
		$lr_text_font_trebuchet_ms = '';
		$lr_text_font_impact = '';
		if($lr_text_font_family=="inhirit"){
			$lr_text_font_inhirit = "selected";
		}if($lr_text_font_family=="Arial"){
			$lr_text_font_arial = "selected";
		}if($lr_text_font_family=="Arial Black"){
			$lr_text_font_arial_b = "selected";
		}if($lr_text_font_family=="Helvetica"){
			$lr_text_font_helvetica = "selected";
		}if($lr_text_font_family=="Times New Roman"){
			$lr_text_font_tnr = "selected";
		}if($lr_text_font_family=="Times"){
			$lr_text_font_times = "selected";
		}if($lr_text_font_family=="Courier New"){
			$lr_text_font_courier_new = "selected";
		}if($lr_text_font_family=="Courier"){
			$lr_text_font_courier = "selected";
		}if($lr_text_font_family=="Verdana"){
			$lr_text_font_verdana = "selected";
		}if($lr_text_font_family=="Georgia"){
			$lr_text_font_georgia = "selected";
		}if($lr_text_font_family=="Palatino"){
			$lr_text_font_palatino = "selected";
		}if($lr_text_font_family=="Garamondk"){
			$lr_text_font_garamond = "selected";
		}if($lr_text_font_family=="Bookman"){
			$lr_text_font_bookman = "selected";
		}if($lr_text_font_family=="Comic Sans MS"){
			$lr_text_font_comic_sans_ms = "selected";
		}if($lr_text_font_family=="Trebuchet MS"){
			$lr_text_font_trebuchet_ms = "selected";
		}if($lr_text_font_family=="Impact"){
			$lr_text_font_impact = "selected";
		}
		$lr_button_font_inhirit = '';
		$lr_button_font_arial = '';
		$lr_button_font_arial_b = '';
		$lr_button_font_helvetica = '';
		$lr_button_font_tnr = '';
		$lr_button_font_times = '';
		$lr_button_font_courier_new = '';
		$lr_button_font_courier = '';
		$lr_button_font_verdana = '';
		$lr_button_font_georgia = '';
		$lr_button_font_palatino = '';
		$lr_button_font_garamond = '';
		$lr_button_font_bookman = '';
		$lr_button_font_comic_sans_ms = '';
		$lr_button_font_trebuchet_ms = '';
		$lr_button_font_impact = '';
		if($lr_button_font_family=="inhirit"){
			$lr_button_font_inhirit = "selected";
		}if($lr_button_font_family=="Arial"){
			$lr_button_font_arial = "selected";
		}if($lr_button_font_family=="Arial Black"){
			$lr_button_font_arial_b = "selected";
		}if($lr_button_font_family=="Helvetica"){
			$lr_button_font_helvetica = "selected";
		}if($lr_button_font_family=="Times New Roman"){
			$lr_button_font_tnr = "selected";
		}if($lr_button_font_family=="Times"){
			$lr_button_font_times = "selected";
		}if($lr_button_font_family=="Courier New"){
			$lr_button_font_courier_new = "selected";
		}if($lr_button_font_family=="Courier"){
			$lr_button_font_courier = "selected";
		}if($lr_button_font_family=="Verdana"){
			$lr_button_font_verdana = "selected";
		}if($lr_button_font_family=="Georgia"){
			$lr_button_font_georgia = "selected";
		}if($lr_button_font_family=="Palatino"){
			$lr_button_font_palatino = "selected";
		}if($lr_button_font_family=="Garamondk"){
			$lr_button_font_garamond = "selected";
		}if($lr_button_font_family=="Bookman"){
			$lr_button_font_bookman = "selected";
		}if($lr_button_font_family=="Comic Sans MS"){
			$lr_button_font_comic_sans_ms = "selected";
		}if($lr_button_font_family=="Trebuchet MS"){
			$lr_button_font_trebuchet_ms = "selected";
		}if($lr_button_font_family=="Impact"){
			$lr_button_font_impact = "selected";
		}
		$lr_dm_html = '<h6 class="lr-pa-title">'.  esc_html_x( "Design Settings", "Leader Personal Assistent Settings", $this->plugin_name ).'</h6>
					<br>
					<div class="row ">
						<div class="form-group bmd-form-group col-4">
							<label for="lr_text_font_family" class="bmd-label-floating always-float">'.  esc_html_x( "Text Font", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<select id="lr_text_font_family" class="selectpicker" data-style="btn select-with-transition" title="Borders" tabindex="-98" value="'.  esc_attr($lr_text_font_family) .'">
								<option value="inhirit" '. $lr_text_font_inhirit.'>inhirit</option>
								<option value="Arial" '. $lr_text_font_arial.'>Arial</option>
								<option value="Arial Black" '. $lr_text_font_arial_b.'>Arial Black</option>
								<option value="Helvetica" '. $lr_text_font_helvetica.'>Helvetica</option>
								<option value="Times New Roman" '. $lr_text_font_tnr.'>Times New Roman</option>
								<option value="Times" '. $lr_text_font_times.'>Times</option>
								<option value="Courier New" '. $lr_text_font_courier_new.'>Courier New</option>
								<option value="Courier" '. $lr_text_font_courier.'>Courier</option>
								<option value="Verdana" '. $lr_text_font_verdana.'>Verdana</option>
								<option value="Georgia" '. $lr_text_font_georgia.'>Georgia</option>
								<option value="Palatino" '. $lr_text_font_palatino.'>Palatino</option>
								<option value="Garamond" '. $lr_text_font_garamond.'>Garamond</option>
								<option value="Bookman" '. $lr_text_font_bookman.'>Bookman</option>
								<option value="Comic Sans MS" '. $lr_text_font_comic_sans_ms.'>Comic Sans MS</option>
								<option value="Trebuchet MS" '. $lr_text_font_trebuchet_ms.'>Trebuchet MS</option>
								<option value="Impact" '. $lr_text_font_impact.'>Impact</option>
							</select>
						</div>
						<div class="form-group bmd-form-group col-2 lr-line-with-select select-with-transition">
							<label for="lr_text_font_size" class="bmd-label-floating always-float">'.  esc_html_x( "Text Size", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<input id="lr_text_font_size"  type="number"  class="form-control"  value="'.esc_attr($lr_text_font_size) .'" />
						</div>
						<div class="form-group bmd-form-group col-4">
							<label for="lr_button_font_family" class="bmd-label-floating always-float">'.  esc_html_x( "Button Font", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<select id="lr_button_font_family" class="selectpicker" data-style="btn select-with-transition" title="Borders" tabindex="-98" value="'.  esc_attr($lr_button_font_family) .'">
								<option value="inhirit" '. $lr_button_font_inhirit.'>inhirit</option>
								<option value="Arial" '. $lr_button_font_arial.'>Arial</option>
								<option value="Arial Black" '. $lr_button_font_arial_b.'>Arial Black</option>
								<option value="Helvetica" '. $lr_button_font_helvetica.'>Helvetica</option>
								<option value="Times New Roman" '. $lr_button_font_tnr.'>Times New Roman</option>
								<option value="Times" '. $lr_button_font_times.'>Times</option>
								<option value="Courier New" '. $lr_button_font_courier_new.'>Courier New</option>
								<option value="Courier" '. $lr_button_font_courier.'>Courier</option>
								<option value="Verdana" '. $lr_button_font_verdana.'>Verdana</option>
								<option value="Georgia" '. $lr_button_font_georgia.'>Georgia</option>
								<option value="Palatino" '. $lr_button_font_palatino.'>Palatino</option>
								<option value="Garamond" '. $lr_button_font_garamond.'>Garamond</option>
								<option value="Bookman" '. $lr_button_font_bookman.'>Bookman</option>
								<option value="Comic Sans MS" '. $lr_button_font_comic_sans_ms.'>Comic Sans MS</option>
								<option value="Trebuchet MS" '. $lr_button_font_trebuchet_ms.'>Trebuchet MS</option>
								<option value="Impact" '. $lr_button_font_impact.'>Impact</option>
							</select>
						</div>
						<div class="form-group bmd-form-group col-2 lr-line-with-select select-with-transition">
							<label for="lr_button_font_size" class="bmd-label-floating always-float">'.  esc_html_x( "Button Size", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<input id="lr_button_font_size"  type="number"  class="form-control"  value="'.esc_attr($lr_button_font_size) .'" />
						</div>
					</div>
					<br>
					<div class="row lr_pa_colors">
						<div class="form-group bmd-form-group lr-pa-colors col-2">
							<label for="lr_bg_color" class="bmd-label-floating always-float">'.  esc_html_x( "Background", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<input id="lr_bg_color" class="color-picker" type="text"  class="form-control minicolors"  value="'.  esc_attr($lr_bg_color) .'" />
						</div>
						<div class="form-group bmd-form-group lr-pa-colors col-2">
							<label for="lr_text_color" class="bmd-label-floating always-float">'.  esc_html_x( "Text Color", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<input id="lr_text_color" class="color-picker" type="text"  class="form-control minicolors"  value="'.  esc_attr($lr_text_color) .'" />
						</div>
						<div class="form-group bmd-form-group lr-pa-colors col-2">
							<label for="lr_button_bg_color" class="bmd-label-floating always-float">'.  esc_html_x( "Button Color", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<input id="lr_button_bg_color" class="color-picker" type="text"  class="form-control minicolors"  value="'.  esc_attr($lr_button_bg_color) .'" />
						</div>
						<div class="form-group bmd-form-group lr-pa-colors col-2">
							<label for="lr_button_text_color" class="bmd-label-floating always-float">'.  esc_html_x( "Button Text", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<input id="lr_button_text_color" class="color-picker" type="text"  class="form-control minicolors"  value="'.  esc_attr($lr_button_text_color) .'" />
						</div>
						<div class="form-group bmd-form-group lr-pa-colors col-2">
							<label for="lr_border_color" class="bmd-label-floating always-float">'.  esc_html_x( "Border", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<input id="lr_border_color" class="color-picker" type="text"  class="form-control minicolors"  value="'.  esc_attr($lr_border_color) .'" />
						</div>
					</div>
					<div class="row ">
						<div class="form-group bmd-form-group col-4 lr-border-color">
							<label for="lr_border_color" class="bmd-label-floating always-float">'.  esc_html_x( "Border type", "Leader Personal Assistent Settings", $this->plugin_name ).'</label>
							<select id="lr_border_type" class="selectpicker" data-style="btn select-with-transition" title="Borders" tabindex="-98" value="'.  esc_attr($lr_border_type) .'">
								<option value="solid" '. $lr_border_solid.'>solid</option>
								<option value="none" '. $lr_border_none.'>none</option>
								<option value="hidden" '. $lr_border_hidden.'>hidden</option>
								<option value="dotted" '. $lr_border_dotted.'>dotted</option>
								<option value="dashed" '. $lr_border_dashed.'>dashed</option>
								<option value="double" '. $lr_border_double.'>double</option>
								<option value="groove" '. $lr_border_groove.'>groove</option>
								<option value="ridge" '. $lr_border_ridgee.'>ridge</option>
								<option value="inset" '. $lr_border_inset.'>inset</option>
								<option value="outset" '. $lr_border_outset.'>outset</option>
							</select>
						</div>
					</div>';
					return $lr_dm_html;
	}
	public function get_welcome_mail($db){
		$lr_wm_active = '';
		$lr_wm_subject = esc_html__( 'Welcome', 'Leader Welcome Mail Settings', $this->plugin_name );
		$lr_wm_message = esc_html__( 'Thank you for contacting us. We will get back to you as soon as we can.', 'Leader Welcome Mail Settings', $this->plugin_name );
		$disable = '';
		if(get_option($db)){
			$wm_settings = get_option($db);
			if(isset($wm_settings->lr_wm_active)){$lr_wm_active = $wm_settings->lr_wm_active;}
			if(isset($wm_settings->lr_wm_subject)){$lr_wm_subject = $wm_settings->lr_wm_subject;}
			if(isset($wm_settings->lr_wm_message)){$lr_wm_message = $wm_settings->lr_wm_message;}
		}else if(get_option('lr_wm')){
			$wm_settings = get_option('lr_wm');
			if(isset($wm_settings->lr_wm_active)){$lr_wm_active = $wm_settings->lr_wm_active;}
			if(isset($wm_settings->lr_wm_subject)){$lr_wm_subject = $wm_settings->lr_wm_subject;}
			if(isset($wm_settings->lr_wm_message)){$lr_wm_message = $wm_settings->lr_wm_message;}
		}
		if(!$lr_wm_active){
			$disable = 'disabled';
		}
		$lr_wm_html = '<div class="col-md-12">
			<h6 class="lr-pa-title">'. esc_html_x( 'Welcome Mail Settings', 'Leader Welcome Mail Settings', $this->plugin_name ).'</h6>
			<div class="card col-md-12">
				<div class="card-header card-header-rose card-header-icon">
					<div class="card-icon">
						<i class="material-icons">mail_outline</i>
					</div>
					<h4 class="card-title">
						<div class="form-group">
							<div class="togglebutton">
								<label>
									<input id="lr_wm_active" type="checkbox" '. esc_attr($lr_wm_active) .' />
									'. esc_html_x( 'Activate Personal Assistent Welcome message', 'Leader Personal Assistent Settings', $this->plugin_name ).'
									<span class="toggle"></span>
								</label>
							</div>
						</div>
					</h4>
				</div>
				<div class="card-body ">
					<div class="card-body ">
						<div class="form-group bmd-form-group">
							<label for="lr_wm_subject" class="bmd-label-floating">'. esc_html_x( 'Subject', 'Leader Personal Assistent Settings', $this->plugin_name ).'</label>
							<input type="text" class="form-control" '. $disable.' id="lr_wm_subject" value="'. esc_attr($lr_wm_subject) .'">
						</div>
						<div class="form-group bmd-form-group">
							<label for="lr_wm_message" class="bmd-label-floating">'. esc_html_x( 'Message', 'Leader Personal Assistent Settings', $this->plugin_name ).'</label>
							<textarea rows="4" cols="50" class="form-control" '. $disable.' id="lr_wm_message">'. esc_textarea($lr_wm_message) .'</textarea>
						</div>
					</div>
				</div>
			</div>
		</div>';
		return $lr_wm_html;
	}
	function lr_admin_notice(){
		$screen = get_current_screen();
		//echo var_dump($screen->id);
		//leader box
		if ( $screen->id == 'edit-leader' ) {
			 echo '<div class="alert alert-info alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                    <span data-notify="message" class="lr-notification-note">'.esc_html_x( 'Note: All leads from all forms containing an email will automatically be documented in the Leader Box.','Notifications',$this->plugin_name ).'</span>
                    <span data-notify="message">'.sprintf( esc_html_x( 'Tip: Activate %1$s in order to send automatic welcome email for every new lead.','Notifications',$this->plugin_name ),'<a href="'. get_site_url().'/wp-admin/edit.php?post_type=leader&page=leader_welcoming"> '. esc_html_x( 'Welcome Mail','admin menu',$this->plugin_name ).'</a>').'</span>
                  </div>';
		}
		//welcom email
		if ( $screen->id == 'leader_page_leader_welcoming' ) {
			 echo '<div class="alert alert-info alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                    <span data-notify="message" class="lr-notification-note">'.esc_html_x( 'Note:  Welcome Email will be sent automatically for each lead.','Notifications',$this->plugin_name ).'</span>
                    <span data-notify="message">'.sprintf( esc_html_x( 'Tip: Activate %1$s to increase engagement in every mail.','Notifications',$this->plugin_name ),'<a href="'. get_site_url().'/wp-admin/edit.php?post_type=leader&page=leader_engaging"> '. esc_html_x( 'Social Signature','admin menu',$this->plugin_name ).'</a>').'<span>
                  </div>';
		}
		// leader contact
		if ( $screen->id == 'leader' ) {
			 echo '<div class="alert alert-info alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                    <span data-notify="message" class="lr-notification-note">'.esc_html_x( 'Note: All customer referrals are documented under the waves.','Notifications',$this->plugin_name ).'</span>
                  </div>';
		}
		//social signature
		if ( $screen->id == 'leader_page_leader_engaging' ) {
			 echo '<div class="alert alert-info alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                    <span data-notify="message" class="lr-notification-note">'.esc_html_x( 'Note: Social signature is automatically added to every mail coming from leader (i.e Welcome Mail).','Notifications',$this->plugin_name ).'</span>
                  </div>';
		}
		// hello bar
		if ( $screen->id == 'leader_page_leader_hello_bar' ) {
			 echo '<div class="alert alert-info alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                    <span data-notify="message" class="lr-notification-note">'.esc_html_x( 'Note: A call to action bar will appear on top or bottom of a page that will attract users to send their details','Notifications',$this->plugin_name ).'</span>
                  </div>';
		}
		// contact form
		if ( $screen->id == 'leader_page_leader_form' ) {
			 echo '<div class="alert alert-info alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                    <span data-notify="message" class="lr-notification-note">'.esc_html_x( 'Note: Floating Contact form that follow the user and help to send a request.','Notifications',$this->plugin_name ).'</span>
                  </div>';
		}
		// video popup
		if ( $screen->id == 'leader_page_leader_video_popup' ) {
			 echo '<div class="alert alert-info alert-with-icon" data-notify="container">
                    <i class="material-icons" data-notify="icon">notifications</i>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span data-notify="icon" class="now-ui-icons ui-1_bell-53"></span>
                    <span data-notify="message" class="lr-notification-note">'.esc_html_x( 'Note: Video Popup will appear only once and will help with its contact form to capture more leads.','Notifications',$this->plugin_name ).'</span>
                  </div>';
		}
	}
}// Leader_Admin