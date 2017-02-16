<?php
final class Booking {
	
	public $book_option = '';
	
	public $total = 0.00;
	
	public $grand_total = 0.00;
	
	public $booking_id = null;
	
	public $method = 'HRLY';
	
	public function __construct() {
		
	}

	function setBookingOption($data) {
		
		global $session;
		
		foreach( $data as $option ) {
			
			if($option['name'] == 'caroption')
				
				$this->book_option .= $option['value'] . '~';
				
			/*elseif($option['name'] == 'grand-total')

				$this->grand_total = $option['value'];*/
			
		}
		
		$this->book_option = substr($this->book_option, 0, -1);
		
		$this->grand_total = getCarCost($session->data['car_id'], $session->data['method']);
		
		$checked_cost = getCheckedCost( str_replace('~', ',', $this->book_option) )->rows;
		
		foreach($checked_cost as $cost) {

			$this->grand_total += $cost['opt_cost'];

		}

		$session->data['book_option'] = $this->book_option;
		
		$session->data['grand_total'] = number_format($this->grand_total, 2, '.', '');

	}
	
	function setBookingMethod($data) {
		
		global $session;
	
		$this->method = $data['method'];
	
		$session->data['method'] = $data['method'];
		
		if( isset( $session->data['pickup-d'] ) ) unset($session->data['pickup-d']);
		
		if( isset( $session->data['dropoff-d'] ) ) unset($session->data['dropoff-d']);
		
		if( isset( $session->data['pickup-t'] ) ) unset($session->data['pickup-t']);
		
		if( isset( $session->data['dropoff-t'] ) ) unset($session->data['dropoff-t']);
	
	}

	function addBooking($data) {
		
		global $db;
		
		extract($data);
		
		$sql = "INSERT INTO autotermine(car_id, options, start_date, end_date, timefrom, timeto, total, grand_total, zahlungsart, customers_id) VALUES ('".$car_id."', '".$options."', '".$start_date."', '".$end_date."', '".$timefrom."', '".$timeto."', '".$total."', '".$grand_total."', '".$zahlungsart."','".$customers_id."')";
		
		$db->query($sql);
		
		$this->booking_id = $db->getLastId();
		
	}
	
	function resetBooking() {
		
		global $session;
		
		if( isset( $session->data['car_id'] ) ) unset($session->data['car_id']);
		
		if( isset( $session->data['method'] ) ) unset($session->data['method']);
		
		if( isset( $session->data['book_option'] ) ) unset($session->data['book_option']);
		
		if( isset( $session->data['grand_total'] ) ) unset($session->data['grand_total']);
		
		if( isset( $session->data['pickup-d'] ) ) unset($session->data['pickup-d']);
		
		if( isset( $session->data['dropoff-d'] ) ) unset($session->data['dropoff-d']);
		
		if( isset( $session->data['pickup-t'] ) ) unset($session->data['pickup-t']);
		
		if( isset( $session->data['dropoff-t'] ) ) unset($session->data['dropoff-t']);

	}
	
}