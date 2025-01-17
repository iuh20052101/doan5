"use strict";

//Plaeholder handler
$(function() {
	
if(!Modernizr.input.placeholder){             //placeholder for old brousers and IE
 
  $('[placeholder]').focus(function() {
   var input = $(this);
   if (input.val() == input.attr('placeholder')) {
    input.val('');
    input.removeClass('placeholder');
   }
  }).blur(function() {
   var input = $(this);
   if (input.val() == '' || input.val() == input.attr('placeholder')) {
    input.addClass('placeholder');
    input.val(input.attr('placeholder'));
   }
  }).blur();
  $('[placeholder]').parents('form').submit(function() {
   $(this).find('[placeholder]').each(function() {
    var input = $(this);
    if (input.val() == input.attr('placeholder')) {
     input.val('');
    }
   })
  });
 }
  
//  $('#contact-form').submit(function(e) {
//     var error = 0;
//     var self = $(this);
    
//     var $name = self.find('[name=name]');
//     var $email = self.find('[name=email]');
//     var $message = self.find('[name=message]');
    
//     // Kiểm tra email
//     var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
//     if(!emailRegex.test($email.val())) {
//         createErrTult('Error! Wrong email!', $email)
//         error++;	
//     }

//     // Kiểm tra tên
//     if($name.val().length < 2) {
//         createErrTult('Error! Write your name!', $name)
//         error++;
//     }

//     // Kiểm tra nội dung
//     if($message.val().length < 3) {
//         createErrTult('Error! Write message!', $message)
//         error++;
//     }
    
//     if (error > 0) {
//         e.preventDefault(); // Chỉ chặn submit khi có lỗi
//         return false;
//     }
    
	



$('.login').submit(function(e) {
      
		e.preventDefault();	
		var error = 0;
		var self = $(this);
		
	    var $email = self.find('[type=email]');
	    var $pass = self.find('[type=password]');
		
				
		var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		
  		if(!emailRegex.test($email.val())) {
			createErrTult("Error! Wrong email!", $email)
			error++;	
		}

		if( $pass.val().length>1 &&  $pass.val()!= $pass.attr('placeholder')  ) {
			$pass.removeClass('invalid_field');			
		} 
		else {
			createErrTult('Error! Wrong password!', $pass)
			error++;
		}
		
		
		
		if (error!=0)return;
		self.find('[type=submit]').attr('disabled', 'disabled');

		self.children().fadeOut(300,function(){ $(this).remove() })
		$('<p class="login__title">sign in <br><span class="login-edition">welcome to A.Movie</span></p><p class="success">You have successfully<br> signed in!</p>').appendTo(self)
		.hide().delay(300).fadeIn();


		// var formInput = self.serialize();
		// $.post(self.attr('action'),formInput, function(data){}); // end post
}); // end submit
		
		

function createErrTult(text, $elem){
			$elem.focus();
			$('<p />', {
				'class':'inv-em alert alert-danger',
				'html':'<span class="icon-warning"></span>' + text + ' <a class="close" data-dismiss="alert" href="#" aria-hidden="true"></a>',
			})
			.appendTo($elem.addClass('invalid_field').parent()) 
			.insertAfter($elem)
			.delay(4000).animate({'opacity':0},300, function(){ $(this).slideUp(400,function(){ $(this).remove() }) });
	}
});
