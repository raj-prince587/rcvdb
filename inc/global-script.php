<?php
?>

<script>
$('#login-submit').click(function(){alert('fgs');validateLogin();});
$('#login-form').submit(function(){validateLogin();});

$('.top-navigation').click(function(){goToPage($(this).attr('id'));return false;});

function validateLogin() {
	$noerror = true;
	if( $('#login_user').val() == '' ){ $noerror = false; $('#log_error1').html('Required'); $('#log_error1').css('display', 'block'); } else { $('#log_error1').css('display', 'none'); }
	if( $('#login_pass').val() == '' ){ $noerror = false; $('#log_error2').html('Required'); $('#log_error2').css('display', 'block'); } else { $('#log_error2').css('display', 'none'); }
	if( $noerror ) {
		$('.login-err').css('display', 'none');
		$('#progressbar').modal('show');
		$.ajax({
			url: '<?php echo BASE_URI; ?>/ajax.php',
			type: 'post',
			data: { "data": $('#login-form').serializeArray(), "action" : 'VER_LOGIN' },
			success: function( data, textStatus, jQxhr ) {
				data = Number(data);
				switch(data){
					case 0:
						$('#log_error1').html('Invalid username').css('display', 'block');
						break;
					case 1:
						$('#log_error2').html('Invalid password').css('display', 'block');
						break;
					case 2:
						$('.login-err').html('').css('display', 'none');
						refreshPage();
						break;
				}
				$('#progressbar').modal('hide');
			},
			error: function( jqXhr, textStatus, errorThrown ) {
				$('#ajax-container').html(errorThrown);
				$('#progressbar').modal('hide');
			}
		});
	}
}

$('#logout-link').click(
	function() {
		$('#progressbar').modal('show');
		$.ajax({
			url: '<?php echo BASE_URI; ?>/ajax.php',
			type: 'post',
			data: { "action" : 'LOGOUT' },
			success: function( data, textStatus, jQxhr ) {
				data = Number(data);
				switch(data){
					case 0:
						$('#logout_err').css('display', 'block');
						break;
					case 1:
						$('#logout_err').css('display', 'none');
						refreshPage();
						break;
				}
				$('#progressbar').modal('hide');
			},
			error: function( jqXhr, textStatus, errorThrown ) {
				$('#ajax-container').html(errorThrown);
				$('#progressbar').modal('hide');
			}
		});
		return false;
	}
);
function refreshPage() {
	$.ajax({
		url: '<?php echo BASE_URI; ?>/ajax.php',
		dataType: 'html',
		type: 'post',
		data: { 'action' : '<?php echo !empty($session->data['cur_action']) ? $session->data['cur_action'] : 'step1'; ?>' },
		success: function( data, textStatus, jQxhr ) {
			$('#ajax-container').html(data);
			$('#login-dialog').modal('hide');
		},
		error: function( jqXhr, textStatus, errorThrown ) {
			$('#ajax-container').html(errorThrown);
			$('#progressbar').modal('hide');
		}
	});
}

function goToPage(page) {
	<?php if( IS_AJAX ) { ?>
	$('#progressbar').modal('show');
	$.ajax({
		url: '<?php echo BASE_URI; ?>/ajax.php',
		dataType: 'html',
		type: 'post',
		data: { 'action' : page },
		success: function( data, textStatus, jQxhr ) {
			$('#ajax-container').html(data);
			$('#progressbar').modal('hide');
		},
		error: function( jqXhr, textStatus, errorThrown ) {
			$('#ajax-container').html(errorThrown);
			$('#progressbar').modal('hide');
		}
	});
	<?php } else { ?>
	$(location).attr('href', '<?php echo BASE_URI; ?>/' + page);
	<?php } ?>
}
</script>

<?php unset($request->data); ?>