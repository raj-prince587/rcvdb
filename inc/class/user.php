<?php
final class User {
	
	protected $cust_id;
	
	public $vorname;
	
	public function __construct() {
	
	}
	
	static function validateLogin($data) {

		global $db, $session;
		
		if(isset($data[0]['value'])) {

			$sql = "SELECT cust_id, vorname, passwort, user_name FROM customers WHERE user_name='". $data[0]['value'] ."'";

			$result = $db->query($sql)->row;

			if($db->countAffected() < 1) {

				return 0;

			}

			if(isset($data[1]['value'])) {

				if( md5($data[1]['value']) == $result['passwort'] ) {

					$this->cust_id = $session->data['cust_id'] = $result['cust_id'];

					$this->vorname = $session->data['vorname'] = $result['vorname'];

					return 2;

				} else return 1;

			} else return 1;

		}

		return 0;

	}
	
	static function verifyMailID($mailid) {
		
		global $db;
		
		$db->query("SELECT cust_id FROM customers WHERE user_name='" . $mailid . "'");
		
		if($db->countAffected() > 0) {

			return 0;

		} else return 1;

	}
	
	static function logout() {
		
		global $session;
		
		if(isset($session->data['cust_id'])) {
				
			unset($session->data['cust_id']);
			
			return 1;
			
		} else return 0;
		
	}
	
	static function addUser($data) {
		
		global $db, $session;
		
		if(IS_AJAX) {
			
			$arr = array();
			
			foreach( $data as $fields ) {

				$arr =  array_merge($arr, array($fields['name'] => $fields['value']));
				
			}
		
			extract($arr);
			
		} else {
			
			
			extract($data);
			
		}
		
		$db->query("SELECT cust_id FROM customers WHERE user_name='" . $eMail . "'");
		
		if($db->countAffected() > 0) {
			
			return false;

		}
		
		$sql = "INSERT INTO customers ( firma, vorname, nachname, user_name, passwort, strasse, ort, postleitzahl, land, telefonnummer, telefaxnummer, eMail ) VALUES ('".$firma."', '".$vorname."', '".$nachname."', '".$eMail."','".md5($passwort)."', '".$strasse."', '".$ort."', '".$postleitzahl."', '".$land."', '".$telefonnummer."', '".$telefaxnummer."', '".$eMail."')";
		
		$db->query($sql);
		
		if($db->countAffected() > 0) {
			
			return $db->getLastId();
			
		} else return false;
		
	}
	
	static function updateUser($data, $cust_id) {
		
		global $db;
		
		if(IS_AJAX) {
			
			$arr = array();
			
			foreach( $data as $fields ) {

				$arr =  array_merge($arr, array($fields['name'] => $fields['value']));
				
			}
		
			extract($arr);
			
		} else {
			
			
			extract($data);
			
		}
		
		
		$sql = "UPDATE customers SET firma = '".$firma."', vorname = '".$vorname."', nachname = '".$nachname."', strasse = '".$strasse."', ort = '".$ort."', postleitzahl = '".$postleitzahl."', land = '".$land."', telefonnummer = '".$telefonnummer."', telefaxnummer = '".$telefaxnummer."', eMail = '".$eMail."'";
		
		if( ! empty($passwort) ) {
			$sql .= ", passwort = '" . md5($passwort) . "'";
		}
		
		$sql .= " WHERE cust_id = " . $cust_id;
		
		$db->query($sql);

		//if($db->countAffected() > 0) {
			
		return $cust_id;
			
		//} else return false;
	
	}
	
	static function updatePass($passwort, $cust_id) {
	
		global $db;
	
		if( !empty($passwort)) {
			
			$sql = "UPDATE customers SET passwort = '". md5($passwort) ."' WHERE cust_id = " . $cust_id;
	
			$db->query($sql);
			
			return 1;
			
		} else return 0;

	
	}
	
	static function getUser($cust_id) {
		
		global $db;
		
		$sql = "SELECT firma, vorname, nachname, strasse, ort, postleitzahl, land, telefonnummer, telefaxnummer, eMail FROM customers WHERE cust_id=". $cust_id;

		return $db->query($sql)->row;
		
	}
	
	static function is_login() {

		global $session;
		
		if( isset($session->data['cust_id']) && !empty($session->data['cust_id']) ) {

			return true;

		}

	}
	
	static function autoLogin($cust_id) {

		global $db, $session;

		$sql = "SELECT cust_id, vorname FROM customers WHERE cust_id=". $cust_id;

		$result = $db->query($sql)->row;

		$this->cust_id = $session->data['cust_id'] = $result['cust_id'];

		$this->vorname = $session->data['vorname'] = $result['vorname'];

	}

}