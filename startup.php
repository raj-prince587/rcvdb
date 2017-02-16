<?php
session_start();
//error_reporting(E_ALL);
global $error, $db, $session, $mail, $logged_in, $admin_mails;
$error = array();
$logged_in = false;

//include config.php file if exists
if( file_exists( dirname(__FILE__) . '/config.php') ) {
	
	include_once( dirname(__FILE__) . '/config.php' );
	
	//include constants.php file if exists
	if( file_exists( dirname(__FILE__) . '/constants.php') ) {
		
		include_once( dirname(__FILE__) . '/constants.php' );
		
		$admin_mails = array( ADMIN1_MAIL, ADMIN2_MAIL );
		
	} else $error[] = dirname(__FILE__) . '/constants.php not available!' ;
	
	//include mysql.php file if exists
	if( file_exists( LIB_PATH . 'db/mysql.php') ) {
		
		include_once( LIB_PATH . 'db/mysql.php' );
		
		//Instanciating $db global variable to execute the query
		$db = new MySQL( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		
	} else $error[] = LIB_PATH . 'db/mysql.php not available!' ;
	
	//include session.php file if exists
	if( file_exists( LIB_PATH . 'session.php') ) {
		
		include_once( LIB_PATH . 'session.php' );
		
		//Instanciating $sesson global variable to store the session values
		$session = new Session();
		
	} else $error[] = LIB_PATH . 'session.php not available!' ;
	
	//include session.php file if exists
	if( file_exists( LIB_PATH . 'request.php') ) {
		
		include_once( LIB_PATH . 'request.php' );
		
		//Instanciating $sesson global variable to store the session values
		$request = new Request();
		
	} else $error[] = LIB_PATH . 'request.php not available!' ;
	
	//include mail.php file if exists
	if( file_exists( LIB_PATH . 'mail.php') ) {
		
		include_once( LIB_PATH . 'mail.php' );
		
		//Instanciating $sesson global variable to store the session values
		$mail = new Mail();
		
	} else $error[] = LIB_PATH . 'mail.php not available!' ;
	
	//include functions.php file if exists
	if( file_exists( INC_PATH . 'functions.php') ) {
		
		include_once( INC_PATH . 'functions.php' );
		
	} else $error[] = INC_PATH . 'functions.php not available!';
	
	//include db-function.php file if exists
	if( file_exists( INC_PATH . 'db-function.php') ) {
		
		include_once( INC_PATH . 'db-function.php' );
		
	} else $error[] = INC_PATH . 'db-function.php not available!';
	
	/*//include booking-class.php file if exists
	if( file_exists( CLASS_PATH . 'booking-class.php') ) {
		
		include_once( CLASS_PATH . 'booking-class.php' );
		
		//Instanciating $sesson global variable to store the session values
		$booking = new Booking();
		
	} else $error[] = CLASS_PATH . 'booking-class.php not available!' ;
	
	//include user-class.php file if exists
	if( file_exists( CLASS_PATH . 'user-class.php') ) {
		
		include_once( CLASS_PATH . 'user-class.php' );
		
		//Instanciating $sesson global variable to store the session values
		$user = new User();
		
	} else $error[] = CLASS_PATH . 'user-class.php not available!' ;*/
	if ($handle = opendir(CLASS_PATH)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				//echo "$entry\n";
				if( file_exists( CLASS_PATH . $entry ) ) {
					include_once( CLASS_PATH . $entry );
					//$user = new User();
				} else $error[] = CLASS_PATH . "$entry not available!";
			}
		}
		closedir($handle);
	}
	
	/***************************************************TO CHECK USER LOGGED IN OR NOT**********************************************/
	if( isset($session->data['cust_id']) && !empty($session->data['cust_id']) ) {

		$logged_in = true;
	
	}
	
	/******************************************************************************************************************************/

} else $error[] = dirname(__FILE__) . '/config.php not available!';