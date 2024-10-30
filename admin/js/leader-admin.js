( function( $ ){
	$('#addMetaBoxBtn').on('click', function(){
		var metaBoxTitle = $('#metaBoxTitle').val();
		$.ajax({
		 method: 'GET',
		 url: ajaxurl ,
		 action: 'user_add_meta_box',
		 data: {
			 metaBoxTitle: metaBoxTitle,
		 },
		 success:function(response){
			 $('#addMetaBox').after(response);
		   },
		 error: function (request, status, error) {
			console.log(request.responseText + "  " + error); 
		} 
	  })
	  .done(function( msg ) {
		  $('#addMetaBox').after(msg);
	  });
	});
	if(($('#lr_email.lr-check-mail').length > 0) && ($('#lr_email.lr-check-mail').val().length > 0)){
		$('#lr_email.lr-check-mail').attr('disabled','disabled');
	} 
	$('#lr_email_send').click(function(event){
		event.preventDefault();
		var $lr_email_to = $('#lr_email_to').val();
		var $lr_email_subject = $('#lr_email_subject').val();
		var $lr_email_message = $('#lr_email_message').val();
		send_email($lr_email_to, $lr_email_subject, $lr_email_message);
	});
	$(document).on('click', '.lr-wave-reply-send', function(event){
		event.preventDefault();
		var $lr_email_to = $('#lr_email_to').val();
		var $lr_email_subject = $(this).closest('td').find('.lr-wave-subject').val();
		var $lr_email_message = $(this).closest('div.message-reply').find('.lr-wave-reply').val().replace('\n','<br />');
		var $lr_wave_timestamp = $(this).closest('td').find('.lr-wave-timestamp').val();
		update_wave($lr_email_to, $lr_email_subject, $lr_email_message, $lr_wave_timestamp, '', '', 'reply');
		send_email($lr_email_to, $lr_email_subject, $lr_email_message);
		$(this).closest('div.message-reply').find('.lr-wave-reply').val('');
		var orig_timestamp = $(this).closest('tr').attr('data-timestamp');
		$('html, body').animate({ scrollTop: $('#timeline_'+ orig_timestamp).offset().top }, 500);
	}); 
	$(document).on('click', '.lr-wave-forward-send', function(event){
		event.preventDefault();
		var $lr_email_message_all = '';
		var $lr_email_to = $(this).closest('div.message-forward').find('.lr-wave-forward-to').val();
		var $lr_email_subject = $(this).closest('td').find('.lr-wave-subject').val();
		var $lr_email_message = $(this).closest('div.message-forward').find('.lr-wave-forward').val();
		var $lr_wave_timestamp = $(this).closest('td').find('.lr-wave-timestamp').val();
		update_wave($lr_email_to, $lr_email_subject, $lr_email_message, $lr_wave_timestamp, '', '', 'forward');
		send_email($lr_email_to, $lr_email_subject, $lr_email_message);
		
		if(($lr_email_to.length > 0) && (utils.validateEmail($lr_email_to))){
			$(this).closest('div.message-forward').find('.lr-wave-forward-to').val('');
			$(this).closest('div.message-forward').hide('slide');
			$(this).closest('div.message-reply').find('.lr-wave-reply').val('');
			$(this).closest('div.message-reply').hide('slide');
			var orig_timestamp = $(this).closest('tr').attr('data-timestamp');
			$('html, body').animate({ scrollTop: $('#timeline_'+ orig_timestamp).offset().top - 130 }, 500);
		}
	});
	
	$('#lr_wave_save').click(function(event){
		var lr_wave_subject = $('#lr_wave_subject').val();
		var lr_wave_message = $('#lr_wave_message').val();
		var post_ID = $('#post_ID').val();
		$.ajax({
			 method: 'POST',
			 url: ajaxurl ,
			 data: {
				 action: 'lr_save_wave',
				 post_ID: post_ID,
				 subject: lr_wave_subject,
				 message: lr_wave_message,
			 },
			 success:function(response){
				 $('#lr_wave_subject').val('');
				 $('#lr_wave_message').val('');
				 get_waves();
			   },
			 error: function (request, status, error) {
				console.log(request.responseText + "  " + error);
			} 
		})
	});
	$('#main-leader-box').ready(function(){
		get_waves();
	});
	get_waves();
	
	////all leader page design
	$('.page-title-action').addClass('btn btn-primary btn-round add-new-leader');
	$('.button.action').addClass('btn btn-linkedin btn-round ');
	$('#search-submit, #post-query-submit').addClass('btn btn-success btn-round ');
	$('.page-title-action').removeClass('page-title-action');
	var url = window.location + "";
		if(url.includes('edit.php?post_type=leader')){
			$('[type="text"], [type="search"]').addClass('form-control');
			$('table').addClass('table');
			
		}
	$('a[href*="post-new.php?post_type=leader"]').click(function(event){
		event.preventDefault();
		$.ajax({
			 method: 'POST',
			 url: ajaxurl ,		 
			 data: {
				 action: 'validate_save',
			 },
			 success:function(response){
				 if(response == 0){
					 demo.showSwal('warning-message-usage-limit');
				 }else{
					 window.location = event.target.href;  
				 }
			   },
			 error: function (request, status, error) {
				console.log(request.responseText + "  " + error);
			}
		});			
	});
	setClickToCall();
	$(document).on('click','.dropdown-item', function(e){
		e.preventDefault();
		var lr_wave_status = $(this).text();
		var lr_wave_status_class = $(this).attr('data-status-class');
		var lr_wave_status_num = $(this).attr('data-status');
		var $lr_wave_timestamp = $(this).closest('td').find('.lr-wave-timestamp').val();
		$(this).closest('tr').prev('tr').find('.lr-wave-status').html('<span class="lr-status-btn '+lr_wave_status_class+'">' + lr_wave_status + '<span>');
		$(this).closest('tr').find('.timeline.timeline-simple').removeClass('lr-red-light');
		$(this).closest('tr').find('.timeline.timeline-simple').removeClass('lr-orange-light');
		$(this).closest('tr').find('.timeline.timeline-simple').removeClass('lr-green-light');
		$(this).closest('tr').find('.timeline.timeline-simple').addClass(lr_wave_status_class);
		update_wave('', '', '', $lr_wave_timestamp, lr_wave_status,lr_wave_status_num, '');
	});
	$(document).on('click', '.lr-reply', function(e){
		e.preventDefault();
		$(this).closest('div').find('.message-forward').slideUp( "medium", function() {
			$(this).css('display','hidden');
		});
		$(this).closest('div').find('.message-reply').slideToggle('medium', function() {
			if ($(this).is(':visible'))
				$(this).css('display','inline-block');
		});
	});
	$(document).on('click', '.lr-forward', function(e){
		e.preventDefault();
		$(this).closest('div').find('.message-reply').slideUp( "medium", function() {
			$(this).css('display','hidden');
		});
		$(this).closest('div').find('.message-forward').slideToggle('medium', function() {
			if ($(this).is(':visible'))
				$(this).css('display','inline-block');
		});
	});	
	$(document).on('mouseenter','.waves_msg', function(e){
		//$(this).tooltip({html: true});
	});
	//save welcome message
	$('#lr_wm_active').change(function(event){
		
		if($('#lr_wm_active:checkbox:checked').length > 0){
			$('#lr_wm_subject').attr("disabled", false);
			$('#lr_wm_message').attr("disabled", false);
		}else{
			$('#lr_wm_subject').attr("disabled", true);
			$('#lr_wm_message').attr("disabled", true);
		}
		lr_wm_save();
	});
	$('#lr_wm_save').click(function(event){
		event.preventDefault();
		lr_wm_save();
	});
	//save email signature
	$('#lr_engaging_save').click(function(event){
		event.preventDefault();
		lr_engaging_save();
	});
	$('#lr_engaging_active').change(function(event){
		event.preventDefault();
		lr_engaging_save();
	});
	function lr_engaging_save(){
		var lr_engaging_active = $('#lr_engaging_active:checkbox:checked').length > 0;
		var lr_full_name = $('#lr_full_name').val();
		var lr_position = $('#lr_position').val();
		var lr_phone_number = $('#lr_phone_number').val();
		var lr_mobile_number = $('#lr_mobile_number').val();
		var lr_email = $('#lr_email').val();
		var lr_website = $('#lr_website').val();
		var lr_address = $('#lr_address').val();
		var lr_fb_address = $('#lr_fb_address').val();
		var lr_instegram_address = $('#lr_instegram_address').val();
		var lr_whatsapp_address = $('#lr_whatsapp_address').val();
		var lr_fa_youtube = $('#lr_fa_youtube').val();
		var lr_fa_twitter = $('#lr_fa_twitter').val();
		var lr_linkedin_in = $('#lr_linkedin_in').val();	
		var image_attachment_id = $('#image_attachment_id').attr('data-image_attachment_id');	
		$.ajax({
			method: 'GET',
			url: ajaxurl ,	 
			data: {
				 action: 'lr_save_engaging_set',
				 lr_full_name: lr_full_name,
				 lr_position: lr_position,
				 lr_phone_number: lr_phone_number,
				 lr_mobile_number: lr_mobile_number,
				 lr_email: lr_email,
				 lr_website: lr_website,
				 lr_address: lr_address,
				 lr_fb_address: lr_fb_address,
				 lr_instegram_address: lr_instegram_address,
				 lr_whatsapp_address: lr_whatsapp_address,
				 lr_fa_youtube: lr_fa_youtube,
				 lr_fa_twitter: lr_fa_twitter,
				 lr_linkedin_in: lr_linkedin_in,
				 lr_engaging_active: lr_engaging_active,
				 image_attachment_id: image_attachment_id,
			},
			success:function(response){
				showPop(popup_notification.success_saving_engaging,'success');
				$('#signature').html(response);
			},
			error: function (request, status, error) {
				showPop(popup_notification.error,'error');
				console.log(request.responseText + "  " + error);
			}
		});		
	}
	//save Social Bar
	$('#lr_sb_save').click(function(event){
		event.preventDefault();
		var lr_sb_active = $('#lr_sb_active:checkbox:checked').length > 0;
		var lr_fb_address = $('#lr_fb_address').val();
		var lr_instegram_address = $('#lr_instegram_address').val();
		var lr_whatsapp_address = $('#lr_whatsapp_address').val();
		var lr_fa_youtube = $('#lr_fa_youtube').val();
		var lr_fa_twitter = $('#lr_fa_twitter').val();
		var lr_linkedin_in = $('#lr_linkedin_in').val();	
		var lr_facebook_sb_active = $('#lr_facebook_sb_active:checkbox:checked').length > 0;		
		var lr_instegram_sb_active = $('#lr_instegram_sb_active:checkbox:checked').length > 0;		
		var lr_whatsapp_sb_active = $('#lr_whatsapp_sb_active:checkbox:checked').length > 0;		
		var lr_youtube_sb_active = $('#lr_youtube_sb_active:checkbox:checked').length > 0;		
		var lr_twitter_sb_active = $('#lr_twitter_sb_active:checkbox:checked').length > 0;		
		var lr_linkedin_sb_active = $('#lr_linkedin_sb_active:checkbox:checked').length > 0;		
		$.ajax({
			method: 'GET',
			url: ajaxurl ,	 
			data: {
				 action: 'lr_save_sb_set',
				 lr_fb_address: lr_fb_address,
				 lr_instegram_address: lr_instegram_address,
				 lr_whatsapp_address: lr_whatsapp_address,
				 lr_fa_youtube: lr_fa_youtube,
				 lr_fa_twitter: lr_fa_twitter,
				 lr_linkedin_in: lr_linkedin_in,
				 lr_sb_active: lr_sb_active,
				 lr_facebook_sb_active: lr_facebook_sb_active,
				 lr_instegram_sb_active: lr_instegram_sb_active,
				 lr_whatsapp_sb_active: lr_whatsapp_sb_active,
				 lr_youtube_sb_active: lr_youtube_sb_active,
				 lr_twitter_sb_active: lr_twitter_sb_active,
				 lr_linkedin_sb_active: lr_linkedin_sb_active,				 
			},
			success:function(response){
				showPop(popup_notification.success_social_ber,'success');
				$('#signature').html(response);
			},
			error: function (request, status, error) {
				showPop(popup_notification.error,'error');
				console.log(request.responseText + "  " + error);
			}
		});			
	});
	miniColor();

	// Uploading files
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
	
	$('#upload_image_button').on('click', function( event ){
		event.preventDefault();
		var set_to_post_id = $('#image_attachment_id').attr('data-image_attachment_id'); // Set this
		var set_to_menu_id = $('#image_attachment_id').attr('data-current_menu_id'); // Set this
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			// Set the post ID to what we want
			file_frame.uploader.uploader.param( 'post_id', set_to_menu_id );
			// Open frame
			file_frame.open();
			return;
		} else {
			// Set the wp.media post id so the uploader grabs the ID we want when initialised
			wp.media.model.settings.post.id = set_to_post_id;
		}
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select a image to upload',
			button: {
				text: 'Use this image',
			},
			multiple: false	// Set to true to allow multiple files to be selected
		});
		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
			$( '#image_attachment_id' ).attr('data-image_attachment_id',attachment.id );
			// Restore the main post ID
			wp.media.model.settings.post.id = wp_media_post_id;
		});
			// Finally, open the modal
			file_frame.open();
	});
	// Restore the main ID when the add media button is pressed
	$( 'a.add_media' ).on( 'click', function() {
		wp.media.model.settings.post.id = wp_media_post_id;
	});
	
}( jQuery) );
var utils = {
	validateEmail: function($email) {
	  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	  return emailReg.test( $email );
	},
	lr_gs: function(){
		var lr_gs_settings = {};
		var lr_delay = $('#lr_delay').val();
		var lr_pages = $('#lr_pages').val();
		var lr_platform = $('#lr_platform').val();
		lr_gs_settings = {
			lr_delay: lr_delay,
			lr_pages: lr_pages,
			lr_platform: lr_platform,
		};
		return lr_gs_settings;
	},
	lr_pos: function(){
		var lr_pos_settings = {};
		var lr_pos_horizontal = $('#lr_pos_horizontal:checkbox:checked').length > 0;
		var lr_pos_vertical = $('#lr_pos_vertical:checkbox:checked').length > 0;
		lr_pos_settings = {
			lr_pos_horizontal: lr_pos_horizontal,
			lr_pos_vertical: lr_pos_vertical,
		};
		return lr_pos_settings;
	},
	lr_dn: function(){
		var lr_dn_settings = {};
		var lr_text_font_family = $('#lr_text_font_family').val();
		var lr_text_font_size = $('#lr_text_font_size').val();
		var lr_button_font_family = $('#lr_button_font_family').val();
		var lr_button_font_size = $('#lr_button_font_size').val();
		/* var lr_opacity = $('#lr_opacity .noUi-handle').attr('aria-valuetext'); 
		lr_opacity = parseInt(lr_opacity)/100;*/
		var lr_bg_color = $('#lr_bg_color').val();
		var lr_text_color = $('#lr_text_color').val();
		var lr_button_text_color = $('#lr_button_text_color').val();
		var lr_button_bg_color = $('#lr_button_bg_color').val();
		var lr_border_color = $('#lr_border_color').val();
		var lr_border_type = $('#lr_border_type').val();
		lr_dn_settings = {
			lr_text_font_family: lr_text_font_family,
			lr_text_font_size: lr_text_font_size,
			lr_button_font_family: lr_button_font_family,
			lr_button_font_size: lr_button_font_size,
			lr_bg_color: lr_bg_color,
			lr_text_color: lr_text_color,
			lr_button_text_color: lr_button_text_color,
			lr_button_bg_color: lr_button_bg_color,
			lr_border_color: lr_border_color,
			lr_border_type: lr_border_type,
		};
		return lr_dn_settings;
	},
	lr_wm: function(){
		var lr_wm_settings = {};
		var lr_wm_active = $('#lr_wm_active:checkbox:checked').length > 0;
		var lr_wm_subject = $('#lr_wm_subject').val();
		var lr_wm_message = $('#lr_wm_message').val();
		lr_wm_settings = {
			lr_wm_active: lr_wm_active,
			lr_wm_subject: lr_wm_subject,
			lr_wm_message: lr_wm_message,
		};
		return lr_wm_settings;
	},
}

	function send_email($lr_email_to, $lr_email_subject, $lr_email_message){
		if($lr_email_to.length < 1){
			demo.showSwal('warning-message-email');
		} else if(!utils.validateEmail($lr_email_to)){
			demo.showSwal('warning-message-email-valid');
		} else if(($lr_email_subject.length > 0) && ($lr_email_message.length > 0)){
			$.ajax({
			 method: 'GET',
			 url: ajaxurl ,
			 dataType: "json",
			 
			 data: {
				 action: 'lr_email_send',
				 lr_email_to: $lr_email_to,
				 lr_email_subject: $lr_email_subject,
				 lr_email_message: $lr_email_message,
			 },
			 success:function(response){
				 if(response == 1){
					demo.showSwal('success-message-timer');
				 }
			   },
			 error: function (request, status, error) {
				console.log(request.responseText + "  " + error);
				demo.showSwal('error-message-email');
			} 
		  });
		} else {
			demo.showSwal('warning-message');
		}
	}
	function update_wave($lr_email_to, $lr_email_subject, $lr_email_message, $lr_wave_timestamp, lr_wave_status,lr_wave_status_num, lr_reply_forward){
		if(($lr_email_subject.length > 0) && ($lr_email_message.length > 0) || (lr_wave_status !='')){
			var post_ID = $('#post_ID').val();
			$.ajax({
			 method: 'POST',
			 url: ajaxurl ,
			 data: {
				 action: 'update_user_wave',
				 post_ID: post_ID,
				 lr_email_to: $lr_email_to,
				 lr_email_subject: $lr_email_subject,
				 lr_email_message: $lr_email_message,
				 lr_wave_timestamp: $lr_wave_timestamp,
				 lr_wave_status: lr_wave_status,
				 lr_wave_status_num: lr_wave_status_num,
				 lr_reply_forward: lr_reply_forward,
			 },
			 success:function(response){
				 if(response.length > 0){
					 response = JSON.parse(response);
					 var reply_date = new Date(response.reply_timestamp * 1000);
					 new_message = '<li class="timeline-inverted">'
						+'<div class="timeline-badge">'									
							+'<div class="card-avatar">'
								+'<img class="img lr-message-answer-avatar" src="'+ response.avatar +'" srcset="'+ response.avatar +'"  />'
							+'</div>'
						+'</div>'
						+'<div class="timeline-panel">'
							+'<div class="timeline-heading">'
								+'<span class="badge badge-pill badge-success">'+ response.source +'</span>'
								 +'<span class="badge badge-pill badge-danger">'+ reply_date.toLocaleString() +'</span>'
								+'<span class="badge badge-pill badge-info">'+ response.reply_forword +'</span>'
							+'</div>'
							+'<div class="timeline-body">'
							  +'<p class="lr-reply-bubble">'+ response.message +'</p>'
							+'</div>'
						+'</div>'
					+'</li>';
					if(($lr_email_to.length > 0) && (utils.validateEmail($lr_email_to))){
						$('#timeline_'+response.source_timestamp).prepend(new_message);
					}
				 }
			   },
			 error: function (request, status, error) {
				console.log(request.responseText + "  " + error);
			} 
		  });
		}
	}
	function get_waves(){
		var post_ID = $('#post_ID').val();
		var results, wave_row, data_chat = '';
		$.ajax({
			 method: 'POST',
			 url: ajaxurl ,
			 data: {
				 action: 'get_leader_wave_list',
				 post_ID: post_ID,
			 },
			 success:function(response){
				 results = JSON.parse(response);
				 var source = '';
				 var message = '';
				 var message_tr = '';
				 var message_answer = '';
				 var message_textarea = '';
				 var message_no_br = '';
				 var subject = '';
				 var engaging = '';
				 var timestamp = '';
				 var status_color = '';
				 var message_textarea_forward = '\n\n********************';
				 for(var i=results.length-1;i>=0;i--){
					 if (results[i] != null){
						var date = new Date(results[i].timestamp * 1000);
						 if(results[i].length > 0){
							for(var j=0;j<results[i].length;j++){
								message +=	+'<td>'+results[i][j].message+'</td>'
								+'<td>'+results[i][j].timestamp+'</td>';
							}
							message +='<div><tr>'+ message +'</tr></div>';
						 } else {
							 source = results[i].source;
							 subject = results[i].subject;
							 if(results[i].hasOwnProperty('connection')){
								 engaging = results[i].connection;
								 parser = new DOMParser();
								 engaging = parser.parseFromString(engaging, "text/html");
								 engaging = engaging.body.firstChild.nodeValue;
							 }else{
								 engaging = '<i class="fas fa-envelope fa-2x"></i>';
							 }
							 url = results[i].url;
							 message = results[i].message;
							 message_tr = results[i].msg_text; // only msg no details
							 message_tr = message_tr.replace(/[<]br[^>]*[>]/gi," "); // remove br tag
							 message_forword = results[i].message.replace(/[<]br[^>]*[>]/gi,"\n"); // replace br with /n
							 message_textarea = message.message_textarea; 
							 message_answer = results[i].message_answer;
							 timestamp = results[i].timestamp;
							 var lr_massage_fw = '';
							 var $lr_messages = $('#wave_'+timestamp).find('.timeline-panel').each(function() {
								$lr_td = $(this).find('div').each(function() {
									lr_sender_fw = $(this).find('.badge-success').text();
									lr_date_fw = $(this).find('.badge-danger').text();
									lr_reply_forward_fw = $(this).find('.badge-info').text();
									lr_massage_fw = $(this).find('.lr-reply-bubble').text();
									message_textarea_forward += '\n' + lr_sender_fw + '\n' + lr_date_fw + '\n' + lr_reply_forward_fw.replace(/^\s+|\s+$/g, '').replace(/^\n|\n$/g, '') + lr_massage_fw ;
								});
							});							 
						}
						wave_row += '<tr data-toggle="collapse" href="#'+timestamp+'" aria-expanded="false" aria-controls="'+results[i].timestamp+'" class="collapsed lr-wave-tr" data-parent="#accordion'+results[i].timestamp+'">'
							+'<td class="text-center">'+ (i+1) +'</td>'
							+'<td class="waves_source" data-toggle="tooltip" title="'+source+'"><p><a href="'+url+'" target="_blank">'+source+'</a></p></td>'
							+'<td>'+subject+'</td>'
							+'<td class="waves_msg" data-toggle="tooltip" title="'+message+'"><p>'+message_tr+'</p></td>'
							+'<td class="text-right lr-wave-status">'+results[i].status+'</td>'
							+'<td class="text-center">'+ date.toLocaleString() +'</td>'
							+'<td class="td-actions text-center">'
								+'<button type="button" rel="tooltip" class="btn leader-form-icon" data-original-title="" title="">'
									+ engaging
								+'</button>'
							+'</td>'
						+'</tr>'
						+'<tr id="wave_'+ timestamp +'" data-timestamp="'+ timestamp +'">'
							+'<td colspan="7" >'
								+'<input type="hidden" class="lr-wave-subject" name="lr_wave_subject" value="'+results[i].subject+'" />'
								+'<input type="hidden" class="lr-wave-timestamp" name="lr_wave_timestamp" value="'+timestamp+'" />'
								+'<div id="'+timestamp+'" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion'+timestamp+'">'
									
									+'<div class="col-md-12">'
									  +'<ul id="timeline_'+timestamp +'" class="timeline timeline-simple '+ results[i].status_class +'">';										
										for(var x=results[i].message_answer.length-1; x>=0;x--){
											var reply_date = new Date(results[i].message_answer[x].reply_timestamp * 1000);
											wave_row += '<li class="timeline-inverted">'
												+'<div class="timeline-badge">'									
													+'<div class="card-avatar">'
														+'<img class="img lr-message-answer-avatar" src="'+ results[i].message_answer[x].avatar +'" srcset="'+ results[i].message_answer[x].avatar +'"  />'
													+'</div>'
												+'</div>'
												+'<div class="timeline-panel">'
													+'<div class="timeline-heading">'
														+'<span class="badge badge-pill badge-success">'+ results[i].message_answer[x].source +'</span>'
														 +'<span class="badge badge-pill badge-danger">'+ reply_date.toLocaleString() +'</span>'
														 +'<span class="badge badge-pill badge-info">'+ results[i].message_answer[x].reply_forword +'</span>'
													+'</div>'
													+'<div class="timeline-body">'
													  +'<p class="lr-reply-bubble">'+ results[i].message_answer[x].message +'</p>'
													+'</div>'
												+'</div>'
											+'</li>';
										} 
									//adding original msg to the end
									 wave_row += '<li class="timeline-inverted">'
										  +'<div class="timeline-badge">'
											+'<div class="card-avatar">'
												+'<img class="img lr-message-answer-avatar" src="'+ results[i].avatar +'" srcset="'+ results[i].avatar +'" />'
											+'</div>'
										  +'</div>'
										  +'<div class="timeline-panel">'
											+'<div class="timeline-heading">'
											  +'<span class="badge badge-pill badge-danger">'+ date.toLocaleString() +'</span>'
											+'</div>'
											+'<div class="timeline-body">'
											  +'<p>'+ results[i].message +'</p>'
											+'</div>'
										  +'</div>'
										+'</li>'
									+'</ul>'
									+'</div>'																				
									+'<button type="button" class="btn btn-fill lr-reply lr-wave-btn" name="lr_reply'+timestamp+'" id="lr_reply'+timestamp+'" data-toggle="tooltip" data-placement="top" title="">'
										+'<i class="fas fa-reply"> </i>&nbsp;&nbsp;&nbsp;' + leader_type.reply
									+'</button>'
									+'<button type="button" class="btn btn-fill lr-forward lr-wave-btn" name="lr_forward'+timestamp+'" id="lr_forward'+timestamp+'" data-toggle="tooltip" data-placement="top" title="">'
										+'<i class="fas fa-arrow-right"> </i>&nbsp;&nbsp;&nbsp;' + leader_type.forward
									+'</button>'
									+'<div class="dropdown">'
										+'<button class="dropdown-toggle btn btn-fill lr-wave-btn lr-status-dropdown" type="button" id="dropdownMenuButton'+timestamp+'" data-toggle="dropdown" aria-haspopup="" aria-expanded="true">'
											+'<i class="far fa-user"></i>&nbsp;&nbsp;&nbsp;' + leader_type.status
										+'</button>'
										+'<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" >'
											+'<a class="dropdown-item lr-red-light" href="#" data-status="1" data-status-class="lr-red-light"><i class="fas fa-user-cog dropdown-item-fas"></i>'+leader_type.open+'</a>'
											+'<a class="dropdown-item lr-orange-light" href="#" data-status="2" data-status-class="lr-orange-light"><i class="fas fa-user-clock dropdown-item-fas"></i>'+leader_type.on_hold+'</a>'
											+'<a class="dropdown-item lr-green-light" href="#" data-status="3" data-status-class="lr-green-light"><i class="fas fa-user-check dropdown-item-fas"></i>'+leader_type.closed+'</a>'
										+'</div>'
									+'</div>'
									+'<div class="col-md-12 message-reply">'
										+'<div class="form-group">'
											+'<div class="form-group bmd-form-group">'
												+'<textarea rows="5" name="lr_wave_reply" id="lr_wave_reply'+timestamp+'" class="form-control lr-wave-reply" ></textarea>'
											+'</div>'
										+'</div>'
										+'<button type="button" class="btn btn-fill  lr-wave-reply-send" name="lr_wave_reply">'
											+ leader_type.send
											+'<div class="ripple-container"></div>'
										+'</button>'
									+'</div>'
									+'<div class="col-md-12 message-forward">'
										+'<div class="form-group">'
											+'<div class="form-group bmd-form-group">'
											+'<div class="row">'						
												+'<div class="col-md-12">'														
													+'<div class="form-group  bmd-form-group">'
														+'<label for="lr_wave_forword_to'+timestamp+'" class="bmd-label-floating">'+ leader_type.email_to +'</label>'
														+'<input  type="email" id="lr_wave_forword_to'+timestamp+'" class="form-control lr-wave-forward-to" name="lr_wave_forword_to" value=""/>'
													+'</div>'
												+'</div>'
												+'<div class="col-md-12">'
													+'<div class="form-group has-default bmd-form-group">'
														+'<textarea rows="15" name="lr_wave_message" class="form-control lr-wave-forward">'+ message_textarea_forward + message_forword.trim() +'</textarea>'
													+'</div>'
												+'</div>'
											+'</div>'
										+'</div>'
										+'<button type="button" class="btn btn-fill lr-wave-forward-send" name="lr_wave_forward">'
										+ leader_type.send
										+'	<div class="ripple-container"></div>'
										+'</button>'
									+'</div>'
									+'<input type="hidden" value="lr_wave_list_'+timestamp+'"/>'
								+'</div>'
							+'</td>'
						+'</tr>';
						data_chat ='';
						message_textarea_forward = '';
					}
				 }
				 $('.waves_table').find('tr').remove();
				 $('tbody').append(wave_row);
			   },
			 error: function (request, status, error) {
				console.log(request.responseText + "  " + error);
			} 
		})
	}
	function setClickToCall(){
		var lr_mobile_number = '';
		var lr_phone_number = '';
		if($("#lr_mobile_number"). length){
			lr_mobile_number = $('#lr_mobile_number').val();
		}
		if($("#lr_phone_number"). length){
			lr_phone_number = $('#lr_phone_number').val();
		}
		if(lr_mobile_number.length > 0){
			$('#lr_click_call').attr('href','tel:'+ lr_mobile_number);
		} else if(lr_phone_number.length > 0){
			$('#lr_click_call').attr('href','tel:'+ lr_phone_number);
		}
		else{
			$('#lr_click_call').hide();
		}
	}
		function miniColor(){
		//var color_set = []
		$.minicolors = {
		  defaults: {
			animationSpeed: 50,
			animationEasing: 'swing',
			change: null,
			changeDelay: 0,
			//control: 'wheel',
			defaultValue: '',
			format: 'rgb',
			hide: null,
			hideSpeed: 500,
			inline: false,
			keywords: '',
			letterCase: 'lowercase',
			opacity: true,
			position: 'bottom',
			show: null,
			showSpeed: 1000,
			theme: 'bootstrap',
			swatches: ['#DE63D1','#09C353','#618DFB','#F54141','#ffffff','#000000']
		  }
		};
		$('input.color-picker').minicolors();
	}
	function showPop(title, type){
		swal({
                title: title,
                text: "",
                buttonsStyling: false,
                confirmButtonClass: "btn btn-success lr-reload",
                type: type,
				timer: 1500
			}).catch(swal.noop)
	}
	function lr_wm_save(){
		var lr_wm_active = $('#lr_wm_active:checkbox:checked').length > 0;
		var lr_wm_subject = $('#lr_wm_subject').val();
		var lr_wm_message = $('#lr_wm_message').val();
		$.ajax({
			 method: 'GET',
			 url: ajaxurl ,		 
			 data: {
				 action: 'lr_save_wm_set',
				 lr_wm_subject: lr_wm_subject,
				 lr_wm_message: lr_wm_message,
				 lr_wm_active: lr_wm_active,
			 },
			 success:function(response){
				showPop(popup_notification.success_saving_wm,'success');
			   },
			 error: function (request, status, error) {
				showPop(popup_notification.error,'error');
				console.log(request.responseText + "  " + error);
			}
		});		
	}
/* var slider = document.getElementById('lr_opacity');
noUiSlider.create(slider, {
    start: [0],
	animate: true,
    connect: true,
    range: {
        'min': 0,
        'max': 100
    },
	step: 10,
	//behaviour: 'tap-drag',
    tooltips: [true],
	format: {
		from: function(value) {
			return parseInt(value);
		},
		to: function(value) {
			return parseInt(value);
		}
    },
	orientation: 'horizontal',
}); */