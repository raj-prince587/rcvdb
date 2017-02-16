<?php
function getOption( $car_id ) {
	
	global $db;
	
	return $db->query('SELECT opt_id, car_id, name, text, opt_cost FROM options WHERE car_id=' . $car_id );
	
}

function getCheckedCost( $id ) {

	global $db;

	return $db->query('SELECT text, opt_cost FROM options WHERE opt_id IN (' . $id . ')');

}

function getCarName($car_id) {
	
	global $db;

	return $db->query("SELECT car_id, name FROM auto WHERE car_id='" . $car_id . "'")->row;
	
}

function getCarCost( $car_id, $method ) {

	global $db, $session;

	$result = $db->query('SELECT car_id, '. $method .' FROM auto WHERE car_id=' . $car_id );
	
	$carCost = $result->row[$method];
	
	if( isset($session->data['pickup-t']) ) {
		$start_t = $session->data['pickup-t'];
	}
	if( isset($session->data['pickup-d']) ) {
		$start_d = $session->data['pickup-d'];
	}
	if( isset($session->data['dropoff-d']) ) {
		$end_d = $session->data['dropoff-d'];
	}
	switch($method) {
		case 'HRLY':
			if( isset($session->data['dropoff-t']) ) {
				$end_t = $session->data['dropoff-t'];
			}
			$hours = timeDiff($start_t, $end_t);
			$total = (float)ceil($hours) * (float)$carCost;
			break;
		case 'PDAY':
			$days = dateDiff($end_d, $start_d);
			$total = (float)ceil($days) * (float)$carCost;
			break;
		case 'WEND':
		case 'PWEK':
			$total = (float)$carCost;
			break;
	}
	
	return number_format($total, 2, '.', '');

}

function getAvailablity($car_id) {
	
	global $db;
	
	return $db->query("SELECT * FROM autotermine WHERE car_id='" . $car_id . "' AND start_date >= CURDATE()" );
	
}

function checkAvailability( $car_id, $data) {
	
	global $db;
	
	return $db->query("SELECT DISTINCT start_date FROM autotermine WHERE car_id='" . $car_id . "' AND start_date BETWEEN '".date('Y-m-d', strtotime($data['start']))."'  AND '".date('Y-m-d', strtotime($data['end']))."'");
	
}