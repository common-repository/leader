<?php

/**
 * The api-specific functionality of the plugin.
 *
 * @link       https://leader.codes
 * @since      1.0.0
 *
 * @package    Leader
 * @subpackage Leader/includes
 */

/**
 * The api-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the api-specific stylesheet and JavaScript.
 *
 * @package    Leader
 * @subpackage Leader/includes
 * @author     Ram Segev <ramsegev@gmail.codes>
 */
class Leader_API {

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
		/* $this->loader = new Leader_Loader(); */
	} 
	/**
	* Update db with new metabox 
	*/
	public function lr_creat_meta_box($args){
		$lr_fields = array();
		$arr = array();
		if(isset($args['id'])){
			if(get_option('lr_fields')){
				$lr_fields = $this->objToArray(get_option('lr_fields'),$arr);
					if(!in_array($args['id'], wp_list_pluck($lr_fields, 'id'))){
						array_push($lr_fields,$args);
					}
			}
			else{
				$lr_fields = array($args);
			}
		$json_lr_fields = json_decode(json_encode($lr_fields));
		update_option('lr_fields', $json_lr_fields);	
		}
	}
	/**
	* Convert object to array recursively
	*/
	
	public function objToArray($obj, &$arr){

		if(!is_object($obj) && !is_array($obj)){
			$arr = $obj;
			return $arr;
		}

		foreach ($obj as $key => $value)
		{
			if (!empty($value))
			{
				$arr[$key] = array();
				$this->objToArray($value, $arr[$key]);
			}
			else
			{
				$arr[$key] = $value;
			}
		}
		return $arr;
	}
	/**
	* Add taxonomy to meatbox
	*/
	public function add_taxonomy($args){
		$taxonomy = array(
				'hierarchical'      => true,
				'lable'				=> $args['options']['category_title'],
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'slug' => $args['options']['category_slug'],
		);
		$term_id = term_exists($args['id'], 'lr_categories' );
		if ($term_id == null){
			wp_insert_term(
				$args['options']['category_title'], // the term 
				'lr_categories', // the taxonomy
				array(
					'description'=> 'Leader ' . $args['options']['category_title'] .' category',
					'slug' => $args['options']['category_slug'],
				)
			); 
		}
	}
	/**
	* Registers a Meta Box on our Lead Custom Post Type, called 'Lead Details'
	*/
	public function register_lr_meta_boxes($post) {
		if(get_option('lr_fields')){
			$metaboxs = get_option('lr_fields');
			$callback = 'output_lr_meta_box';
			remove_meta_box( 'slugdiv', $this->plugin_name, 'normal' );
			foreach($metaboxs as $metabox){
				if(isset($metabox->options)){
					if ($metabox->id === 'main-leader-box'){	
						add_meta_box( 'main-lead-name', esc_html__('Leader Name', $this->plugin_name), array( $this, 'lead_meta_box_name'), $this->plugin_name, 'side', 'high',array($metabox));
						add_meta_box( 'main-lead-mail', esc_html__('Mail Box', $this->plugin_name), array( $this, 'lead_meta_box_email'), $this->plugin_name, 'side', 'high',array($metabox));
					}
					add_meta_box( $metabox->id, esc_html__($metabox->options->title, $this->plugin_name), array($this, $callback), $this->plugin_name, $metabox->options->context, $metabox->options->priority, array($metabox));
				}
			}
		}
	}
	/**
	* Output a Lead Details meta box
	*
	* @param WP_Post $post WordPress Post object
	*/
	 public function output_lr_meta_box($post, $metabox) {
		$input_fields = '';
		$html_fields ='';
		$metabox = json_decode(json_encode($metabox['args'][0]));
		if(isset($metabox->options)){
			foreach($metabox->options as $meta_field=>$field_value){
				$my_post_meta = get_post_custom_keys(get_the_ID());
				if(isset($metabox->options->$meta_field->field_type)){
					$field_value = get_post_meta( get_the_ID(), '_'.$meta_field, true );
					switch ($metabox->options->$meta_field->field_type) {
						case 'email':
						case 'tel':
						case 'socials_facebook':
						case 'socials_google_plus':
						case 'socials_linkedin':
						case 'socials_twitter':
						case 'socials_instagram':
						case 'socials_youtube':
						case 'socials_skype':
						case 'socials_messenger':
						case 'text':
						case 'number':
						case 'date':
						case 'url':
						case 'checkbox':
						case 'radio':
							$input_fields .= '<div class="'.$metabox->options->$meta_field->field_bs_col.'">';
							$input_fields .= 	'<div class="form-group bmd-form-group">';
							$input_fields .= 		'<label for="'. $metabox->options->$meta_field->filed_meta .'" class="bmd-label-floating always-float">';
							$input_fields .=			'<i class="'. $metabox->options->$meta_field->filed_icon .'"></i>';
							$input_fields .=			$metabox->options->$meta_field->field_title;
							$input_fields .=		'</label>';
							$input_fields .= 		'<input type="' . $metabox->options->$meta_field->field_type . '" name="'. $meta_field .'" id="'. $metabox->options->$meta_field->filed_meta .'"  class="'. $metabox->options->$meta_field->field_class .'" value="' . esc_attr( $field_value) . '" />';
							$input_fields .= 	'</div>';
							$input_fields .= '</div>';
							break;
						case 'link':
							$input_fields .=   ('<div class="metabox-field ' . $metabox->options->$meta_field->field_class. '">');
							$input_fields .=   ( '<label for="'. $metabox->options->id .'">' . esc_html__( $metabox->options->$meta_field->field_title, $this->plugin_name ) . '</label>' );
							$links = explode(" ", $metabox[$key]['field_value']);
							foreach($links as $link){
								if(!empty($link)){
									$metabox[$key]['links'] .=   ('<a  href="' . $link . '" name="'. $metabox->options->id .'" id="'. $metabox->options->id .'" target=_blank>' . $link . '</a>');
								}
							}
							$input_fields .=   ('</div>');
							break;
						case 'hidden':
							$input_fields .=   ( '<input type="' . $metabox->options->$meta_field->field_type . '" name="'. $metabox->options->$meta_field->filed_meta .'" id="'. $metabox->options->$meta_field->filed_meta .'" value="' . $metabox->options->$meta_field->field_title . '" />' );
							break;
						case 'button':
							$input_fields .=   ('<' . $metabox->options->$meta_field->field_type . ' type="button" class="' . $metabox->options->$meta_field->field_class . '" name="'. $metabox->options->$meta_field->filed_meta .'" id="'. $metabox->options->$meta_field->filed_meta .'" type="'. $metabox->options->$meta_field->field_type .'"	>'. $metabox->options->$meta_field->field_title .'</' . $metabox->options->$meta_field->field_type . '>');
							break;
						case 'textarea':
							$input_fields .='<div class="'.$metabox->options->$meta_field->field_bs_col.'">';
							$input_fields .=	'<div class="form-group">';
							$input_fields .=		'<div class="form-group bmd-form-group">';
							$input_fields .=			'<label for="'.$metabox->options->$meta_field->filed_meta.'" class="bmd-label-floating"><i class="'. $metabox->options->$meta_field->filed_icon .'"></i>' . $metabox->options->$meta_field->field_title . '</label>';
							$input_fields .=			'<textarea name="'. $meta_field .'" id="'. $metabox->options->$meta_field->filed_meta .'" class="form-control" rows="5">' . esc_attr( $field_value) . '</textarea>';
							$input_fields .=		'</div>';
							$input_fields .=	'</div>';
							$input_fields .='</div>';
							break; 
						case 'html':
							$input_fields .=   $metabox->options->$meta_field->field_value;
							break; 
					}
				}
			}
		}
		$html_fields ='';
		// Add a nonce field so we can check for it later.
		wp_nonce_field( 'save_lead', 'leader_nonce' );
		$html_fields .= '<div class="card col-12" id="'.  $metabox->id  .'" >';
		$html_fields .=   	'<div class="card-header card-header-icon">';
		$html_fields .=   		'<div class="card-icon">';
		$html_fields .=   			'<i class="'. $metabox->options->meta_box_class .'" ></i>';
		$html_fields .=   		'</div>';
		if(isset($metabox->options->title)){
			$html_fields .=   		'<h4 class="card-title">'.$metabox->options->title.'</h4>';
			$html_fields .=   	'</div>';
			$html_fields .=   	'<div class="card-body">';
			$html_fields .=   			'<div class="row">';
			$html_fields .=   				$input_fields;
			$html_fields .=   			'</div>';
			$html_fields .=   	'</div>';
			$html_fields .= '</div>';	
			echo $html_fields;
		}	
	}	
	public function lead_meta_box_name($post, $metabox) {
		
		$email = get_post_meta( $post->ID, '_lr_email', true );
		// Add a nonce field so we can check for it later.
		$metabox = json_decode(json_encode($metabox['args'][0]));
		$photo = get_avatar( $email, 128 );
		$url = get_avatar_url( $email, 128 );
		echo 	'<div class="card card-profile">';
		echo 		'<div class="card-avatar">';
		echo 				'<img class="img" src="'.$url.'" srcset="'.$url.'" />';
		echo 		'</div>';
		echo 			'<h4 class="card-title"> <br>'. get_the_title() .'</h4>';
		echo 			'<a id="lr_click_call" class=" btn lr-click-to-call" href=""><i class="fas fa-phone"></i></a>';
		echo 	'</div>';
	}	
	public function lead_meta_box_email($post, $metabox) {
		
		$email = get_post_meta( $post->ID, '_lr_email', true );
		// Add a nonce field so we can check for it later.
		$metabox = json_decode(json_encode($metabox['args'][0]));
		$photo = get_avatar( $email, 128 );
		$url = get_avatar_url( $email, 128 );
		echo '<input id="lr_email_to" type="hidden" value="'.$email.'">';
		echo 	'<div class="card card-profile">';
		echo 		'<div class="card-content">';
		echo 			'<div class="form-group bmd-form-group txt-left-align">';
		echo 				'<label for="lr_email_subject" class="bmd-label-floating">'. esc_html__("Subject" , $this->plugin_name) .'</label>';
		echo				'<input id="lr_email_subject" name="subject" class="form-control" type="text">';
		echo 			'</div>';
		echo 			'<div class="form-group bmd-form-group txt-left-align">';
		echo 				'<label for="lr_email_message" class="bmd-label-floating">'. esc_html__("Message" , $this->plugin_name) .'</label>';
		echo 				'<textarea id="lr_email_message" name="lr_email_message" class="form-control" rows="5" ></textarea>';
		echo 			'</div>';
		echo 			'<button type="button" id="lr_email_send" class="btn lr-email-send" >'. esc_html__("Mail it" , $this->plugin_name) .'</button>';
		echo 		'</div>';
		echo 	'</div>';
	}	
	
	// Ajax Saves the waves from contact form 

	public function lr_save_wave(){
		$current_user = wp_get_current_user();
		$date = new DateTime();
		$message = '';
		$timestamp = $date->getTimestamp();
		if(isset($_POST['post_ID'])){
			$post_id = sanitize_text_field($_POST['post_ID']); 
			if(isset($_POST['subject'])){
				$subject = sanitize_text_field($_POST['subject']);
				if(isset($_POST['message'])){
					$message = sanitize_text_field($_POST['message']);
				}
				$wave_array = array(
					'source' => $current_user->user_firstname .' '. $current_user->user_lastname,
					'subject' => $subject,
					'message' => $message,
					'timestamp' => $timestamp,
				);
				$result = update_post_meta($post_id, '_lr_wave_list_'.$timestamp, $wave_array);
				$this->set_terms( $post_id, $this->plugin_name, 'lr_wave', false );
				echo $result;
				wp_die();
			}
		}
	}
	// Create post type terms
	public function set_terms($object_id, $terms, $taxonomy, $append){
		$term_taxonomy_ids = wp_set_object_terms( $object_id, $terms, $taxonomy, $append);
		if ( is_wp_error( $term_taxonomy_ids ) ) {
			echo "no";
	// There was an error somewhere and the terms couldn't be set.
		} else {
			echo "yes";
			// Success! The post's categories were set.
		}
				
	}
	// Check if email exist if not add to list, return true/false and post id
	private function check_leader_duplicate($post_id, $email, $timestamp ){
		$lr_email_check = array(
				'email' => $email,
				'post_id' => $post_id,
			);
		$email_in_list = false;
		if(get_option('lr_duplicate_fields')){
			
			$lr_duplicate_fields = get_option('lr_duplicate_fields');
			foreach($lr_duplicate_fields as $lr_duplicate_field){
				if($lr_duplicate_field != null){
					if($lr_duplicate_field->email === $email){
						$prev_post_id = $post_id;
						$post_id = $lr_duplicate_field->post_id;
						$email_in_list = true;
						break;
					}
				}
			}
			if(!$email_in_list){
				$lr_duplicate_fields = $this->objToArray(get_option('lr_duplicate_fields'),$arr);
				array_push($lr_duplicate_fields , $lr_email_check);
			}
		}else{
			$lr_duplicate_fields = array($lr_email_check);
		}
		
		update_post_meta($post_id, '_lr_last_correspond', $timestamp);
		$json_lr_duplicate_fields = json_decode(json_encode($lr_duplicate_fields));
		update_option('lr_duplicate_fields', $json_lr_duplicate_fields); 
		return array($post_id, $email_in_list);
	}
	// Ajax Update/create leader on form submit
	public function update_user_wave(){
		$current_user = wp_get_current_user();
		if(isset($_POST['lr_wave_timestamp'])){
			$post_id = '';
			$wave_array = array();
			$lr_wave_timestamp = sanitize_text_field($_POST['lr_wave_timestamp']);
			$lr_email_to = '';
			$lr_email_subject = '';
			$lr_email_message = '';
			$prev_msg = '';
			if(isset($_POST['post_ID'])){
				$post_id = sanitize_text_field($_POST['post_ID']);
				$prev_msg = get_post_meta($post_id, '_lr_wave_list_'.$lr_wave_timestamp);
			}
			if((isset($_POST['lr_wave_status'])) &&(isset($_POST['lr_wave_status_num']))){
				$lr_wave_status = sanitize_text_field($_POST['lr_wave_status']);
				$lr_wave_status_num = sanitize_text_field($_POST['lr_wave_status_num']);
				if($lr_wave_status != ''){
					if($lr_wave_status_num == "1"){
						$status_class = 'lr-red-light';
					} else if($lr_wave_status_num == "2"){
						$status_class = 'lr-orange-light';
					} else if($lr_wave_status_num == "3"){
						$status_class = 'lr-green-light';
					}
					$prev_msg[0]['status'] = '<span class="'.$status_class.'">'.$lr_wave_status.'<span>';	
					$prev_msg[0]['status_class'] = $status_class;	
					update_post_meta($post_id, '_lr_wave_list_'.$lr_wave_timestamp, $prev_msg[0]);
					echo null;
					wp_die();
				}
			}
			if(isset($_POST['lr_email_to'])){
				$lr_email_to = sanitize_email($_POST['lr_email_to']);
			}
			if(isset($_POST['lr_reply_forward'])){
				$lr_reply_forward = sanitize_text_field($_POST['lr_reply_forward']);
				if($lr_reply_forward == 'forward'){
					$reply_forword = esc_html__('Forward to:', $this->plugin_name). ' ' . $lr_email_to;
				} else if($lr_reply_forward == 'reply'){
					$reply_forword = esc_html__('Replied', $this->plugin_name);
					
				}
			}
			if(isset($_POST['lr_email_subject'])){
				$lr_email_subject = sanitize_text_field($_POST['lr_email_subject']);
			}
			if(isset($_POST['lr_email_message'])){
				$lr_email_message = sanitize_textarea_field($_POST['lr_email_message']);
			}
			$date = new DateTime();
			$reply_timestamp = $date->getTimestamp();
			$wave_array = array(
				'source' => $current_user->display_name ,
				'email' => $current_user->user_email,
				'avatar' => get_avatar_url( $current_user->user_email, 128 ),
				'lr_email_to' => $lr_email_to,
				'reply_subject' => $lr_email_subject,
				'message' => $lr_email_message,
				'reply_timestamp' => $reply_timestamp,
				'reply_forword' => $reply_forword,
				'source_timestamp' => $lr_wave_timestamp,
			);
			array_push($prev_msg[0]['message_answer'], $wave_array);	
			update_post_meta($post_id, '_lr_wave_list_'.$lr_wave_timestamp, $prev_msg[0]);
			$response = array(
				'id' =>'lr_wave_list_'.$lr_wave_timestamp,
				'post_id' => $post_id
			);
			$post_url = get_home_url() . '/wp-admin/post.php?post='.$post_id.'&action=edit';
			$lr_email_subject = $email . ' sent you another message';
			$lr_email_message = '<span style="white-space: pre-wrap;">'.$message.'</span><br><a href="'.$post_url.'">'. esc_html__("View Leader card", $this->plugin_name).'</a> or <a href="tel:'.$leader_tel.'">'. esc_html__("click to call", $this->plugin_name).'</a><br><br> <p style="text-align: center;">Sent with &#128140; using  <a href="https://www.leader.codes/" >Leader</a></p>';
			$this->lr_mail_send($current_user->user_email, $email, get_option('admin_email'), $lr_email_subject, $lr_email_message);	
			echo ((json_encode($wave_array))); 
			wp_die();
			////contact forms
		}else if(isset($_GET['fields'])){
			$field_value = '';
			$field_textarea = '';
			$add_to_wave_list = array();
			$date = new DateTime();
			$message = ''; 
			$timestamp = $date->getTimestamp();
			$leader_name ='';
			$is_email = false;
			$is_name = false;
			$is_tel = false;
			$lr_hp = false;
			$leader_email = sanitize_email($fields[0]->value);
			$wave_array = array();
			$fields = json_decode(stripslashes($_GET['fields']));
			$my_post = array(
				'post_type'   => $this->plugin_name,
			);
			foreach($fields as $field ){
				$source = esc_html__( sanitize_text_field($field->source), $this->plugin_name );
				$subject = esc_html__( sanitize_text_field($field->subject), $this->plugin_name );
				$wm = esc_html__( sanitize_text_field($field->wm), $this->plugin_name );
				$tax = esc_html__( sanitize_text_field($field->tax), $this->plugin_name );
				$url = esc_html__( esc_url_raw($field->url), $this->plugin_name );
				$connection = esc_html__($field->connection, $this->plugin_name );
				$connection = wp_kses_post($connection);
				$filed_label = sanitize_text_field($field->label);
				$field_type = sanitize_text_field($field->field_type);
				$field_value_check = $field->value;
				$field_value = sanitize_text_field($field->value);
				if(($filed_label == 'Etner yuor age') && ($field_type == '[type="number"]') ){
					if(strlen($field_value_check) > 0){
						$lr_hp = true;
					}
				}
				if(($field_type == '[type="text"]') && ( $is_name== false) && (!$lr_hp) && (strlen($field_value_check) > 0)){
					$is_name = true;
					$leader_name = $field_value;
				}
				if(($field_type == '[type="email"]') && (!$is_email)){
					$is_email = true;
					$field_value = sanitize_email($field->value);
					$leader_email  = $field_value;
				}
				if(($field_type == '[type="tel"]') && (!$is_tel)){
					$is_tel = true;
					$leader_tel = $field_value;
				}
				if($field_type == 'textarea'){
					$allowed_html = array(
					  'br' => array(),
					);
					$field_value = wp_kses( $field->value, $allowed_html );
					$field_textarea .= wp_kses( $field->value, $allowed_html );
				}
				if(($field_value != '') && ($lr_hp === false)){
					array_push($add_to_wave_list, $filed_label . ': ' . $field_value ); 
				}				
			}
			if($lr_hp === false){
				if(strlen($leader_email) > 0){
					$post_id = wp_insert_post($my_post);
				}
				$message = implode("<br>", $add_to_wave_list);
				$message_tr = implode(", ", $add_to_wave_list);
				$prev_post_id = $post_id;
				$result_array = $this->check_leader_duplicate($post_id, $leader_email, $timestamp);
				$post_id = $result_array[0];
				$email_in_list = $result_array[1];
				if(($is_name) && (strlen($leader_name)>0)){
					update_post_meta($post_id, '_lr_full_name', $leader_name);
				}
				if(($is_name == false) || (($is_name == true) && (strlen($leader_name)<=0))){
					$leader_name =  explode("@", $leader_email);	
					$leader_name =  $leader_name[0];	
					update_post_meta($post_id, '_lr_full_name', $leader_name);					
				}
				if(($is_tel) && (strlen($leader_tel)>0)){
					update_post_meta($post_id, '_lr_mobile_number', $leader_tel);
				}
				$remove_action = remove_action('save_post',array($this,'save_meta_boxes'),10,1);
				if($remove_action){
					remove_action('save_post',array($this,'save_meta_boxes'),10,1);
					$my_post = array(
						'ID'           => $post_id,
						'post_type'   => $this->plugin_name,
						'post_title'   => $leader_name,
					);
					// Update the post into the database
					wp_update_post( $my_post );
					add_action('save_post',array($this,'save_meta_boxes'),10,1);
				}
				if($email_in_list){
					wp_trash_post($prev_post_id);
					wp_delete_post($prev_post_id, true );
				} else{
					update_post_meta($post_id, '_lr_email',$leader_email);
				} 
				$email = get_post_meta( $post_id, '_lr_email', true );
				$wave_array = array(
					'source' => $source,
					'subject' => $subject,
					'connection' => $connection,
					'url' => $url,
					'message' => $message,
					'message_tr' => $message_tr,
					'message_answer' => array(),
					'msg_text' => $field_textarea,
					'timestamp' => $timestamp,
					'status' => '<span class="lr-red-light">'.esc_html__('Open', $this->plugin_name).'</span>',
					'status_class' => 'lr-red-light',
					'status_num' => 1,
					'avatar' => get_avatar_url( $email, 128 ),
				);
				update_post_meta($post_id, '_lr_wave_list_'.$timestamp, $wave_array);
				$response = array(
					'id' =>'lr_wave_list_'.$timestamp,
					'post_id' => $post_id
				);
				$leader_call = '';
				if(strlen($leader_tel)>5){
					$leader_call = ' or <a href="tel:'.$leader_tel.'">'.esc_html__("click to call", $this->plugin_name).'</a>';
				}
				$post_url = get_home_url() . '/wp-admin/post.php?post='.$post_id.'&action=edit';
				$lr_email_subject = $email . ' is now a new Leader';
				$lr_email_message = '<span style="white-space: pre-wrap;">'.$message.'</span><br><a href="'.$post_url.'">'.esc_html__("View Leader card", $this->plugin_name).'</a>'. $leader_call .'<br><br> <p style="text-align: center;">Sent with &#128140; using  <a href="https://www.leader.codes/" >Leader</a></p>' ;    
				
				$this->lr_mail_send($current_user->user_email, $email, get_option('admin_email'), $lr_email_subject, $lr_email_message);
				wp_set_object_terms( $post_id, $tax, 'lr_categories', true);
				$this->lr_welcome_mail($wm, $current_user->user_email, $leader_email);
				echo ($post_id); 
				echo $is_name;
				echo $leader_name;
				wp_die();
			}else{
				echo (0001); 
				wp_die();
			}	 	
		}
	}
	public function lr_welcome_mail($lr_welcome_db, $user_email, $email){
		$lr_wm_subject = '';
		$lr_wm_message = '';
		$fn = ABSPATH . '/lr_welcome_mail.log'; // say you've got a mail.log file in your server root
	   $fp = fopen($fn, 'a');
	   fputs($fp, "Mailer Error: " . $lr_welcome_db ."\n");
	   fclose($fp);
		if(get_option($lr_welcome_db)){
					$wm_settings =(get_option($lr_welcome_db));
					$lr_signature = '';
					
					if(get_option('lr_engaging')){
				$connection_settings =(get_option('lr_engaging'));
				$lr_connection_active = $connection_settings->lr_engaging_active;
				if(get_option('lr_engaging_signature') && (boolean)$lr_connection_active){
					$lr_signature = get_option('lr_engaging_signature');
				}
			}
			$lr_wm_active = $wm_settings->lr_wm_active;
			if((boolean)$lr_wm_active){
				$lr_wm_subject = $wm_settings->lr_wm_subject;
				$lr_wm_message = $wm_settings->lr_wm_message;
				$lr_wm_message = '<span style="white-space: pre-wrap;">'.$lr_wm_message.'</span><br><br>'.$lr_signature.'<p style="text-align: center;">Sent with &#128140; using  <a href="https://www.leader.codes/" >Leader</a></p>';
				$this->lr_mail_send($email, $user_email, get_option('admin_email'), $lr_wm_subject, $lr_wm_message);
			}
		}
	}
	private function lr_mail_send($lr_to, $lr_reply, $lr_cc, $lr_subject, $lr_message){
		$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-Type: text/html; charset=UTF-8' . "\r\n";
			$headers[] = 'Reply-To: <'.$lr_reply.'>';
			$headers[] = 'CC: <'.$lr_cc.'>';
			$sent = wp_mail($lr_to, $lr_subject, $lr_message, $headers);	
	}
	function log_mailer_errors($wp_error){
	   $fn = ABSPATH . '/mail.log'; // say you've got a mail.log file in your server root
	   $fp = fopen($fn, 'a');
	   fputs($fp, "Mailer Error: " . $wp_error->ErrorInfo ."\n");
	   fclose($fp);
	}
	// ajax return list of waves by post id
	public function get_leader_wave_list(){
		$waves = array();
		$needle = '_lr_wave_list_';
		if(isset($_POST['post_ID'])){
			$post_id = sanitize_text_field($_POST['post_ID']); 
			$metas = get_post_custom_keys( $post_id);
			foreach($metas as $meta){
				if( strpos($meta, $needle) !== false ) {
					 $waves = array_merge( $waves,get_post_meta($post_id, $meta, false));
				 }
			}
			echo ((json_encode($waves)));
			wp_die();
		}
	}
		
	/**
	* Saves the meta box field data
	*
	* @param int $post_id Post ID
	*/
	public function save_meta_boxes( $post_id ) {
		
		$post_id = get_the_ID();
		// Check if our nonce is set.
		if ( ! isset( $_POST['leader_nonce'] ) ) {
			return $post_id;    
		}
	 
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['leader_nonce'], 'save_lead' ) ) {
			return $post_id;
		}
	 
		// Check this is the Lead Custom Post Type
		if ( $this->plugin_name != $_POST['post_type'] ) {
			return $post_id;
		}
	 
		// Check the logged in user has permission to edit this post
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	 
		// OK to save meta data
		 
		$metaboxs = get_option('lr_fields');
		$lr_duplicate_fields = array();
		$lr_email_check = array();
		$arr = array();
		$email_in_list = false;
		$lr_debug = '';
		if(get_option('lr_duplicate_fields')){
			$lr_duplicate_fields = get_option('lr_duplicate_fields');
		}
		foreach($metaboxs as $metabox){
			foreach($metabox->options as $lr_field=>$lr_value){								
				if(isset($_POST[$lr_field])){
					$field_value = sanitize_text_field($_POST[$lr_field]);
					// check if email exist, if exist update the leader if not add it to lr_duplicate_fields
					if($lr_field === 'lr_email'){
						$result_array = $this->check_leader_duplicate($post_id, $field_value, '');
						$post_id = $result_array[0];
						$email_in_list = $result_array[1];
					}
					if ((!empty($field_value)) || (get_the_ID() == $post_id)){
						
						update_post_meta($post_id, '_'.$lr_field, $field_value);
						if($lr_field === 'lr_full_name'){
							if ( ! wp_is_post_revision( $post_id ) ){
								 
								$remove_action = remove_action('save_post',array($this,'save_meta_boxes'),10,1);
								if($remove_action){
									remove_action('save_post',array($this,'save_meta_boxes'),10,1);
									$my_post = array(
										'ID'           => $post_id,
										'post_type'   => $this->plugin_name,
										'post_title'   => $field_value,
									);
									// Update the post into the database
									
									wp_update_post( $my_post );
									add_action('save_post',array($this,'save_meta_boxes'),10,1);
								}
							}  
							if((get_the_ID() > $post_id)){
								wp_trash_post( get_the_ID() );
								wp_delete_post( get_the_ID(), true );
							}	 
						}
					}
				}
			}
		} 
		//If email exist redirect to leader page
		if($email_in_list){
			wp_redirect( site_url('/wp-admin/post.php?post='.$post_id.'&action=edit'));
			exit();
		}
	}	
	//change post status from draft to public
	public function filter_post_data($postData, $postarr){
		if (($postData['post_status'] == 'draft') && ($postData['post_type'] == $this->plugin_name)) {
        $postData['post_status'] = 'publish';
		}
		return $postData;
	}
	//update duplicated emails list after leader was deleted
	public function delete_from_duplicated_list($post_id){
		$arrs = array();
		if(get_option('lr_duplicate_fields')){
			$lr_duplicate_fields = $this->objToArray(get_option('lr_duplicate_fields'),$arr);
			foreach($lr_duplicate_fields as $key => $field){
				if($field['post_id'] == $post_id){
					$arrs = array_splice($lr_duplicate_fields, $key, 1);
					$json_lr_duplicate_fields = json_decode(json_encode($lr_duplicate_fields));
					update_option('lr_duplicate_fields', $json_lr_duplicate_fields);
				}
			}
		}
	}	
	public function upload_file(){
        // First check if the file appears on the _FILES array
        if(isset($_FILES)){
			wp_die('');
        }else{
			wp_die('');
		}
	}
	public function lr_creat_hooks(){
		do_action('lr_creat_meta_box', $args);
	}
	
}// Leader_API
