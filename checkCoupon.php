<?php
include_once('../wp-load.php');

if( !isset($_POST['authenticate']) || $_POST['authenticate']==""){
	die("<?xml version='1.0'?><checkCoupon><error>1</error><desc>Service Not Accessible</desc></checkCoupon>");
}elseif($_POST['authenticate'] != "fdljgrirtgibmpkjkgffdndfj1123124"){
	die("<?xml version='1.0'?><checkCoupon><error>1</error><desc>Service Not Accessible</desc></checkCoupon>");
}
if( !isset($_POST['regId']) || $_POST['regId']==""){
	die("<?xml version='1.0'?><checkCoupon><error>1</error><desc>Registration Id is Empty</desc></checkCoupon>");
}else
    $regId = $_POST['regId'];
if( !isset($_POST['eventcode']) || $_POST['eventcode']==""){
	die("<?xml version='1.0'?><checkCoupon><error>1</error><desc>Event Code is Empty</desc></checkCoupon>");
}else{
    $eventcode = $_POST['eventcode'];
	if( !isset($_POST['attendeeId']) || $_POST['attendeeId']==""){
		die("<?xml version='1.0'?><checkCoupon><error>1</error><desc>Attendee Id is Empty</desc></checkCoupon>");
	}else{
		$attendeeId = $_POST['attendeeId'];
	}
	
	if( !isset($_POST['ignorePayment']) || $_POST['ignorePayment']==""){
		die("<?xml version='1.0'?><checkCoupon><error>1</error><desc>Ignore Payment Field is Empty</desc></checkCoupon>");
	}else{
		$ignorePayment = $_POST['ignorePayment'];
	}
	
	$query_event = "SELECT * FROM {$wpdb->prefix}events_detail WHERE event_code='".$eventcode."'";
	$result_event = $wpdb->get_results($query_event);
	if(count($result_event) == 0){
		die("<?xml version='1.0'?><attendies><error>3</error><desc>No Events For the Code</desc></attendies>");
	}
	$eventId = $result_event[0]->id;
	$query = "SELECT * FROM {$wpdb->prefix}events_attendee WHERE registration_id='".$regId."' AND event_id=".$eventId." AND id=".$attendeeId;
	$result =  $wpdb->get_results($query);
	if(count($result) == 0){
		die("<?xml version='1.0'?><checkCoupon><error>3</error><desc>No Coupons For The Attendee</desc></checkCoupon>");
	}else{
		$row = $result[0];
		if($row->payment_status == "Incomplete" && strtolower($ignorePayment) == "no"){
			die("<?xml version='1.0'?><checkCoupon><error>4</error><desc>Payment Status Incomplete</desc></checkCoupon>");
		}
		if(($row->checked_in_quantity < $row->quantity) || ($row->checked_in_quantity == 0) ){
			$query_Update = "UPDATE {$wpdb->prefix}events_attendee SET checked_in_quantity = checked_in_quantity + 1 WHERE id=".$row->id;
			if( $wpdb->query($query_Update)){
				echo "<?xml version='1.0'?><checkCoupon><error>0</error><desc>SUCCESS</desc></checkCoupon>";
			} else {
				echo "<?xml version='1.0'?><checkCoupon><error>2</error><desc>mysql_error</desc></checkCoupon>";
			}
		}else{
			echo "<?xml version='1.0'?><checkCoupon><error>0</error><desc>Attendee Already Checked In</desc></checkCoupon>";
		}
	}
}