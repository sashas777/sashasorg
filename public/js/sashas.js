
$( document ).ready(function() {
	
	$('#login_submit').click(function(){
		$('#load').addClass('show');
		$('#goto').addClass('hide'); 	 
		$('#login-form').removeClass('show').addClass('hide');
		$('#goto span').removeClass("bg-danger");
		login = $('#email').val();
		password = $('#password').val();
 
		$.ajax({ 
			async: true,
			url: '/user/login/',
			type: "GET",
			 data: {login:login, password:password }, 
			 dataType: 'json',
			 success: function(data) {		
				 console.log(data);
				 if (data.result=="success"){ 
					$('#login-form').removeClass('show').addClass('hide');
					$('#load').removeClass('show').addClass('hide');	
					$('#goto').addClass('show');
					$('#goto span').text('You are logged in');
					window.location.href = "/admin/index/";					 
				 }else {
					 $('#login-form').removeClass('hide').addClass('show');	
					 $('#load').removeClass('show').addClass('hide');	
					 $('#goto').addClass('show');
					 $('#goto span').text('Please check credentials').addClass('bg-danger');
				 }
			 
			 }
		});	
	});
 
	
});
 
    //Some code
  
	/*$.get('/user/login/login/' + login + '/password/' + password,
			function(data) {
				var results = jQuery.parseJSON(data);
				if (results.result == 'success') {
					$('#login-form').removeClass('show').addClass('hide');
					$('#load').removeClass('show').addClass('hide');	
					$('#goto').addClass('show');
					$('#goto span').text('You are logged in');
				} else {
					$('#login-form').removeClass('hide').addClass('show');	
					$('#load').removeClass('show').addClass('hide');	
					$('#goto span').text('Please check credentials').addClass('bg-danger');
				}
			});
	*/
 

/*Refactor*/
function deletearticle(artid) {
	$('#load').addClass('show');
	// ajax
	$.get('/admin/deletarticleajax/artid/' + artid, function(data) {
		var results = jQuery.parseJSON(data);
		if (results.result == 'success') {
			$('#article' + artid).hide();
			$('#load' + artid).hide();
			$('#goto' + artid).show();
		} else {
			$('#load' + artid).hide();
			alert('Article was not deleted, please try again');
		}
	});

}

function addcomment(artid) {
	$('.comments-form').removeClass('show').addClass('hide');
	$('#load').addClass('show');
	$('.article-add-comment').parent().removeClass("has-error");
	$('#recaptcha_response_field').parent().removeClass("has-error");
	$('#goto span').removeClass("bg-danger");
	$('#goto').addClass('hide');
	comment_field = $('.article-add-comment') 
	if (comment_field.val().length==null || comment_field.val().length<1) {
		$('.comments-form').removeClass('hide').addClass('show');
		$('#load').removeClass('show').addClass('hide');			
		$('.article-add-comment').parent().addClass("has-error");
		$('#goto').addClass('show');
		$('#goto span').text('Please enter comment message').addClass('bg-danger');
		return false;
	}
		
	key1 = Recaptcha.get_challenge();
	key2 = Recaptcha.get_response();

	$.get('/comments/addcomment/comment/' + comment_field.val() + '/artid/' + artid
			+ '/key1/' + key1 + '/key2/' + key2, function(data) {
		var results = jQuery.parseJSON(data);
		if (results.result == 'success') {		 
			$('#load').removeClass('show').addClass('hide');
			$('#goto').addClass('show');	
			$('#goto span').addClass('bg-success').text('Thank you. Comment has been added');

			$.ajax({ 
				async: true,
				url: '/comments/getlast/',
				type: "GET",
				 data: {artid:artid}, 
				 success: function(data) {				 
					 $(data).insertBefore( ".comments-list div:first");
				 }
			});			
		} else {
			if (results.result == 'captcha') {
				$('.comments-form').removeClass('hide').addClass('show');
				$('#load').removeClass('show').addClass('hide');			 				 
				$('#goto span').text('Error. Please check Captcha').addClass('bg-danger');
				$('#goto').addClass('show');
				$('#recaptcha_response_field').parent().addClass("has-error");				 				
			} else {
			 
				$('.comments-form').removeClass('hide').addClass('show');
				$('#load').removeClass('show').addClass('hide');
				$('#goto').addClass('show');
				$('#goto span').text('Error. Please try again.').addClass('bg-danger');
			}
		}
	});
}
/*Refactor*/
function deletecomment(artid, arttid) {	 
	$('#load_comm' + artid).addClass('show');
	$('#goto_comm' + artid+' span').removeClass('bg-danger');		
	$.get('/comments/delete/comId/' + artid + '/artid/' + arttid,
			function(data) {
				var results = jQuery.parseJSON(data);
				if (results.result == 'success') {
					$('#comment' + artid).addClass('hide');
					$('#load_comm' + artid).addClass('hide');
					$('#goto_comm' + artid).addClass('show');
					$('#goto_comm' + artid+' span').text('Comment has been deleted').addClass('bg-success');		
				} else {
					$('#load_comm' + artid).addClass('hide');
					$('#goto_comm' + artid).addClass('show');
					$('#goto_comm' + artid+' span').text('Error please try again').addClass('bg-danger');				 
				}
			});
}

 
window.onload = function() {
	  setLinks();
	}

	function setLinks() {
	  if (!document.getElementsByTagName) return false;
	  var links = document.getElementsByTagName("a");
	  if (links.length == 0) return false;
	  for (var i = 0; i < links.length; i++) {
	    var relation = links[i].getAttribute("rel");
	    if (relation == "external") {
	      links[i].onclick = function() {
	        return !window.open(this.href);
	      }
	    }     
	  }
	}
