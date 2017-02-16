<?php
//header('Content-Type:multipart/form-data');
//echo 'step2<br>';

$action = BASE_URI . '/step3';

//print_r($_FILES);
//die;
if(isset($request->post['frm-fle'])) {

	//$session->data['frm-fle'] = $request->post['frm-fle'];
	echo '<pre/>';

}

//if( IS_AJAX == true ) {}
?>

	<nav class="idealsteps-nav">
		<ul>
			<li class="">
				<a class="top-navigation" id="index" href="#" tabindex="-1">ONE<span class="counter"></span></a>
			</li>
			<li class="idealsteps-step-active">
				<a class="top-navigation" id="step2" href="#" tabindex="-1">TWO</a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">THREE<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">FOUR<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">FIVE<span class="counter"></span></a>
			</li>
		</ul>
	</nav>

	<section class="idealsteps-step">
		<div class="field idealforms-field idealforms-field-text login-link">
			<?php if( $logged_in ) { ?>
			Hello, <?php if( isset($session->data['user_id']) && !empty($session->data['user_id']) ) { echo $session->data['user_id']; } else { echo 'User';} ?> 
			<a href="#" id="logout-link">Logout</a>
			<span class="login-err" id="logout_err" style="display: none;">ERROR</span>
			<?php } else { ?>
			Return users please <a href="#login-dialog" data-toggle="modal">Login</a>
			<?php } ?>
		</div>
	</section>
	
    <form action="<?php echo $action; ?>" novalidate="" autocomplete="off" class="idealforms" id="form1" method="post">

        <div class="idealsteps-wrap">

		<!-- Step 2 -->

        <section class="idealsteps-step">
			
			<div class="field idealforms-field idealforms-field-text" id="from-date">
				<label class="main">Label:</label>
				<input type="text" class="pickup-d dpicker" name="pickup-d" value="" placeholder="dd/mm/yyyy">
				<span class="error" id="error1" style="display: none;">Required</span>
				<i class="icon"></i>
				<span id="avail-error2"></span>
			</div>

            <div class="field buttons">
              <label class="main">&nbsp;</label>
              <button type="button" class="prev">« Prev</button>
              <button type="button" class="next">Next »</button>
            </div>

          </section>

		  </div>

        <span id="invalid"></span>

    </form>
	
	<script>
		$(document).ready(
			function(){
				$('.dpicker, .tpicker').keypress(function(){return false;});
				$('.prev').click(
					function(){
						<?php if( IS_AJAX == true ) { ?>
						$('#progressbar1').modal('show');
						$.ajax({
							url: '<?php echo BASE_URI; ?>/ajax.php',
							dataType: 'html',
							type: 'post',
							data: { "action" : 'step1' },
							success: function( data, textStatus, jQxhr ) {
								$('#ajax-container').html(data);
								$('#progressbar1').modal('hide');
							},
							error: function( jqXhr, textStatus, errorThrown ) {
								$('#ajax-container').html(errorThrown);
								$('#progressbar1').modal('hide');
								/*console.log( errorThrown );*/
							}
						});
						<?php } else { ?>
						$(location).attr('href', '<?php echo BASE_URI; ?>');
						<?php } ?>
					}
				);
				
				$('.next').click(
					function(){
						$noerror = true;
						if( $('#pickup-d, #pickup-dw').val() == '' ){ $noerror = false; $('#error1').css('display', 'block'); } else { $('#error1').css('display', 'none'); }
						if(!$('#per-hour').is(':checked')){if( $('#dropoff-d, #dropoff-dw').val() == '' ){ $noerror = false; $('#error2').css('display', 'block'); } else { $('#error2').css('display', 'none'); }}
						if( $('#pickup-t').val() == '' ){ $noerror = false; $('#error3').css('display', 'block'); } else { $('#error3').css('display', 'none'); }
						if(!$('#per-day').is(':checked')){if( $('#dropoff-t').val() == '' ){ $noerror = false; $('#error4').css('display', 'block'); } else { $('#error4').css('display', 'none'); }}
						<?php if(isset($session->data['method']) && $session->data['method'] == 'PDAY') { ?>
						var r = checkDates('dropoff-d', '<?php if(isset($session->data['method'])) echo $session->data['method']; ?>');
						$('#progressbar').modal('hide');
						if(!r) { $noerror = false; }
						<?php } ?>
						if( $noerror ) {
							$('.error').css('display', 'none');
							<?php if( IS_AJAX == true ) { ?>
							$('#progressbar').modal('show');
							$.ajax({
								url: '<?php echo BASE_URI; ?>/ajax.php',
								dataType: 'html',
								type: 'post',
								data: { "data": $('#form1').serializeArray(), "action" : 'step3' },
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
							$('#form1').submit();
							<?php } ?>
						} else return false;
					}
				);
			}
		);
	</script>
	
<?php include_once(GLOBAL_JS); ?>