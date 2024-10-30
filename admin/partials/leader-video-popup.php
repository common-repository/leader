<?php



/**

 * Provide a Welcoming message in admin area view for Leader

 *

 * This file is used to markup the admin-facing aspects of the plugin.

 *

 * @link       https://leader.codes

 * @since      2.0.5

 *

 * @package    Leader

 * @subpackage Leader/admin/partials

 */
$lr_vp_active = '';
$lr_vp_checked = '';
$lr_vp_cta = esc_html_x( 'Want to get more great videos for free?', 'Leader Video Popup Settings', $this->plugin_name );
$lr_vp_cta_button = esc_html_x( 'SUBSCRIBE NOW', 'Leader Video Popup Settings', $this->plugin_name );
$lr_vp_submit_button = esc_html_x( 'SEND', 'Leader Video Popup Settings', $this->plugin_name );
$lr_vp_button_redirect = '';
$lr_vp_video_link = '';
$lr_vp_email_text='';
$lr_vp_name_text='';
$lr_vp_phone_text='';
$lr_vp_name_active_checked='checked';
$lr_vp_phone_active_checked='checked';
$lr_vp_name_required_checked='';
$lr_vp_phone_required_checked='';

if(get_option('lr_vp')){
	$vp_settings =(get_option('lr_vp'));
	if(isset($vp_settings->lr_vp_active)){$lr_vp_active = $vp_settings->lr_vp_active;}
	if(isset($vp_settings->lr_vp_checked)){$lr_vp_checked = $vp_settings->lr_vp_checked;}
	if(isset($vp_settings->lr_vp_cta)){$lr_vp_cta = $vp_settings->lr_vp_cta;}
	if(isset($vp_settings->lr_vp_cta_button)){$lr_vp_cta_button = $vp_settings->lr_vp_cta_button;}
	if(isset($vp_settings->lr_vp_button_redirect)){$lr_vp_button_redirect = $vp_settings->lr_vp_button_redirect;}
	if(isset($vp_settings->lr_vp_submit_button)){$lr_vp_submit_button = $vp_settings->lr_vp_submit_button;}
	if(isset($vp_settings->lr_vp_video_link)){$lr_vp_video_link = $vp_settings->lr_vp_video_link;}
	if(isset($vp_settings->lr_vp_email_text)){$lr_vp_email_text = $vp_settings->lr_vp_email_text;}
	if(isset($vp_settings->lr_vp_name_text)){$lr_vp_name_text = $vp_settings->lr_vp_name_text;}
	if(isset($vp_settings->lr_vp_phone_text)){$lr_vp_phone_text = $vp_settings->lr_vp_phone_text;}
	if(isset($vp_settings->lr_vp_name_active_checked)){$lr_vp_name_active_checked = $vp_settings->lr_vp_name_active_checked;}
	if(isset($vp_settings->lr_vp_phone_active_checked)){$lr_vp_phone_active_checked = $vp_settings->lr_vp_phone_active_checked;}
	if(isset($vp_settings->lr_vp_name_required_checked)){$lr_vp_name_required_checked = $vp_settings->lr_vp_name_required_checked;}
	if(isset($vp_settings->lr_vp_phone_required_checked)){$lr_vp_phone_required_checked = $vp_settings->lr_vp_phone_required_checked;}
}
?> 
<div class="col-md-12">
	<div class="card col-md-12">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="fab fa-youtube fa-2x"></i>
			</div>
			<h4 class="card-title">
				<div class="form-group">
					<div class="togglebutton">
						<label>
							<input id="lr_vp_active" type="checkbox" <?php echo esc_attr($lr_vp_checked) ?> />
							<?php echo esc_html_x( 'Activate Leader Video Popup', 'Leader Video Popup Settings', $this->plugin_name )?>
							<span class="toggle"></span>
						</label>
					</div>
				</div>
			</h4>
		</div>
		<div class="card-body ">
			<h4 class="lr-hb-title"><?php echo esc_html_x( 'Video Popup', 'Leader Video Popup Settings', $this->plugin_name )?></h4>
			<div class="row">
				<div class="form-group bmd-form-group col-6">
					<div class="row">
						<div class="form-group bmd-form-group col-12">
							<label for="lr_vp_cta" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Call To action Message', 'Leader Video Popup Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_vp_cta" value="<?php echo esc_attr($lr_vp_cta) ?>">
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_vp_cta_button" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Button Text', 'Leader Video Popup Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_vp_cta_button" value="<?php echo esc_attr($lr_vp_cta_button) ?>">
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_vp_button_redirect" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Redirect link (if you got any)', 'Leader Video Popup Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_vp_button_redirect" value="<?php echo esc_attr($lr_vp_button_redirect) ?>">
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_vp_video_link" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Youtube Link', 'Leader Video Popup Settings', $this->plugin_name )?></label>
							<input type="url" class="form-control" id="lr_vp_video_link" value="<?php echo esc_attr($lr_vp_video_link) ?>">
						</div>
					</div>
					<h6 class="lr-hb-title"><?php echo esc_html_x( 'Form settings', 'Leader Video Popup Settings', $this->plugin_name )?></h6>
					<div class="row">
						<div class="form-group bmd-form-group col-9">
							<label for="lr_vp_email_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Email', 'Leader Video Popup Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_vp_email_text" value="<?php echo esc_attr($lr_vp_email_text) ?>">
						</div>
						<div class="form-group bmd-form-group col-9">
							<label for="lr_vp_name_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Name', 'Leader Video Popup Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_vp_name_text" value="<?php echo esc_attr($lr_vp_name_text) ?>">
						</div>
						<div class="form-group col-3 lr-form-filed-rules">
							<div class="togglebutton">
								<label>
									<input id="lr_vp_name_active" type="checkbox" <?php echo esc_attr($lr_vp_name_active_checked) ?> />
									<?php echo esc_html_x( 'hide/show', 'Leader Video Popup Settings', $this->plugin_name )?>
									<span class="toggle"></span>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label" for="lr_vp_name_required">
									<?php echo esc_html_x( 'Required', 'Leader Video Popup Settings', $this->plugin_name )?>
									<input id="lr_vp_name_required" class="form-check-input" type="checkbox" <?php echo esc_attr($lr_vp_name_required_checked) ?>>
									<span class="form-check-sign">
										<span class="check"></span>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group bmd-form-group col-9">
							<label for="lr_vp_phone_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Phone', 'Leader Video Popup Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_vp_phone_text" value="<?php echo esc_attr($lr_vp_phone_text) ?>">
						</div>
						<div class="form-group col-3 lr-form-filed-rules">
							<div class="togglebutton">
								<label>
									<input id="lr_vp_phone_active" type="checkbox" <?php echo esc_attr($lr_vp_phone_active_checked) ?> />
									<?php echo esc_html_x( 'hide/show', 'Leader Video Popup Settings', $this->plugin_name )?>
									<span class="toggle"></span>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<?php echo esc_html_x( 'Required', 'Leader Video Popup Settings', $this->plugin_name )?>
									<input id="lr_vp_phone_required" class="form-check-input" type="checkbox" <?php echo esc_attr($lr_vp_phone_required_checked) ?>>
									<span class="form-check-sign">
										<span class="check"></span>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_vp_submit_button" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Submit button', 'Video Popup Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_vp_submit_button" value="<?php echo esc_attr($lr_vp_submit_button) ?>">
						</div>
					</div>
				</div>
				<div class="form-group bmd-form-group col-6 lr-inspector">	
					<?php echo $this->get_general_settings('lr_hb_gs')?>
					<br>
					<br>
					<?php echo $this->get_design_settings('lr_vp_dn')?>
					<br>
					<br>
					<?php echo $this->get_welcome_mail('lr_vp_wm')?>
				</div>
			</div>
		</div>
		<div class="card-footer ">
			<button id="lr_vp_save" class="btn btn-fill btn-rose"><?php echo esc_html_x( 'Save', 'Video Popup Settings', $this->plugin_name )?></button>
		</div>
	</div>
</div>