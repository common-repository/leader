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

$lr_fb_address = '';
$lr_instegram_address = '';
$lr_whatsapp_address = '';
$lr_fa_youtube = '';
$lr_fa_twitter = '';
$lr_linkedin_in = '';
$lr_sb_active='';


$lr_facebook_sb_active = '';
$lr_instegram_sb_active = '';
$lr_whatsapp_sb_active = '';
$lr_youtube_sb_active = '';
$lr_twitter_sb_active = '';
$lr_linkedin_sb_active = '';

if(get_option('lr_sb')){
	$lr_connection_settings =(get_option('lr_sb'));
	if(isset($lr_connection_settings->lr_sb_active)){$lr_sb_active = $lr_connection_settings->lr_sb_active;}
	if(isset($lr_connection_settings->lr_fb_address)){$lr_fb_address = $lr_connection_settings->lr_fb_address;}
	if(isset($lr_connection_settings->lr_instegram_address)){$lr_instegram_address = $lr_connection_settings->lr_instegram_address;}
	if(isset($lr_connection_settings->lr_whatsapp_address)){$lr_whatsapp_address = $lr_connection_settings->lr_whatsapp_address;}
	if(isset($lr_connection_settings->lr_fa_youtube)){$lr_fa_youtube = $lr_connection_settings->lr_fa_youtube;}
	if(isset($lr_connection_settings->lr_fa_twitter)){$lr_fa_twitter = $lr_connection_settings->lr_fa_twitter;}
	if(isset($lr_connection_settings->lr_linkedin_in)){$lr_linkedin_in = $lr_connection_settings->lr_linkedin_in;}
	if(isset($lr_connection_settings->lr_facebook_sb_active)){$lr_facebook_sb_active = $lr_connection_settings->lr_facebook_sb_active;}
	if(isset($lr_connection_settings->lr_instegram_sb_active)){$lr_instegram_sb_active = $lr_connection_settings->lr_instegram_sb_active;}
	if(isset($lr_connection_settings->lr_whatsapp_sb_active)){$lr_whatsapp_sb_active = $lr_connection_settings->lr_whatsapp_sb_active;}
	if(isset($lr_connection_settings->lr_youtube_sb_active)){$lr_youtube_sb_active = $lr_connection_settings->lr_youtube_sb_active;}
	if(isset($lr_connection_settings->lr_twitter_sb_active)){$lr_twitter_sb_active = $lr_connection_settings->lr_twitter_sb_active;}
	if(isset($lr_connection_settings->lr_linkedin_sb_active)){$lr_linkedin_sb_active = $lr_connection_settings->lr_linkedin_sb_active;}
}
?> 
<div class="col-md-12">
	<div class="card col-12" id="lr-social-presence">
		<div class="card-header card-header-icon">
			<div class="card-icon">
				<i class="far fa-thumbs-up fa-2x"></i>
			</div>
			<h4 class="card-title">
				<div class="form-group">
					<div class="togglebutton">
						<label>
							<input id="lr_sb_active" type="checkbox" <?php echo esc_attr($lr_sb_active) ?> />
							<?php echo esc_html_x( 'Activate Social Bar', 'Leader Social Bar', $this->plugin_name )?>
							<span class="toggle"></span>
						</label>
					</div>
				</div>
			</h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-8">
					Adress
				</div>
				<div class="col-md-2">
					Show/Hide
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12 lr-fb-area">
						<div class="row">
							<div class="form-group bmd-form-group col-md-8">
								<label for="lr_fb_address" class="bmd-label-floating always-float">
									<i class="fab fa-facebook"></i> 
								</label>
								<input name="lr_fb_address" id="lr_fb_address" class="form-control lr-fb-address" value="<?php echo esc_attr($lr_fb_address) ?>" type="url">
							</div>
							<div class="togglebutton col-md-2">
								<label>
									<input id="lr_facebook_sb_active" type="checkbox" <?php echo esc_attr($lr_facebook_sb_active) ?> />
									<span class="toggle"></span>
								</label>
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
							<div class="togglebutton col-md-2">
								<label>
									<br>
									<input id="lr_instegram_sb_active" type="checkbox" <?php echo esc_attr($lr_instegram_sb_active) ?> />
									<span class="toggle"></span>
								</label>
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
							<div class="togglebutton col-md-2">
								<label>
									<br>
									<input id="lr_whatsapp_sb_active" type="checkbox" <?php echo esc_attr($lr_whatsapp_sb_active) ?> />
									<span class="toggle"></span>
								</label>
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
							<div class="togglebutton col-md-2">
								<label>
									<br>
									<input id="lr_youtube_sb_active" type="checkbox" <?php echo esc_attr($lr_youtube_sb_active) ?> />
									<span class="toggle"></span>
								</label>
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
							<div class="togglebutton col-md-2">
								<label>
									<br>
									<input id="lr_twitter_sb_active" type="checkbox" <?php echo esc_attr($lr_twitter_sb_active) ?> />
									<span class="toggle"></span>
								</label>
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
							<div class="togglebutton col-md-2">
								<label>
									<br>
									<input id="lr_linkedin_sb_active" type="checkbox" <?php echo esc_attr($lr_linkedin_sb_active) ?> />
									<span class="toggle"></span>
								</label>
							</div>
						</div>
					</div>
					<div class="card-footer ">
						<button id="lr_sb_save" class="btn btn-fill btn-rose"><?php echo esc_html_x( 'Save Social Bar', 'Leader Social Bar Settings', $this->plugin_name )?></button>
					</div>
				</div>
			</div>
		</div>
	 </div> 
 </div>