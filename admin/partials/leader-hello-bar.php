<?php
/**

 * Provide a Welcoming message in admin area view for Leader

 *

 * This file is used to markup the admin-facing aspects of the plugin.

 *

 * @link       https://leader.codes

 * @since      1.1.0

 *

 * @package    Leader

 * @subpackage Leader/admin/partials

 */
$lr_hb_active = '';
$lr_hb_checked = '';
$lr_hb_cta = esc_html_x( 'Want to get updates about more cool stuff?', 'Leader Hello Bar Settings', $this->plugin_name );
$lr_hb_cta_button = esc_html_x( 'SUBSCRIBE NOW', 'Leader Hello Bar Settings', $this->plugin_name );
$lr_hb_submit_button = esc_html_x( 'SEND', 'Leader Hello Bar Settings', $this->plugin_name );
$lr_hb_button_redirect = '';
$lr_hb_email_text='';
$lr_hb_name_text='';
$lr_hb_phone_text='';
$lr_hb_name_active='';
$lr_hb_name_active_checked ='checked';
$lr_hb_phone_active='';
$lr_hb_phone_active_checked ='checked';
$lr_hb_name_required_checked = '';
$lr_hb_phone_required_checked = '';

if(get_option('lr_hb')){
	$hb_settings =(get_option('lr_hb'));
	if(isset($hb_settings->lr_hb_active)){$lr_hb_active = $hb_settings->lr_hb_active;}
	if(isset($hb_settings->lr_hb_checked)){$lr_hb_checked = $hb_settings->lr_hb_checked;}
	if(isset($hb_settings->lr_hb_cta)){$lr_hb_cta = $hb_settings->lr_hb_cta;}
	if(isset($hb_settings->lr_hb_cta_button)){$lr_hb_cta_button = $hb_settings->lr_hb_cta_button;}
	if(isset($hb_settings->lr_hb_submit_button)){$lr_hb_submit_button = $hb_settings->lr_hb_submit_button;}
	if(isset($hb_settings->lr_hb_button_redirect)){$lr_hb_button_redirect = $hb_settings->lr_hb_button_redirect;}
	if(isset($hb_settings->lr_hb_email_text)){$lr_hb_email_text = $hb_settings->lr_hb_email_text;}
	if(isset($hb_settings->lr_hb_name_text)){$lr_hb_name_text = $hb_settings->lr_hb_name_text;}
	if(isset($hb_settings->lr_hb_phone_text)){$lr_hb_phone_text = $hb_settings->lr_hb_phone_text;}
	if(isset($hb_settings->lr_hb_name_active)){$lr_hb_name_active = $hb_settings->lr_hb_name_active;}
	if(isset($hb_settings->lr_hb_name_active_checked)){$lr_hb_name_active_checked = $hb_settings->lr_hb_name_active_checked;}
	if(isset($hb_settings->lr_hb_phone_active)){$lr_hb_phone_active = $hb_settings->lr_hb_phone_active;}
	if(isset($hb_settings->lr_hb_phone_active_checked)){$lr_hb_phone_active_checked = $hb_settings->lr_hb_phone_active_checked;}
	if(isset($hb_settings->lr_hb_name_required_checked)){$lr_hb_name_required_checked = $hb_settings->lr_hb_name_required_checked;}
	if(isset($hb_settings->lr_hb_phone_required_checked)){$lr_hb_phone_required_checked = $hb_settings->lr_hb_phone_required_checked;}
}
?> 
<div class="col-md-12">
	<div class="card col-md-12">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="far fa-hand-spock fa-2x"></i>
			</div>
			<h4 class="card-title">
				<div class="form-group">
					<div class="togglebutton">
						<label>
							<input id="lr_hb_active" type="checkbox" <?php echo esc_attr($lr_hb_checked) ?> />
							<?php echo esc_html_x( 'Activate Leader Hello Bar', 'Leader Hello Bar Settings', $this->plugin_name )?>
							<span class="toggle"></span>
						</label>
					</div>
				</div>
			</h4>
		</div>
		<div class="card-body ">
			<h4 class="lr-hb-title"><?php echo esc_html_x( 'Hello Bar', 'Leader Hello Bar Settings', $this->plugin_name )?></h4>
			<div class="row">
				<div class="form-group bmd-form-group col-6">
					<div class="row">
						<div class="form-group bmd-form-group col-12">
							<label for="lr_hb_cta" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Call To action Message', 'Leader Hello Bar Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_hb_cta" value="<?php echo esc_attr($lr_hb_cta) ?>">
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_hb_cta_button" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Call to action button', 'Leader Hello Bar Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_hb_cta_button" value="<?php echo esc_attr($lr_hb_cta_button) ?>">
						</div>
					</div>
					<h6 class="lr-hb-title"><?php echo esc_html_x( 'Requested user details', 'Leader Hello Bar Settings', $this->plugin_name )?></h6>
					<div class="row">
						<div class="form-group bmd-form-group col-9 is-filled">
							<label for="lr_hb_email_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Email', 'Leader Hello Bar Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_hb_email_text" value="<?php echo esc_attr($lr_hb_email_text) ?>">
						</div>
						<div class="form-group bmd-form-group col-9 is-filled">
							<label for="lr_hb_name_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Name', 'Leader Hello Bar Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_hb_name_text" value="<?php echo esc_attr($lr_hb_name_text) ?>">
						</div>
						<div class="form-group col-3 lr-form-filed-rules">
							<div class="togglebutton">
								<label>
									<input id="lr_hb_name_active" type="checkbox" <?php echo esc_attr($lr_hb_name_active_checked) ?> />
									<?php echo esc_html_x( 'hide/show', 'Leader Hello Bar Settings', $this->plugin_name )?>
									<span class="toggle"></span>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<?php echo esc_html_x( 'Required', 'Leader Video Popup Settings', $this->plugin_name )?>
									<input id="lr_hb_name_required" class="form-check-input" type="checkbox" <?php echo esc_attr($lr_hb_name_required_checked) ?>>
									<span class="form-check-sign">
										<span class="check"></span>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group bmd-form-group col-9 is-filled">
							<label for="lr_hb_phone_text" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Phone', 'Leader Hello Bar Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_hb_phone_text" value="<?php echo esc_attr($lr_hb_phone_text) ?>">
						</div>
						<div class="form-group col-3 lr-form-filed-rules">
							<div class="togglebutton">
								<label>
									<input id="lr_hb_phone_active" type="checkbox" <?php echo esc_attr($lr_hb_phone_active_checked) ?> />
									<?php echo esc_html_x( 'hide/show', 'Leader Hello Bar Settings', $this->plugin_name )?>
									<span class="toggle"></span>
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<?php echo esc_html_x( 'Required', 'Leader Hello Bar Settings', $this->plugin_name )?>
									<input id="lr_hb_phone_required" class="form-check-input" type="checkbox" <?php echo esc_attr($lr_hb_phone_required_checked) ?>>
									<span class="form-check-sign">
										<span class="check"></span>
									</span>
								</label>
							</div>
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_hb_submit_button" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Submit button', 'Leader Hello Bar Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_hb_submit_button" value="<?php echo esc_attr($lr_hb_submit_button) ?>">
						</div>
						<div class="form-group bmd-form-group col-12">
							<label for="lr_hb_button_redirect" class="bmd-label-floating always-float"><?php echo esc_html_x( 'Redirect link (if you got any)', 'Leader Hello Bar Settings', $this->plugin_name )?></label>
							<input type="text" class="form-control" id="lr_hb_button_redirect" value="<?php echo esc_attr($lr_hb_button_redirect) ?>">
						</div>
					</div>
				</div>
				<div class="form-group bmd-form-group col-6 lr-inspector">	
					
					<?php echo $this->get_general_settings('lr_hb_gs')?>
					<br>
					<br>
					<?php 
						$lr_setting = array(
							'lr_db' => 'lr_hb_pos',
							'lr_position' => 'vertical',
						);
						echo $this->get_position_settings($lr_setting);
					?>
					<br>
					<br>
					<?php echo $this->get_design_settings('lr_hb_dn')?>
					<br>
					<br>
					<?php echo $this->get_welcome_mail('lr_hb_wm')?>
				</div>
			</div>
		</div>
		<div class="card-footer ">
			<button id="lr_hb_save" class="btn btn-fill btn-rose"><?php echo esc_html_x( 'Save', 'Hello Bar Settings', $this->plugin_name )?></button>
		</div>
	</div>
</div>