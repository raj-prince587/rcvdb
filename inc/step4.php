<?php
//echo 'step3<br>';

$action = BASE_URI . '/SnM';

$land_val = array('IN' => 'India', 'RU' => 'Russian Federation');

$firma = '';
$vorname = '';
$nachname = '';

$passwort = '';
$wiederholung = '';
$strasse = '';
$postleitzahl = '';
$ort = '';
$land = '';

$telefonnummer = '';
$telefaxnummer = '';
$eMail = '';
$bei_abholung = '';
$ec_cash = '';

if( isset($session->data['cust_id']) && !empty($session->data['cust_id']) ) {

	$user_data = $user->getUser($session->data['cust_id']);
	
	extract($user_data);

}
?>
	<nav class="idealsteps-nav">
		<ul>
			<li class="">
				<a class="top-navigation" id="step1" href="#" tabindex="-1">Schritt 1<span class="counter"></span></a>
			</li>
			<li class="">
				<a class="top-navigation" id="step2" href="#" tabindex="-1">Schritt 2<span class="counter"></span></a>
			</li>
			<li class="">
				<a class="top-navigation" id="step3" href="#" tabindex="-1">Schritt 3<span class="counter"></span></a>
			</li>
			<li class="idealsteps-step-active">
				<a class="top-navigation" id="step4" href="#" tabindex="-1">Schritt 4</a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">Schritt 5<span class="counter"></span></a>
			</li>
		</ul>
	</nav>

	<section class="idealsteps-step">
		<div class="field idealforms-field idealforms-field-text login-link">
			<?php if( $logged_in ) { ?>
			Hallo, <?php if( isset($session->data['vorname']) && !empty($session->data['vorname']) ) { echo $session->data['vorname']; } else { echo 'User';} ?> 
			<a href="#" id="logout-link">Abmelden</a>
			<span class="login-err" id="logout_err" style="display: none;">ERROR</span>
			<?php } else { ?>
			Stammkunden bitte <a href="#login-dialog" data-toggle="modal">Einloggen</a>
			<?php } ?>
		</div>
	</section>
	
	<form action="<?php echo $action; ?>" novalidate="" autocomplete="off" class="idealforms" id="form1" method="post">

		<div class="idealsteps-wrap">

  <!-- Step 3 -->
		<section class="idealsteps-step">

            <div class="field idealforms-field idealforms-field-text divider"><b>Daten zur Person:</b></div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Firma:</label>
				<input type="text" name="firma" id="firma" value="<?php echo $firma; ?>">
				<span class="error" id="error1" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-f2ield idealforms-field-text">
				<label class="main">Vorname:</label>
				<input type="text" name="vorname" id="vorname" value="<?php echo $vorname; ?>">
				<span class="error" id="error4" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Nachname:</label>
				<input type="text" name="nachname" id="nachname" value="<?php echo $nachname; ?>">
				<span class="error" id="error5" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<?php if( ! $logged_in ) { ?>
			<div class="field idealforms-field idealforms-field-text divider"><hr><b>Passwort:</b></div>
			<div class="field idealforms-field idealforms-field-text">
				Sie konnen hier ein Password hinterlegen.
				Beim Nachsten Meiten eines Fahrzeugs, konnen
				Sie sich mit Ihrer eMail-Adresse und Ihrem 
				Passwort einloggen und die hinterlegten Daten 
				werden ubernommen.
			</div>
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Passwort:</label>
				<input type="password" name="passwort" id="passwort" value="<?php echo $passwort; ?>">
				<span class="error" id="error7" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Wiederholung:</label>
				<input type="password" name="wiederholung" id="wiederholung" value="<?php echo $wiederholung; ?>">
				<span class="error" id="sp-error" style="display: none;"></span>
				<span class="error" id="error8" style="display: none;">Required</span>				
				<i class="icon"></i>
			</div>
			<?php } ?>
			
			<!--<div class="field idealforms-field idealforms-field-textarea">
              <label class="main">Comments:</label>
              <textarea name="comments" cols="30" rows="10"></textarea>
              <span class="error" style="display: none;">This field is required</span>
            <i class="icon"></i></div>-->
			<div class="field idealforms-field idealforms-field-text divider"><hr><b>Anschrift:</b></div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Strasse:</label>
				<input type="text" name="strasse" id="strasse" value="<?php echo $strasse; ?>">
				<span class="error" id="error9" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Postleitzahl:</label>
				<input type="text" name="postleitzahl" id="postleitzahl" value="<?php echo $postleitzahl; ?>">
				<span class="error" id="error10" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Ort:</label>
				<input type="text" name="ort" id="ort" value="<?php echo $ort; ?>">
				<span class="error" id="error11" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-select-one">
				<label class="main">Land:</label>
				<select name="land" id="land">
					<option value="0">– Select an option –</option>
					<?php foreach($land_val as $key => $val) { ?>
					<?php if( $land ==  $key ) { ?>
					<option value="<?php echo $key; ?>" selected><?php echo $val; ?></option>
					<?php } else { ?>
					<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
				<span class="error" id="error12" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-text divider"><hr><b>Kontaktdaten:</b></div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Telefonnummer:</label>
				<input type="text" name="telefonnummer" id="telefonnummer" value="<?php echo $telefonnummer; ?>">
				<span class="error" id="error13" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">Telefaxnummer:</label>
				<input type="text" name="telefaxnummer" id="telefaxnummer" value="<?php echo $telefaxnummer; ?>">
				<span class="error" id="error14" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main">eMail-Adresse:</label>
				<input type="text" name="eMail" id="eMail" value="<?php echo $eMail; ?>">
				<span class="error" id="error15" style="display: none;">Required</span>
				<span class="error" id="eerror1" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-text divider"><hr><b>Zahlungsart:</b></div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main"></label>
				<input type="radio" class="payment-option" name="payment-type" id="bei-abholung" value="BEI_ABHOLUNG">
				<label for="bei-abholung" class="main main1">in bar bei Abholung</label>
				<span class="error" id="error16" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>
			
			<div class="field idealforms-field idealforms-field-text">
				<label class="main"></label>
				<input type="radio" class="payment-option" name="payment-type" id="ec-cash" value="EC_CASH">
				<label for="ec-cash" class="main main1">per EC-Cash</label>
				<span class="error" id="error17" style="display: none;">Required</span>
				<i class="icon"></i>
			</div>

            <div class="field buttons">
				<label class="main">&nbsp;</label>
				<button type="button" class="prev">« Prev</button>
				<?php /*if($logged_in)*/if(false) { ?>
				<button type="button" id="update-info">Update</button>
				<?php } ?>
				<button type="button" class="submit" id="submitnmail">Submit</button>
            </div>

		</section>
		  
		</div>

        <span id="invalid"></span>

    </form>
	  
	<script>
		$(document).ready(
			function(){
				$('.prev').click(
					function(){
						<?php if( IS_AJAX == true ) { ?>
						$('#progressbar1').modal('show');
						$.ajax({
							url: '<?php echo BASE_URI; ?>/ajax.php',
							dataType: 'html',
							type: 'post',
							data: { "action" : 'step3' },
							success: function( data, textStatus, jQxhr ) {
								$('#ajax-container').html(data);
								$('#progressbar1').modal('hide');
							},
							error: function( jqXhr, textStatus, errorThrown ) {
								$('#ajax-container').html(errorThrown);
								$('#progressbar1').modal('hide');
							}
						});
						<?php } else { ?>
						$(location).attr('href', '<?php echo BASE_URI; ?>/step3');
						<?php } ?>
					}
				);
				
				$('#submitnmail').click(
					function(){
						$noerror = true;
						/*if( $('#firma').val() == '' ){ $noerror = false; $('#error1').css('display', 'block'); } else { $('#error1').css('display', 'none'); }*/
						if( $('#vorname').val() == '' ){ $noerror = false; $('#error4').css('display', 'block'); } else { $('#error4').css('display', 'none'); }
						if( $('#nachname').val() == '' ){ $noerror = false; $('#error5').css('display', 'block'); } else { $('#error5').css('display', 'none'); }
						<?php if( ! $logged_in ) { ?>
						if( $('#passwort').val() == '' ){ $noerror = false; $('#error7').css('display', 'block'); } else { $('#error7').css('display', 'none'); }
						if( $('#wiederholung').val() == '' ){ $noerror = false; $('#error8').css('display', 'block'); } else { if($('#passwort').val() != $('#wiederholung').val()) $('#sp-error').html('Password not matched!').css('display', 'block'); else $('#error8, #sp-error').css('display', 'none'); }
						<?php } ?>
						if( $('#strasse').val() == '' ){ $noerror = false; $('#error9').css('display', 'block'); } else { $('#error9').css('display', 'none'); }
						if( $('#postleitzahl').val() == '' ){ $noerror = false; $('#error10').css('display', 'block'); } else { $('#error10').css('display', 'none'); }
						if( $('#ort').val() == '' ){ $noerror = false; $('#error11').css('display', 'block'); } else { $('#error11').css('display', 'none'); }
						if( $('#land').val() == '0' ){ $noerror = false; $('#error12').css('display', 'block'); } else { $('#error12').css('display', 'none'); }
						if( $('#telefonnummer').val() == '' ){ $noerror = false; $('#error13').css('display', 'block'); } else { $('#error13').css('display', 'none'); }
						/*if( $('#telefaxnummer').val() == '' ){ $noerror = false; $('#error14').css('display', 'block'); } else { $('#error14').css('display', 'none'); }*/
						if( $('#eMail').val() == '' ){ $noerror = false; $('#error15').css('display', 'block'); } else { $('#error15').css('display', 'none'); }
						if( ! ( $('#bei-abholung').is(':checked') || $('#ec-cash').is(':checked') ) ) { $noerror = false; $('#error16').css('display', 'block'); } else { $('#error16').css('display', 'none'); }
						
						$('#progressbar').modal('show');
					<?php if( !$user->is_login() ) { ?>
						$.ajax({
							url: '<?php echo BASE_URI; ?>/ajax.php',
							dataType: 'html',
							type: 'post',
							data: { "mailid": $('#eMail').val(), "action" : 'VERIFY_EID' },
							success: function( data, textStatus, jQxhr ) {
								data = Number(data);
								if(data == 0) {
									$noerror = false;
									$('#eerror1').html('Email ID already registered!').css('display', 'block');
									$('#progressbar').modal('hide');
								} else {
									$('#eerror1').html('').css('display', 'none');
					<?php } ?>
									if( $noerror ) {
										$('.error').css('display', 'none');
										<?php if( IS_AJAX == true ) { ?>
										//$('#progressbar').modal('show');
										$.ajax({
											url: '<?php echo BASE_URI; ?>/ajax.php',
											dataType: 'html',
											type: 'post',
											data: { "data": $('#form1').serializeArray(), "action" : 'SnM' },
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
									} else $('#progressbar').modal('hide');
					<?php if( !$user->is_login() ) { ?>
								}
							},
							error: function( jqXhr, textStatus, errorThrown ) {
								$('#ajax-container').html(errorThrown);
								$('#progressbar').modal('hide');
							}
						});
					<?php } ?>
					}
				);
				
				$( "#wiederholung" ).keyup(function() {
					$pass = $('#passwort').val();
					$re_pass = $(this).val();
					if($re_pass.length > 0){
						if( $pass.substring(0, $re_pass.length ) != $re_pass  )
							$('#sp-error').html('Mismatched!').css("display","block");
						else
							$('#sp-error').html('Alright continue..').css("display","block");
						if($pass == $re_pass)
							$('#sp-error').html('Matched').css("display","block");
					}
					else
							$('#sp-error').html('Done').css("display","none");
				});
				
				
			}
		);
	</script>
<?php include_once(GLOBAL_JS); ?>