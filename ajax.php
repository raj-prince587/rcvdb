<?php
//header('Content-Type:multipart/form-data');
if( file_exists( dirname(__FILE__) . '/startup.php') )
{
	include_once( dirname(__FILE__) . '/startup.php');
} else /*$error[] = dirname(__FILE__) . '/startup.php not available!';*/ { echo dirname(__FILE__) . '/startup.php not available!'; die; }

if( isset($request->post['action']) && $request->post['action'] == 'SETMET' )
{
	$booking->setBookingMethod($request->post);
	return;
}

if( isset($request->post['action']) && $request->post['action'] == 'VER_LOGIN' )
{
	echo $user->validateLogin($request->post['data']);
	return;
}

if( isset($request->post['action']) && $request->post['action'] == 'VERIFY_EID' )
{
	echo $user->verifyMailID($request->post['mailid']);
	return; 
}

if( isset($request->post['action']) && $request->post['action'] == 'UP_PASS' )
{
	if( isset($session->data['cust_id']) && !empty($session->data['cust_id']) )
	{
		return $user->updatePass($request->post['pass'], $session->data['cust_id']);
	} else return 0;
	return;
}

if( isset($request->post['action']) && $request->post['action'] == 'LOGOUT' )
{
	echo $user->logout();
	return;
}

if( isset($request->post['action']) && $request->post['action'] == 'UP_FRM' )
{
	if( isset($_FILES) )
	{
		if( ! file_exists( BASE_PATH.'/uploads/'.SESS_ID ) )
		{
			mkdir( BASE_PATH.'/uploads/'.SESS_ID , 0777, true );
		}

		foreach($_FILES as $key => $file)
		{
			if( $file['error'] == 0 )
			{
				move_uploaded_file($file['tmp_name'], BASE_PATH.'/uploads/'.SESS_ID.'/'.$file['name']);
			}
		}
		$out = '';
		$command = 'mysqlfrm --server=dev:dev@localhost:3306 --quiet "'.BASE_PATH.'\uploads\\'.SESS_ID.'" --port=3333 > output.txt';
		exec($command);
		$file1 = fopen("output.txt", "r") or die("Unable to open file!");
		// Output one line until end-of-file
		while(!feof($file1)) {
			$line = fgets($file1);
			$pos = strpos($line, '#');
			$posW = strpos($line, 'WARNING');
			$posE = strpos($line, 'ENGINE');
			if( $posE !== false )
			{
				$line .= ';';
			}
			if( $pos === 0 || $posW === 0 )
			{
			}
			else
			{
				$out .= $line;
			}
		}
		$out = str_replace('`'.SESS_ID.'`.', '', $out);
		echo $out;
		fclose($file1);
	}
	die;	
}

if(isset($request->post['action']))
{
	$file = $session->data['cur_action'] = $request->post['action'];
} else $file = 'index';

if(file_exists( BASE_PATH . '/inc/' . $file . '.php' ))
{
	include_once( BASE_PATH . '/inc/' . $file . '.php' );
}
else if(file_exists( BASE_PATH . '/inc/index.php' ))
{
	include_once( BASE_PATH . '/inc/index.php' );
} else $error[] = BASE_PATH . '/inc/index.php not available!' ;