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
$lr_full_name = '';
$lr_position = '';
$lr_phone_number = '';
$lr_mobile_number = '';
$lr_email = '';
$lr_website = '';
$lr_address = '';
$lr_fb_address = '';
$lr_instegram_address = '';
$lr_whatsapp_address = '';
$lr_fa_youtube = '';
$lr_fa_twitter = '';
$lr_linkedin_in = '';
$lr_engaging_active='';
$lr_engaging_signature = '';
$image_attachment_id='';
$lr_social_img = '';
$screen = get_current_screen();
$current_menu_id = strpos($screen->id, "leader_engaging");
if(get_option('lr_engaging_signature')){
	$lr_engaging_signature = get_option('lr_engaging_signature');
}
if(get_option('lr_engaging')){
	$lr_connection_settings =(get_option('lr_engaging'));
	if(isset($lr_connection_settings->lr_full_name)){$lr_full_name = $lr_connection_settings->lr_full_name;}
	if(isset($lr_connection_settings->lr_position)){$lr_position = $lr_connection_settings->lr_position;}
	if(isset($lr_connection_settings->lr_phone_number)){$lr_phone_number = $lr_connection_settings->lr_phone_number;}
	if(isset($lr_connection_settings->lr_mobile_number)){$lr_mobile_number = $lr_connection_settings->lr_mobile_number;}
	if(isset($lr_connection_settings->lr_email)){$lr_email = $lr_connection_settings->lr_email;}
	if(isset($lr_connection_settings->lr_website)){$lr_website = $lr_connection_settings->lr_website;}
	if(isset($lr_connection_settings->lr_address)){$lr_address = $lr_connection_settings->lr_address;}
	if(isset($lr_connection_settings->lr_fb_address)){$lr_fb_address = $lr_connection_settings->lr_fb_address;}
	if(isset($lr_connection_settings->lr_instegram_address)){$lr_instegram_address = $lr_connection_settings->lr_instegram_address;}
	if(isset($lr_connection_settings->lr_whatsapp_address)){$lr_whatsapp_address = $lr_connection_settings->lr_whatsapp_address;}
	if(isset($lr_connection_settings->lr_fa_youtube)){$lr_fa_youtube = $lr_connection_settings->lr_fa_youtube;}
	if(isset($lr_connection_settings->lr_fa_twitter)){$lr_fa_twitter = $lr_connection_settings->lr_fa_twitter;}
	if(isset($lr_connection_settings->lr_linkedin_in)){$lr_linkedin_in = $lr_connection_settings->lr_linkedin_in;}
	if(isset($lr_connection_settings->lr_engaging_active)){$lr_engaging_active = $lr_connection_settings->lr_engaging_active;}
	if(isset($lr_connection_settings->image_attachment_id)){
		$image_attachment_id = $lr_connection_settings->image_attachment_id;
		if($image_attachment_id > 0){
			$lr_social_img = esc_attr(wp_get_attachment_url($image_attachment_id));
		}
	}
	if(isset($lr_connection_settings->image_attachment_id)){$image_attachment_id = $lr_connection_settings->image_attachment_id;}
}

?> 
<div class="col-md-12">
	<div class="card col-12" id="lr-social-presence">
		<div class="card-header card-header-icon">
			<div class="card-icon">
				<i class="fas fa-signature fa-2x"></i>
			</div>
			<h4 class="card-title">
				<div class="form-group">
					<div class="togglebutton">
						<label>
							<input id="lr_engaging_active" type="checkbox" <?php echo esc_attr($lr_engaging_active) ?> />
							<?php echo esc_html_x( 'Activate signature', 'Leader Signature', $this->plugin_name )?>
							<span class="toggle"></span>
						</label>
					</div>
				</div>
			</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="form-group bmd-form-group col-12">
					<div class="fileinput fileinput-new text-center" data-provides="fileinput">
						<?php if(strlen($lr_social_img) > 1){ ?>
							<div class="fileinput-new thumbnail">
								<img id='image-preview' src='<?php echo $lr_social_img ?>' width='100' height='100' style='max-height: 100px; width: 100px;'>
							</div>
							<div class="fileinput-preview fileinput-exists thumbnail"></div>
						<?php } ?>
						<div>
						  <span class="btn btn-rose btn-round btn-file btn-sm">
							<span class="fileinput-new"><?php _e('Upload image'); ?></span>
							<input id="upload_image_button" type="button" class="button" value="<?php _e( 'Upload image' ); ?>" />
							<input type="hidden" name="image_attachment_id" id="image_attachment_id" value="" data-image_attachment_id="<?php echo $image_attachment_id?>" data-current_menu_id="<?php echo $current_menu_id?>" >
						  </span>
						  <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
						</div>
					</div>
				</div>	
				<div class="col-md-4">
					<div class="row">
						<div class="col-12">
							<div class="form-group bmd-form-group">
								<label for="lr_full_name" class="bmd-label-floating always-float">
									<i class="fas fa-user-circle"></i> <?php echo esc_html_x('Full name', 'Leader Signature', $this->plugin_name)?>
								</label>
								<input name="lr_full_name" id="lr_full_name" class="form-control lr-full-name" value="<?php echo esc_attr($lr_full_name) ?>" type="text">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group bmd-form-group">
								<label for="lr_position" class="bmd-label-floating always-float">
									<i class="fas fa-user-md"></i> <?php echo esc_html_x('Position', 'Leader Signature', $this->plugin_name)?>
								</label>
								<input name="lr_position" id="lr_position" class="form-control lr-position" value="<?php echo esc_attr($lr_position) ?>" type="text">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group bmd-form-group">
								<label for="lr_phone_number" class="bmd-label-floating always-float">
									<i class="fas fa-phone-square"></i> <?php echo esc_html_x('Land-line', 'Leader Signature', $this->plugin_name)?>
								</label>
								<input name="lr_phone_number" id="lr_phone_number" class="form-control lr-phone-number" value="<?php echo esc_attr($lr_phone_number) ?>" type="tel">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group bmd-form-group">
								<label for="lr_mobile_number" class="bmd-label-floating always-float">
									<i class="fas fa-mobile-alt"></i> <?php echo esc_html_x('Mobile', 'Leader Signature', $this->plugin_name)?>
								</label>
								<input name="lr_mobile_number" id="lr_mobile_number" class="form-control lr-mobile-number" value="<?php echo esc_attr($lr_mobile_number) ?>" type="tel">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group bmd-form-group">
								<label for="lr_email" class="bmd-label-floating always-float">
									<i class="fas fa-user-md"></i> <?php echo esc_html_x('Email address', 'Leader Signature', $this->plugin_name)?>
								</label>
								<input name="lr_email" id="lr_email" class="form-control lr-email" value="<?php echo esc_attr($lr_email) ?>" type="email">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group bmd-form-group">
								<label for="lr_address" class="bmd-label-floating always-float">
									<i class="far fa-map"></i> <?php echo esc_html_x('Address', 'Leader Signature', $this->plugin_name)?>
								</label>
								<textarea name="lr_address" id="lr_address" class="form-control lr-address" rows="5"><?php echo esc_attr($lr_address) ?></textarea>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group bmd-form-group">
								<label for="lr_website" class="bmd-label-floating always-float">
									<i class="fas fa-link"></i> <?php echo esc_html_x('Website', 'Leader Signature', $this->plugin_name)?>
								</label>
								<input name="lr_website" id="lr_website" class="form-control lr-website" value="<?php echo esc_attr($lr_website) ?>" type="url">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-5 lr-inspector lr-inspector-siganture">
					<div class="col-md-12 lr-fb-area">
						<div class="row">
							<div class="form-group bmd-form-group col-md-8">
								<label for="lr_fb_address" class="bmd-label-floating always-float">
									<i class="fab fa-facebook"></i> 
								</label>
								<input name="lr_fb_address" id="lr_fb_address" class="form-control lr-fb-address" value="<?php echo esc_attr($lr_fb_address) ?>" type="url">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="form-group bmd-form-group col-md-8">
								<label for="lr_instegram_address" class="bmd-label-floating always-float">
									<i class="fab fa-instagram"></i> 
								</label>
								<input name="lr_instegram_address" id="lr_instegram_address" class="form-control lr-instegram-address" value="<?php echo esc_attr($lr_instegram_address) ?>" type="url">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="form-group bmd-form-group col-md-8">
								<label for="lr_wa_address" class="bmd-label-floating always-float">
									<i class="fab fa-whatsapp"></i>
								</label>
								<input name="lr_whatsapp_address" id="lr_whatsapp_address" class="form-control lr-whatsapp-address" value="<?php echo esc_attr($lr_whatsapp_address) ?>" type="tel">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="form-group bmd-form-group col-md-8">
								<label for="lr_fa_youtube" class="bmd-label-floating always-float">
									<i class="fab fa-youtube"></i> 
								</label>
								<input name="lr_fa_youtube" id="lr_fa_youtube" class="form-control lr-fa-youtube" value="<?php echo esc_attr($lr_fa_youtube) ?>" type="url">
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="row">
							<div class="form-group bmd-form-group col-md-8">
								<label for="lr_fa_twitter" class="bmd-label-floating always-float">
									<i class="fab fa-twitter"></i> 
								</label>
								<input name="lr_fa_twitter" id="lr_fa_twitter" class="form-control  lr-fa-twitter" value="<?php echo esc_attr($lr_fa_twitter) ?>" type="url">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="form-group bmd-form-group col-md-8">
								<label for="lr_linkedin_in" class="bmd-label-floating always-float">
									<i class="fab fa-linkedin-in"></i> 
								</label>
								<input name="lr_linkedin_in" id="lr_linkedin_in" class="form-control lr-linkedin-in" value="<?php echo esc_attr($lr_linkedin_in) ?>" type="url">
							</div>
						</div>
					</div>
				</div>
				
				<div id="signature" class="col-md-3">
					<?php echo $lr_engaging_signature ?>
				</div>
			</div>
		</div>
		<div class="card-footer ">
			<button id="lr_engaging_save" class="btn btn-fill btn-rose"><?php echo esc_html_x( 'Save', 'Leader Signature Settings', $this->plugin_name )?></button>
		</div>
	 </div>	 
 </div>