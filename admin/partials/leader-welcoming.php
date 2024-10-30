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
$lr_wm_active = '';
$lr_wm_subject = esc_html__( 'Welcome', $this->plugin_name );
$lr_wm_message = esc_html__( 'Thank you for contacting us. We will get back to you as soon as we can.',  $this->plugin_name );
if(get_option('lr_wm')){
	$wm_settings =(get_option('lr_wm'));
	if(isset($wm_settings->lr_wm_active)){$lr_wm_active = $wm_settings->lr_wm_active;}
	if(isset($wm_settings->lr_wm_subject)){$lr_wm_subject = $wm_settings->lr_wm_subject;}
	if(isset($wm_settings->lr_wm_message)){$lr_wm_message = $wm_settings->lr_wm_message;}
}

?> 
<div class="col-md-12">
	<div class="card col-md-12">
		<div class="card-header card-header-rose card-header-icon">
			<div class="card-icon">
				<i class="material-icons">mail_outline</i>
			</div>
			<h4 class="card-title">
				<div class="form-group">
					<div class="togglebutton">
						<label>
							<input id="lr_wm_active" type="checkbox" <?php echo esc_attr($lr_wm_active) ?> />
							<?php echo esc_html_x( 'Activate Welcome message', 'Welcome message Settings', $this->plugin_name )?>
							<span class="toggle"></span>
						</label>
					</div>
				</div>
			</h4>
		</div>
		<div class="card-body ">
			<div class="form-group bmd-form-group">
				<label for="lr_wm_subject" class="bmd-label-floating"><?php echo esc_html_x( 'Subject', 'Welcome message Settings', $this->plugin_name )?></label>
				<input type="text" class="form-control" id="lr_wm_subject" value="<?php echo esc_attr($lr_wm_subject) ?>">
			</div>
			<div class="form-group bmd-form-group">
				<label for="lr_wm_message" class="bmd-label-floating"><?php echo esc_html_x( 'Message', 'Welcome message Settings', $this->plugin_name )?></label>
				<textarea rows="4" cols="50" class="form-control" id="lr_wm_message"><?php echo esc_textarea($lr_wm_message) ?></textarea>
			</div>
		</div>
		<div class="card-footer ">
			<button id="lr_wm_save" class="btn btn-fill btn-rose"><?php echo esc_html_x( 'Save', 'Welcome message Settings', $this->plugin_name )?></button>
		</div>
	</div>
</div>