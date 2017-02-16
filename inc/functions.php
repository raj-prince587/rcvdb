<?php
/*function getTimeList($start, $end, $attr = '') {
	$html = '';
	$html .= '<select $attr>';
	for($i = 1; $i <= 24; $i++):
		$html .= '<option value="' . date("h:i", strtotime("$i:00")) . '">' . date("h:iA", strtotime("$i:00")) . '</option>';
	endfor;
	$html .= '</select>';
	return $html;
}*/

function timeDiff($start, $end) {
	$start = strtotime($start);
	$end = strtotime($end);
	if($end < $start) {
		$end += 24 * 60 * 60;
	}
	$hours = ($end - $start) / 60;
	return $hours /= 60;
}

function dateDiff($date1, $date2) {
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);
	$dateDiff = $date1 - $date2;
	return $fullDays = floor($dateDiff/(60*60*24)) + 1;
}

function getMailsHTML($book_info, $user_data) {
	
	global $logged_in, $admin_mails, $session, $booking;

	extract($book_info);

	if(IS_AJAX) {

		$arr = array();

		foreach( $user_data as $fields ) {

			$arr =  array_merge($arr, array($fields['name'] => $fields['value']));

		}

		extract($arr);

	} else {

		extract($user_data);

	}
	$book_user = '';
	$book_admin = '';
	$new_user = '';
	$new_admin = '';
	
	$mail_head = "<html>
					<style>
					table tr td{ font-size:18px; padding:10px }
					table tr td:first-child{background-color:#eee;}
					table tr td:last-child{background-color:#ccc;font-weight:600; color:#444;}
					</style>
					<body style='color:#5e5f61;font-size:14px; font-family:Tahoma, Geneva, sans-serif;'>
						<table width='100%' style='border:1px solid #e8e7e4; border-top:3px solid #888785; border-bottom:none; margin:0; padding:10px'>
							<thead>";
	$mail_footer = "	</table>
					</body>
					</html>";
	
	$book_user .= $mail_head . "<tr><th colspan='2' bgcolor='#222222' style='padding:15px; color:#fff'>Booking Info</th></tr>
							</thead>
							<tbody>
								<tr style='border-bottom:1px solid #eeeeee;'>
									<td width='70%' bgcolor='#f0f0f0'>Car</td>
									<td width='30%' bgcolor='#aaaaaa'>" . $car . "</td>
								</tr>
								<tr style='border-bottom:1px solid #eeeeee;'>
									<td width='70%' bgcolor='#f0f0f0'>Abholtag & Abholzeit</td>
									<td width='30%' bgcolor='#aaaaaa'>" . $start_date ." & " . $timefrom . "</td>
								</tr>
								<tr style='border-bottom:1px solid #eeeeee;'>
									<td width='70%' bgcolor='#f0f0f0'>Ruckgabetag & Ruckgabezeit</td>
									<td width='30%' bgcolor='#aaaaaa'>" . $end_date ." & " . $timeto . "</td>
								</tr>
								<tr style='border-bottom:1px solid #eeeeee;'>
									<td width='70%' bgcolor='#f0f0f0'>Total</td>
									<td width='30%' bgcolor='#aaaaaa'>" . $total . " " . CURR_SY . "</td>
								</tr>";
								
	if( isset( $session->data['book_option'] ) ) {
		
		if(strlen($session->data['book_option']) > 0) {
			
			$checked_cost = getCheckedCost( str_replace('~', ',', $session->data['book_option']) )->rows;

			foreach($checked_cost as $val) {

				$book_user .= "<tr style='border-bottom:1px solid #eeeeee;'>
								<td width='70%' bgcolor='#f0f0f0'>". $val['text'] ."</td>
								<td width='30%' bgcolor='#aaaaaa'>" . number_format((float)$val['opt_cost'], 2, '.', '') . " " . CURR_SY . "</td>
							</tr>";

			}

		}

	}
		
	
	$book_user .= "<tr style='border-bottom:1px solid #eeeeee;'>
					<td width='70%' bgcolor='#f0f0f0'>Grand Total</td>
					<td width='30%' bgcolor='#aaaaaa'>" . $grand_total . " " . CURR_SY . "</td>
				</tr>
				<tr><th colspan='2' bgcolor='#222222' style='padding:15px; color:#fff'>Pickup Address Details</th></tr>";
	/*$book_admin .= $mail_head;*/
	
	if( ! $logged_in ) {
		
		$new_user .= $mail_head . "<tr><th colspan='2' bgcolor='#222222' style='padding:15px; color:#fff'>Login-Daten</th></tr>
							</thead>";
		$new_admin .= $mail_head . "<tr><th colspan='2' bgcolor='#222222' style='padding:15px; color:#fff'>New user registration</th></tr>
							</thead>";
	
	}
	
	$personal_info = "<tr style='border-bottom:1px solid #eeeeee;'>
						<td width='70%' bgcolor='#f0f0f0'>Firma</td>
						<td width='30%' bgcolor='#aaaaaa'>". $firma ."</td>
					</tr>
					<tr>
						<td>Vorname</td>
						<td>". $vorname ."</td>
					</tr>
					<tr>
						<td>Nachname</td>
						<td>". $nachname ."</td>
					</tr>
					<tr>
						<td>Strasse</td>
						<td>". $strasse ."</td>
					</tr>
					<tr>
						<td>Postleitzahl</td>
						<td>". $postleitzahl ."</td>
					</tr>
					<tr>
						<td>Ort</td>
						<td>". $ort ."</td>
					</tr>	
					<tr>
						<td>Land</td>
						<td>". $land ."</td>
					</tr>	
					<tr>
						<td>Telefonnummer</td>
						<td>". $telefonnummer ."</td>
					</tr>
					<tr>
						<td>Telefaxnummer</td>
						<td>". $telefaxnummer ."</td>
					</tr>	
					<tr>
						<td>eMail-Adresse</td>
						<td>". $eMail ."</td>
					</tr>";
	
	if( ! $logged_in ) {
	
		$login_detail = "<tr>
							<td>Benutzername</td>
							<td>". $eMail ."</td>
						</tr>";
		
		$new_admin .= $login_detail . $personal_info;
		
		$login_detail .= "<tr>
							<td>Passwort</td>
							<td>". $passwort ."</td>
						</tr>";
		
		$new_user .= $login_detail;

	}

	$book_user .= $personal_info . "<tr>
						<td>Zahlungsart</td>
						<td>". $zahlungsart ."</td>
					</tr>
				</tbody>";

	$book_user .= $mail_footer;
	/*$book_admin .= $mail_footer;*/

	if( ! $logged_in ) {
		$new_user .= $mail_footer;
		$new_admin .= $mail_footer;
	}

	return array('book_user' => $book_user, 'book_admin' => $book_admin, 'new_user' => $new_user, 'new_admin' => $new_admin, 'cust_info' => array('name' => $vorname . ' ' . $nachname, 'mailid' => $eMail ) );

}
