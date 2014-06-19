function login() {
	$('#load').show();
	login = $('#email').val();
	password = $('#password').val();
	$.get('/user/login/login/' + login + '/password/' + password,
			function(data) {
				var results = jQuery.parseJSON(data);
				if (results.result == 'success') {
					$('#form').hide();
					$('#load').hide();
					$('#goto').show();
				} else {

					$('#load').hide();
					alert('Error. Wrong ' + results.result
							+ '. Try again please.');
				}
			});
}

function deletearticle(artid) {
	$('#load' + artid).show();
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
	$('#load').show();
	comment = $('#comment').val();
	key1 = Recaptcha.get_challenge();
	key2 = Recaptcha.get_response();

	$.get('/comments/addcomment/comment/' + comment + '/artid/' + artid
			+ '/key1/' + key1 + '/key2/' + key2, function(data) {
		var results = jQuery.parseJSON(data);
		if (results.result == 'success') {
			$('#form_comments').hide();
			$('#load').hide();
			$('#goto').show();
		} else {
			if (results.result == 'captcha') {
				$('#load').hide();
				showRecaptcha('recaptcha_div');
				alert('Error. Please check Captcha');
			} else {
				$('#load').hide();
				alert('Error. Please try again. ');
			}
		}
	});
}

function deletecomment(artid, arttid) {
	$('#load_comm' + artid).show();

	$.get('/comments/delete/comId/' + artid + '/artid/' + arttid,
			function(data) {
				var results = jQuery.parseJSON(data);
				if (results.result == 'success') {
					$('#comment' + artid).hide();
					$('#load_comm' + artid).hide();
					$('#goto_comm' + artid).show();
				} else {
					$('#load_comm' + artid).hide();
					alert('Comment doesn\'t deleted. Please try again =) ');
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
