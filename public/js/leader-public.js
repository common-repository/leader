var e_sent = false;
/* var lr_toggled = false;
var lr_timer = null; */
var utils = {
	catchLoad: function(e) {
		document.addEventListener('click', evt.catchClick);
		Array.prototype.forEach.call(
			document.querySelectorAll('form'), 
			function(element){
				var label = document.createElement("label");
				label.innerText='Etner yuor age';
				label.className = "sec-num-lbl";
				var input = document.createElement("input");
				input.className = "sec-num-des";
				input.type = "number";
				input.placeholder = "Etner yuor age";
				input.value = null;
				label.insertBefore(input, null);
				element.insertBefore(label, element.childNodes[0]);
			}
		);
	},
	ajaxHandler: function(e, action, fields, callback){
		if(fields != null){
			fields = "&fields=" + fields;
		}else{
			fields = '';
		}
		var xhttp;
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				if(this.response != false){
					callback(this.response);
				}
			}
		}
		xhttp.open("POST", lr_ajax.ajaxurl + "?action=" + action + fields, true);
		xhttp.send();
	},
	updateWave: function (e) {
		var jsonForm;
		var jsonFormStr;
		var id = 0;
		var clickEvt = new MouseEvent("click", {
			bubbles: true,
			cancelable: true,
			view: window
		});
		var thisForm = utils.getClosest(e.target, 'FORM');
		if((typeof e.target.form != 'undefined') && (e.target.form.length > 0)){
			thisForm = e.target.form;
		}
		
		
		jsonForm = utils.find_field_text(e, thisForm);
		if(jsonForm != false){
			jsonFormStr = JSON.stringify(jsonForm);
			utils.ajaxHandler(e, 'update_user_wave', jsonFormStr, callback.waveUpdate);
			utils.afterUpdate(e, clickEvt);
			e.target.dispatchEvent(clickEvt);
		} else{
			e.target.dispatchEvent(clickEvt);
		}
		e_sent = false;
	},
	afterUpdate: function(e, clickEvt){
		var lr_hp_remove = document.getElementsByClassName('sec-num-lbl');
		for (var i = 0; i < lr_hp_remove.length; i++) {
			lr_hp_remove[i].parentNode.removeChild(lr_hp_remove[i]);
		}
		e_sent = true;
	},
	find_field_text: function (e, thisForm) {
		var jsonInputLable = [];
		var inputLable,selectors,value,label,source, url, connection;
		var checkEmail = false;
		var checkPhone = false;
		var hidden_field = false;
		var lr_confirm = false;
		var isMail = false;
		var inputTypes = ['[type="text"]', '[type="email"]', '[type="date"]', '[type="datetime-local"]', '[type="month"]', '[type="number"]', '[type="range"]', '[type="search"]', '[type="tel"]', '[type="time"]', '[type="url"]', '[type="week"]', 'textarea', 'option:checked', 'input:checked'];
		for (var i = 0; i < inputTypes.length; i++) {
			selector = inputTypes[i];
			selectors = thisForm.querySelectorAll(selector);
			if (selectors.length > 0) {
				for (var j = 0; j < selectors.length; j++) {
					hidden_field = false;
					value = '';
					label = '';
					if (getComputedStyle(selectors[j], null).display == 'none') {
						hidden_field = true;
					}
					if (!hidden_field) {
						if (selectors[j].type == 'textarea') {
							value = selectors[j].value.replace(/\n\r?/g, '<br>');
						} else {
							value = selectors[j].value;
						}
						if (selector == '[type="email"]'){
							checkEmail = utils.validateEmail(e,selectors[j].value);
							if(checkEmail){
								lr_confirm = true;
							}
						}
						if(selectors[j].type == 'text'){
							if(selectors[j].id == 'undefined'){
								selectors[j].setAttribute('id', 'lr-'+j);
							}
							
							checkEmail = utils.validateEmail(e, selectors[j].id);
							checkPhone = utils.validatePhone(e, selectors[j].id);
							if(checkEmail){
								selector = '[type="email"]';
								lr_confirm = true;
							}else if(checkPhone){
								selector = '[type="tel"]';
							}else{
								selector = '[type="text"]';
							}
						}
						if ((selectors[j].parentNode.innerText != "") && (selectors[j].parentNode.tagName != "FORM")) {
							label = selectors[j].parentNode.innerText;
							if((selectors[j].selected == true) && (selectors[j].tagName == 'OPTION') && (selectors[j].value.length > 0)){
								label = selectors[j].parentNode.value;
							}
						} else if ((selectors[j].parentNode.parentNode.innerText != "") && (selectors[j].parentNode.tagName != "FORM") && (selectors[j].parentNode.parentNode.tagName != "FORM")) {
							label = selectors[j].parentNode.parentNode.innerText;
						} else if (selectors[j].placeholder != "") {
							label = selectors[j].placeholder;
						}
						jsonInputLable.push({
							label: label,
							value: value,
							field_type: selector
						});
					}
				}
			}
		}
		connection = '<i class="fas fa-envelope fa-2x"></i>';
		subject = lr_ajax.new_message;
		var wm = 'lr_wm';
		var tax = lr_ajax.otherforms;
		if(document.title.length > 0){
			source = document.title;
			url = location.protocol + '//' + location.host + location.pathname;
		} else{
			source = lr_ajax.contact_form;
		}
		jsonInputLable.push({
			source: source,
			subject: subject,
			connection: connection,
			url: url,
			wm: wm,
			tax: tax
		});
		if(lr_confirm){
			return jsonInputLable;
		}else{
			return lr_confirm;
		}
	},
	validateEmail: function(e, emailField){
		if(document.getElementById(emailField) != null){
			var email = document.getElementById(emailField);
			email.style.color = '';
			if(document.getElementById(emailField).value.length > 0){
				var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
				if((re.test(email.value)) && (email.value.length > 0)){
					return true;
				}else {
					if((email.value != '') && (email.id == 'lr_hb_email') || (email.id == 'lr_form_email') || (email.id == 'lr_vp_email')){
						elem_child = document.getElementById(emailField+'_error_msg');
						email.style.color = 'red'; 
						e.preventDefault();
					}
					return false;
				}
			}else {
				email.style.color = '';
				return false;
			}
		}else{
			var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
			if(re.test(emailField)){
				return true;
			}else {
				return false;
			}
		}
	},
	validatePhone: function(e, telField){
		var field = document.getElementById(telField);
		if((field != null) && (field != 'undefined')){
			if(document.getElementById(telField).value.length > 0){
				var tel = document.getElementById(telField);
				tel.style.color = '';
				var re =  /^((\\+[1-9]{1,4}[ \\-]*)|(\\([0-9]{2,3}\\)[ \\-]*)|([0-9]{2,4})[ \\-]*)*?[0-9]{3,4}?[ \\-]*[0-9]{3,4}?$/;
				if(re.test(parseInt(tel.value))){
					return true;
				}else {
					if((tel.value != '') && (tel.id == 'lr_hb_tel') || (tel.id == 'lr_form_tel') || (tel.id == 'lr_vp_tel')){
						elem_child = document.getElementById(telField+'_error_msg');
						tel.style.color = 'red';
						e.preventDefault();
					}else{
						tel.style.color = '';
					}
					return false;
				}
			}else{
				return true;
			}
		}
	},
	errorMsg: function(input_id, error_id){
		elem = document.getElementById(input_id);
		var error_msg = '';
		var node = document.createElement("p");
		node.id = input_id+"_error_msg";
		node.className = "error-msg";
		switch(error_id) {
			case 1:
				error_msg = lr_ajax.email_erorr;
				break;
			case 2:
				error_msg = lr_ajax.phone_erorr;
				break;			
		} 
		error_msg = document.createTextNode(error_msg);
		node.appendChild(error_msg);
	},
	mobilecheck: function() {
		var check = false;
		(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
		return check;
	},
	getClosest: function (elem, selector) {

	// Element.matches() polyfill
		if (!Element.prototype.matches) {
			Element.prototype.matches =
				Element.prototype.matchesSelector ||
				Element.prototype.mozMatchesSelector ||
				Element.prototype.msMatchesSelector ||
				Element.prototype.oMatchesSelector ||
				Element.prototype.webkitMatchesSelector ||
				function(s) {
					var matches = (this.document || this.ownerDocument).querySelectorAll(s),
						i = matches.length;
					while (--i >= 0 && matches.item(i) !== this) {}
					return i > -1;
				};
		}

		// Get the closest matching element
		for ( ; elem && elem !== document; elem = elem.parentNode ) {
			if ( elem.matches( selector ) ) return elem;
		}
		return null;

	}
};
var callback ={
	waveUpdate: function(data){},
};
var evt = {
	catchClick: function (e) {
		if (e.target && ((e.target.type == 'submit') || (e.target.parentNode.type == 'submit') || (e.target.parentNode.parentNode.type == 'submit')) && !e_sent) {
			e.preventDefault();
			var lr_form = '';
			var lr_is_form = false;
			lr_parent_id = utils.getClosest(e.target.parentNode, 'FORM');
			if(e.target.parentNode.tagName == 'FORM'){
				lr_form = e.target.parentNode;
				lr_is_form = true;
			}else if((lr_parent_id != null) && (lr_parent_id.tagName == 'FORM')){
				lr_form = lr_parent_id;
				lr_is_form = true;
			}
			else if(e.target.closest("FORM") != null){
				lr_form = e.target.closest("FORM");
				lr_is_form = true;
			}
			var isRequired = true;
			if(lr_is_form){
				for(var i=0; i < lr_form.length; i++){
					if(lr_form[i].classList.contains('lr-required')){
						if(lr_form[i].value == ''){
							if(!lr_form[i].classList.contains('lr-required-false')){
								lr_form[i].placeholder += ' ('+lr_ajax.required+')';
								lr_form[i].style.border = '2px solid red';
								lr_form[i].classList.add('lr-required-false');
							}
							isRequired =  false;
						}else{
							lr_form[i].style.border = '';
							lr_form[i].classList.remove('lr-required-false');
							var lr_remove_placeholder = '('+lr_ajax.required+')';
							lr_form[i].placeholder = lr_form[i].placeholder.replace(lr_remove_placeholder, '');
							isRequired =  true;
						}
					}
				}
			}
			if(!isRequired){
				return isRequired;
			}
			utils.updateWave(e);
		}
	},
};
window.addEventListener("DOMContentLoaded", utils.catchLoad);