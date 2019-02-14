(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

ileadgenmc_dom_init();
function ileadgenmc_dom_init(){
	var hellobar_action_btn = document.querySelector('.ileadgenmc--hellobar--action');
	var hellobar_wrapper = document.querySelector('.ileadgenmc--hellobar--wrapper');
	var local_data = get_local_data();

	document.addEventListener("DOMContentLoaded", function(event) {
	    if(local_data[0].show_hellobar == 'false'){
	    	hellobar_action_btn.classList.add('hide--hellobar');
	    	hellobar_wrapper.classList.add('hide--hellobar');
	    }
	});
}

/*
ileadgenmc form ajax 
 */
ileadgenmc_form_ajax();
function ileadgenmc_form_ajax(){
	// Add Button Event
	var hellobar_form = document.querySelector('.ileadgenmc--hellobar--wrapper .hellobar--form form');
	var hellobar_form_upper = document.querySelector('.ileadgenmc--hellobar--wrapper .hellobar--form--upper');
	var hellobar_form_lower = document.querySelector('.ileadgenmc--hellobar--wrapper .hellobar--form--lower');
	var hellobar_action_btn = document.querySelector('.ileadgenmc--hellobar--action');
	var hellobar_wrapper = document.querySelector('.ileadgenmc--hellobar--wrapper');
	var local_data = get_local_data();

	hellobar_form.addEventListener('submit',function(event){
		
		event.preventDefault();
		
		var email = hellobar_form.querySelector('input[type="email"]').value;
		
		if(validateEmail(email)){
			
			request = jQuery.ajax({
		        url:ileadgenmc.ajaxurl,
				type:'POST',
				data: {
					'action': 'ileadgenmc_new_subscriber',
					'email': email,
				}
		    });

		    request.done(function (response, textStatus, jqXHR){
		    	hellobar_form.querySelector('input[type="email"]').value = '';

		        if(response.subscriber_status == 'Subscribed'){
		        	hellobar_form_upper.style.visibility = 'hidden';

					hellobar_form_lower.style.visibility = 'visible';
					hellobar_form_lower.style.opacity = 1;

					hellobar_form_lower.querySelector('p').innerText = ileadgenmc.email_subscribed;

					setTimeout(function(){ 
						hellobar_action_btn.classList.add('hide--hellobar');
						local_data[0] = { show_hellobar :'false'};
						

						hellobar_wrapper.classList.add('hide--hellobar');
						local_data[0] = { show_hellobar :'false'};
						
						set_local_data(local_data);	

						setTimeout(function(){ 
							hellobar_form_lower.querySelector('p').innerText = '';
							hellobar_form_lower.style.visibility = 'hidden';
							hellobar_form_lower.style.opacity = 0;

							hellobar_form_upper.style.visibility = 'visible';
						}, 2000);
					}, 5000);
		        }else{
		        	hellobar_form_upper.style.visibility = 'hidden';

					hellobar_form_lower.style.visibility = 'visible';
					hellobar_form_lower.style.opacity = 1;

					hellobar_form_lower.querySelector('p').innerText = ileadgenmc.other_errors;

					setTimeout(function(){ 
						hellobar_form_lower.querySelector('p').innerText = '';
						hellobar_form_lower.style.visibility = 'hidden';
						hellobar_form_lower.style.opacity = 0;

						hellobar_form_upper.style.visibility = 'visible';
					}, 3000);
		        }
		    });

		    request.fail(function (jqXHR, textStatus, errorThrown){
		        
		    });

		    request.always(function () {
		        
		    });


		}else{
			
			hellobar_form_upper.style.visibility = 'hidden';

			hellobar_form_lower.style.visibility = 'visible';
			hellobar_form_lower.style.opacity = 1;

			hellobar_form_lower.querySelector('p').innerText = ileadgenmc.email_unverified;

			setTimeout(function(){ 
				hellobar_form_lower.querySelector('p').innerText = '';
				hellobar_form_lower.style.visibility = 'hidden';
				hellobar_form_lower.style.opacity = 0;

				hellobar_form_upper.style.visibility = 'visible';
			}, 3000);
		}

	}, true);
}

/*
ileadgenmc_hellobar_action
 */
ileadgenmc_hellobar_action();
function ileadgenmc_hellobar_action(){
	var hellobar_action_btn = document.querySelector('.ileadgenmc--hellobar--action');
	var hellobar_wrapper = document.querySelector('.ileadgenmc--hellobar--wrapper');

	var local_data = get_local_data();

	hellobar_action_btn.addEventListener('click',function(event){	

		var action_flag = hellobar_action_btn.classList.contains('hide--hellobar');
		if(action_flag){
			hellobar_action_btn.classList.remove('hide--hellobar');
			local_data[0] = { show_hellobar :'true'};
		}else{
			hellobar_action_btn.classList.add('hide--hellobar');
			local_data[0] = { show_hellobar :'false'};
		}

		var bar_flag = hellobar_wrapper.classList.contains('hide--hellobar');
		if(bar_flag){
			local_data[0] = { show_hellobar :'true'};
			hellobar_wrapper.classList.remove('hide--hellobar');
		}else{
			hellobar_wrapper.classList.add('hide--hellobar');
			local_data[0] = { show_hellobar :'false'};
		}

		set_local_data(local_data);

	});
}


function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function set_local_data(data){
	localStorage.setItem(ileadgenmc.localstorage,JSON.stringify(data));
}

function get_local_data(){

	var data = [];
	var storage = localStorage.getItem(ileadgenmc.localstorage);

	if(storage !== null){
		data = JSON.parse(storage);
	}

	return data;
}
