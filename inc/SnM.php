<?php
//echo '<pre/>';
//print_r($request->post);
$msg = '';
$cust_idd = 0;
if( isset($session->data['cust_id']) && !empty($session->data['cust_id']) ) {
	$cust_id = $session->data['cust_id'];
}
$book_info = array('type' => 'Booking');
if(isset($session->data['car_id'])) {	
	$book_info = array_merge($book_info, array('car_id' => $session->data['car_id']));		$car_info = getCarName($session->data['car_id']);	$book_info = array_merge($book_info, array('car' => '#' . $car_info['car_id'] . ' ' . $car_info['name'] ));
}
if(isset($session->data['book_option'])) {
	$book_info = array_merge($book_info, array('options' => $session->data['book_option']));
} else $book_info = array_merge($book_info, array('options' => ''));

if(isset($session->data['method'])) {

	$book_info = array_merge($book_info, array('method' => $session->data['method']));

}
if(isset($session->data['pickup-d'])) {
	$book_info = array_merge($book_info, array('start_date' => date('Y-m-d',strtotime($session->data['pickup-d']))));
}

if(isset($session->data['dropoff-d']) && $session->data['dropoff-d'] != '') {
	$book_info = array_merge($book_info, array('end_date' => date('Y-m-d',strtotime($session->data['dropoff-d']))));
} else $book_info = array_merge($book_info, array('end_date' => '0000-00-00'));

if(isset($session->data['pickup-t'])) {
	$book_info = array_merge($book_info, array('timefrom' => $session->data['pickup-t']));
}

if(isset($session->data['dropoff-t']) && $session->data['dropoff-t'] != '') {
	$book_info = array_merge($book_info, array('timeto' => $session->data['dropoff-t']));
} else $book_info = array_merge($book_info, array('timeto' => '00:00:00'));

if( isset( $session->data['car_id'] ) && isset( $session->data['method'] ) ) {
	$book_info = array_merge($book_info, array('total' => getCarCost($session->data['car_id'], $session->data['method'])));
}

if(isset($session->data['grand_total'])) {
	$book_info = array_merge($book_info, array('grand_total' => $session->data['grand_total']));
}

if( IS_AJAX ) {
	if(isset($request->post['data'])){
		$user_data = $request->post['data'];
		foreach($request->post['data'] as $val) {						if($val['name'] == 'payment-type') {				$book_info = array_merge($book_info, array('zahlungsart' => $val['value']));						}					}
	}
} else {
	if( isset($request->post) && count($request->post) > 1 ) {
		$user_data = $request->post;		
		if(isset($request->post['zahlungsart'])) {
			$book_info = array_merge($book_info, array('zahlungsart' => $request->post['payment-type']));
		}	
	}
}
if( isset($request->post) && count($request->post) > 1 ) {
	//START STORE DATA IN DB
	if($logged_in) {
		$cust_idd = $user->updateUser($user_data, $cust_id);
	} else {
		$cust_idd = $user->addUser($user_data);
	}
	
	if( $cust_idd ) {
		$book_info = array_merge($book_info, array('customers_id' => $cust_idd));
		
		$booking->addBooking($book_info);
		//END STORE DATA IN DB
		
		$htmls = getMailsHTML($book_info, $user_data);	
		//FORMAT OF $htmls array
		//array('book_user' => $book_user, 'book_admin' => $book_admin, 'new_user' => $new_user, 'new_admin' => $new_admin, 'cust_info' => array('name' = 'NAME', 'mailid' => 'user@example.com' ) );
		extract($htmls);
		//START SENDING MAIL
		//MAILS TO ADMINS
		$mail->setFrom($cust_info['name']);
		$mail->setReplyTo($cust_info['mailid']);
		$mail->setSender($cust_info['name']);
		$mail->setSubject('Als Benutzer registrieren');
		if( ! $logged_in ) {
			$mail->setHtml($new_admin);
			foreach($admin_mails as $email) {
				$mail->setTo($email);
				$mail->send();
			}
		}
		$mail->setSubject('New Booking info');
		$mail->setHtml($book_user);
		foreach($admin_mails as $email) {
			$mail->setTo($email);
			$mail->send();
		}
		
		//MAILS TO USER
		$mail->setTo($cust_info['mailid']);
		$mail->setFrom('Car Booking');
		$mail->setReplyTo(ADMIN1_MAIL);
		$mail->setSender(ADMIN1_MAIL);
		$mail->setSubject('New registration');
		if( ! $logged_in ) {
			$mail->setHtml($new_user);
			$mail->send();
		}
		$mail->setSubject('Booking info');
		$mail->setHtml($book_user);
		$mail->send();
		//END SENDING MAIL				//AUTO LOGIN NEW USER		if( !$logged_in  && $cust_idd ) {			$user->autoLogin($cust_idd);		}
		
		$msg = 'Buchung erfolgreich abgeschlossen , und Sie würden eine Bestätigungsmail erhalten . Vielen Dank';
		
	} else {
		$msg = 'Email id already registered';
	}
}?>

<nav class="idealsteps-nav">
		<ul>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">Schritt 1<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">Schritt 2<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">Schritt 3<span class="counter"></span></a>
			</li>
			<li class="">
				<a onclick="return false;" href="#" tabindex="-1">Schritt 4<span class="counter"></span></a>
			</li>
			<li class="idealsteps-step-active">
				<a onclick="return false;" href="#" tabindex="-1">Schritt 5</a>
			</li>
		</ul>
	</nav>
	
	<section class="idealsteps-step">
		<div class="field idealforms-field idealforms-field-text login-link">
			<?php if( $user->is_login() ) { ?>
			Hallo, <?php if( isset($session->data['vorname']) && !empty($session->data['vorname']) ) { echo $session->data['vorname']; } else { echo 'User';} ?> 
			<a href="#" id="logout-link">Abmelden</a>
			<span class="login-err" id="logout_err" style="display: none;">ERROR</span>
			<?php } else { ?>
			Stammkunden bitte <a href="#login-dialog" data-toggle="modal">Einloggen</a>
			<?php } ?>
		</div>
	</section>

	<form action="#" novalidate="" autocomplete="off" class="idealforms" id="form1" method="post">

		<div class="idealsteps-wrap">

			<!-- SubmitnMail -->
			<section class="idealsteps-step">				
				
				<div class="field buttons">
				  <?php echo $msg; ?>
				</div>
					
				<div class="field buttons">
				  <label class="main">&nbsp;</label>
				  <button type="button" class="submit" id="continueother">Weiter Weitere Karten</button>
				</div>
				
			</section>
		  
		</div>

        <span id="invalid"></span>

    </form>
	
	<script>
		$(document).ready(
			function(){
				$('#continueother').click(
					function(){
						<?php if( IS_AJAX == true ) { ?>
						$('#progressbar').modal('show');
						$.ajax({
							url: '<?php echo BASE_URI; ?>/ajax.php',
							dataType: 'html',
							type: 'post',
							data: { "action" : 'step1' },
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
						$(location).attr('href', '<?php echo BASE_URI; ?>/step1');
						<?php } ?>
					}
				);
			}
		);
	</script>
<?php include_once(GLOBAL_JS); ?>
<?php //$session->destroy(); ?><?php if( $cust_idd ) { ?>
<?php $booking->resetBooking(); ?>
<?php } ?>