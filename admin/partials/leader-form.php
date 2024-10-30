<?php



/**

 * Provide a Welcoming message in admin area view for Leader

 *

 * This file is used to markup the admin-facing aspects of the plugin.

 *

 * @link       https://leader.codes

 * @since      2.5.0

 *

 * @package    Leader

 * @subpackage Leader/admin/partials

 */
$lr_form_active = '';
$lr_form_checked = '';
$lr_form_cta = esc_html_x( 'Contact us', 'Leader Contact Form Settings', $this->plugin_name );
$lr_form_button_text = esc_html_x( 'SEND', 'Leader Contact Form Settings', $this->plugin_name );
$lr_form_button_redirect = '';
$lr_form_email_text='';
$lr_form_name_text='';
$lr_form_phone_text='';
$lr_form_msg_text='';
$lr_form_name_active_checked='checked';
$lr_form_phone_active_checked='checked';
$lr_form_msg_active_checked='checked';
$lr_form_name_required_checked='';
$lr_form_phone_required_checked='';
$lr_form_msg_required_checked='';
$image_attachment_id='';
$lr_form_img = plugin_dir_url( __FILE__ ) . '../images/lr_contact_us_assitent.png';
if(get_option('lr_form')){
	$frm_settings =(get_option('lr_form'));
	if(isset($frm_settings->lr_form_active)){$lr_form_active = $frm_settings->lr_form_active;}
	if(isset($frm_settings->lr_form_checked)){$lr_form_checked = $frm_settings->lr_form_checked;}
	if(isset($frm_settings->lr_form_cta)){$lr_form_cta = $frm_settings->lr_form_cta;}
	if(isset($frm_settings->lr_form_button_text)){$lr_form_button_text = $frm_settings->lr_form_button_text;}
	if(isset($frm_settings->lr_form_button_redirect)){$lr_form_button_redirect = $frm_settings->lr_form_button_redirect;}
	if(isset($frm_settings->lr_form_email_text)){$lr_form_email_text = $frm_settings->lr_form_email_text;}
	if(isset($frm_settings->lr_form_name_text)){$lr_form_name_text = $frm_settings->lr_form_name_text;}
	if(isset($frm_settings->lr_form_phone_text)){$lr_form_phone_text = $frm_settings->lr_form_phone_text;}
	if(isset($frm_settings->lr_form_msg_text)){$lr_form_msg_text = $frm_settings->lr_form_msg_text;}
	if(isset($frm_settings->lr_form_name_active_checked)){$lr_form_name_active_checked = $frm_settings->lr_form_name_active_checked;}
	if(isset($frm_settings->lr_form_phone_active_checked)){$lr_form_phone_active_checked = $frm_settings->lr_form_phone_active_checked;}
	if(isset($frm_settings->lr_form_msg_active_checked)){$lr_form_msg_active_checked = $frm_settings->lr_form_msg_active_checked;}
	if(isset($frm_settings->lr_form_name_required_checked)){$lr_form_name_required_checked = $frm_settings->lr_form_name_required_checked;}
	if(isset($frm_settings->lr_form_phone_required_checked)){$lr_form_phone_required_checked = $frm_settings->lr_form_phone_required_checked;}
	if(isset($frm_settings->lr_form_msg_required_checked)){$lr_form_msg_required_checked = $frm_settings->lr_form_msg_required_checked;}
	if(isset($frm_settings->image_attachment_id)){
		$image_attachment_id = $frm_settings->image_attachment_id;
		if($image_attachment_id > 0){
			$lr_form_img = esc_attr(wp_get_attachment_url($image_attachment_id));
		}
	}
}

?> 
<div class="col-md-12">
	<div class="card col-md-12">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="fab fa-wpforms fa-2x"></i>
			</div>
			<h4 class="card-title">
				<div class="form-group">
					<div class="togglebutton">
						<label>
							<input id="lr_form_active" type="checkbox" <?php echo esc_attr($lr_form_checked) ?> />
							<?php echo esc_html_x( 'Activate Leader Contact Form', 'Leader Contact Form Settings', $this->plugin_name )?>
							<span class="toggle"></span>
						</label>
					</div>
				</div>
			</h4>
		</div>
		<div class="card-body ">
			<h4 class="lr-hb-title"><?php echo esc_html_x( 'Contact Form', 'Leader Contact Form Settings', $this->plugin_name )?></h4>
			<div class="row">
				<div class="form-group bmd-form-group col-6">
					<div class="row">
						<div class="form-group bmd-form-group col-12">
							<label for="upload_image_button" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Call to action image', 'Leader Contact Form Settings', $this->plugin_name )?></label>
							<br>
							<div class="fileinput fileinput-new text-center" data-provides="fileinput">
								<div class="fileinput-new thumbnail">
									<img id='image-preview' src='<?php echo $lr_form_img ?>' width='100' height='100' style='max-height: 100px; width: 100px;'>
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail"></div>
								<div>
								  <span class="btn btn-rose btn-round btn-file btn-sm">
									<span class="fileinput-new"><?php _e('Change image'); ?></span>
									<input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
									<input type="hidden" name="image_attachment_id" id="image_attachment_id" value="" data-image_attachment_id="<?php echo $image_attachment_id?>" data-current_menu_id="<?php echo $current_menu_id?>" >
								  </span>
								  <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
								</div>
							</div>
						</div>	
						<div class="form-group bmd-form-group col-12">
							<label for="lr_form_cta" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Call To action Message', 'Leader Contact Form Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_form_cta" value="<?php echo esc_attr($lr_form_cta) ?>">
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_form_button_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Button Text', 'Leader Contact Form Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_form_button_text" value="<?php echo esc_attr($lr_form_button_text) ?>">
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_form_button_redirect" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Redirect link (if you got any)', 'Leader Contact Form Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_form_button_redirect" value="<?php echo esc_attr($lr_form_button_redirect) ?>">
						</div>
					</div>
					<h6 class="lr-hb-title"><?php echo esc_html_x( 'Requested user details', 'Leader Contact Form Settings', $this->plugin_name )?></h6>
					<div class="row">
						<div class="form-group bmd-form-group col-9 is-filled">
							<label for="lr_form_email_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Email', 'Leader Contact Form Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_form_email_text" value="<?php echo esc_attr($lr_form_email_text) ?>">
						</div>
						<div class="form-group bmd-form-group col-9 is-filled">
							<label for="lr_form_name_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Name', 'Leader Contact Form Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_form_name_text" value="<?php echo esc_attr($lr_form_name_text) ?>">
						</div>
						<div class="form-group col-3 lr-form-filed-rules">
							<div class="togglebutton">
								<label>
									<input id="lr_form_name_active" type="checkbox" <?php echo esc_attr($lr_form_name_active_checked) ?> />
									<?php echo esc_html_x( 'hide/show', 'Leader Contact Form Settings', $this->plugin_name )?>
									<span class="toggle"></span>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<?php echo esc_html_x( 'Required', 'Leader Contact Form Settings', $this->plugin_name )?>
									<input id="lr_form_name_required" class="form-check-input" type="checkbox" <?php echo esc_attr($lr_form_name_required_checked) ?>>
									<span class="form-check-sign">
										<span class="check"></span>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group bmd-form-group col-9 is-filled">
							<label for="lr_form_phone_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Phone', 'Leader Contact Form Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_form_phone_text" value="<?php echo esc_attr($lr_form_phone_text) ?>">
						</div>
						<div class="form-group col-3 lr-form-filed-rules">
							<div class="togglebutton">
								<label>
									<input id="lr_form_phone_active" type="checkbox" <?php echo esc_attr($lr_form_phone_active_checked) ?> />
									<?php echo esc_html_x( 'hide/show', 'Leader Contact Form Settings', $this->plugin_name )?>
									<span class="toggle"></span>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<?php echo esc_html_x( 'Required', 'Leader Contact Form Settings', $this->plugin_name )?>
									<input id="lr_form_phone_required" class="form-check-input" type="checkbox" <?php echo esc_attr($lr_form_phone_required_checked) ?>>
									<span class="form-check-sign">
										<span class="check"></span>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group bmd-form-group col-9 is-filled">
							<label for="lr_form_msg_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Message', 'Leader Contact Form Settings', $this->plugin_name )?></label>
							<textarea type="text" class="form-control" id="lr_form_msg_text"><?php echo esc_attr($lr_form_msg_text) ?></textarea>
						</div>
						<div class="form-group col-3 lr-form-filed-rules">
							<div class="togglebutton">
								<label>
									<input id="lr_form_msg_active" type="checkbox" <?php echo esc_attr($lr_form_msg_active_checked) ?> />
									<?php echo esc_html_x( 'hide/show', 'Leader Contact Form Settings', $this->plugin_name )?>
									<span class="toggle"></span>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<?php echo esc_html_x( 'Required', 'Leader Contact Form Settings', $this->plugin_name )?>
									<input id="lr_form_msg_required" class="form-check-input" type="checkbox" <?php echo esc_attr($lr_form_msg_required_checked) ?>>
									<span class="form-check-sign">
										<span class="check"></span>
									</span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group bmd-form-group col-6 lr-inspector">	
					
					<?php echo $this->get_general_settings('lr_form_gs')?>
					<br>
					<br>
					<?php 
						$lr_setting = array(
							'lr_db' => 'lr_form_pos',
							'lr_position' => 'horizontal',
						);
						echo $this->get_position_settings($lr_setting);
					?>
					<br>
					<br>
					<?php echo $this->get_design_settings('lr_form_dn');?>
					<br>
					<br>
					<?php echo $this->get_welcome_mail('lr_form_wm');?>
				</div>
			</div>
		</div>
		<div class="card-footer ">
			<button id="lr_form_save" class="btn btn-fill btn-rose"><?php echo esc_html_x( 'Save', 'Contact Form Settings', $this->plugin_name )?></button>
		</div>
	</div>
</div>