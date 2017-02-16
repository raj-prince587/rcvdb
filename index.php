<?php

if( file_exists( dirname(__FILE__) . '/startup.php') ) {
	
	include_once( dirname(__FILE__) . '/startup.php') ;
	
} else /*$error[] = dirname(__FILE__) . '/startup.php not available!';*/ { echo dirname(__FILE__) . '/startup.php not available!'; die; }

if( ! defined('BASE_PATH') ) {

	define('BASE_PATH', dirname(__FILE__) );
	
}

if( file_exists( BASE_PATH . '/inc/header.php') ) {
	
	include_once( BASE_PATH . '/inc/header.php');
	
} else $error[] = BASE_PATH . '/inc/header.php not available!';

//echo $_SERVER['REQUEST_URI'];
//print_r( explode( '/', $_SERVER['REQUEST_URI']) );

if( isset( $session->data['cur_action'] ) && IS_AJAX == true ){
	
	$file = $session->data['cur_action'];
	
} else {

	$file_arr = explode( '/', $_SERVER['REQUEST_URI']);

	$session->data['cur_action'] = $file = $file_arr[1];
	
}

//$file = $session->data['cur_action'] = $file_arr[1];

if(file_exists( BASE_PATH . '/inc/' . $file . '.php' )) {
	
	include_once( BASE_PATH . '/inc/' . $file . '.php' );
	
} else if(file_exists( BASE_PATH . '/inc/index.php' )) {
	
	include_once( BASE_PATH . '/inc/index.php' );
	
} else $error[] = BASE_PATH . '/inc/index.php not available!';

if( file_exists( BASE_PATH . '/inc/footer.php') ) {
	
	include_once( BASE_PATH . '/inc/footer.php');
	
} else $error[] = BASE_PATH . '/inc/footer.php not available!';

if( file_exists( BASE_PATH . '/cleanup.php') ) {
	
	include_once( BASE_PATH . '/cleanup.php') ;
	
} else $error[] = BASE_PATH . '/cleanup.php not available!';

if(count($error) > 0){
	
	echo '<pre/>';
	
	print_r($error);	
	
}