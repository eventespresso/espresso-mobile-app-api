<?php
include_once('../wp-config.php');
include_once('../wp-load.php');
include_once('../wp-includes/wp-db.php');

if( !isset($_POST['authenticate']) || $_POST['authenticate']=="")
{
	die("<?xml version='1.0'?><manualCheckIn><error>1</error><desc>Service Not Accessible</desc></manualCheckIn>");
}
elseif($_POST['authenticate'] != "fdljgrirtgibmpkjkgffdndfj1123124")
{
	die("<?xml version='1.0'?><manualCheckIn><error>1</error><desc>Service Not Accessible</desc></manualCheckIn>");
}

if( !isset($_POST['eventcode']) || $_POST['eventcode']=="")
{
	die("<?xml version='1.0'?><manualCheckIn><error>1</error><desc>Event Code is empty</desc></manualCheckIn>");
}
else
    $eventcode = $_POST['eventcode'];

$query_event = "SELECT * FROM {$wpdb->prefix}events_detail WHERE event_code='".$eventcode."'";
$result_event = $wpdb->get_results($query_event);
if(count($result_event) == 0)
{
	die("<?xml version='1.0'?><attendies><error>3</error><desc>No Events For the Code</desc></attendies>");
}
$eventId = $result_event[0]->id;
$first = true;
$query = "SELECT * FROM {$wpdb->prefix}events_attendee  WHERE ";
 if(isset($_POST['email']) && $_POST['email']!="")
 {
 	if(!$first)
		$query .=  " AND ";
	elseif($first)
		$first = false;
 	 $query .=  " email = '".$_POST['email']."' ";
	 
 }
  if(isset($_POST['fname']) && $_POST['fname']!="")
 {
 	 	if(!$first)
		$query .=  " AND ";
	elseif($first)
		$first = false;

 	 $query .=  " fname = '".$_POST['fname']."' ";
 }
  if(isset($_POST['lname']) && $_POST['lname']!="")
 {
 	 	if(!$first)
		$query .=  " AND ";
	elseif($first)
		$first = false;

 	 $query .=  " lname = '".$_POST['lname']."' ";
 }
  if(isset($_POST['phone']) && $_POST['phone']!="")
 {
  	if(!$first)
		$query .=  " AND ";
	elseif($first)
		$first = false;
 	 $query .=  " phone = '".$_POST['phone']."' ";
 }
 $query .= " AND event_id=".$eventId;
$result =  $wpdb->get_results($query);
if(count($result) == 0)
{
	die("<?xml version='1.0'?><manualCheckIn><error>3</error><desc>No Results for the Search</desc></manualCheckIn>");
}
else
{
	$response = "<?xml version='1.0'?><attendies><error>0</error><desc>Success</desc>";
	foreach ($result as $row) {
		$response .= "<attendee>";
		$response .= "<id>".$row->id."</id>";
		$response .= "<registration_id>".$row->registration_id."</registration_id>";
		$response .= "<lname>".$row->lname."</lname>";
		$response .= "<fname>".$row->fname."</fname>";
//		$response .= "<address>".$row->address."</address>";
//		$response .= "<address2>".$row->address2."</address2>";
//		$response .= "<city>".$row->city."</city>";
//		$response .= "<state>".$row->state."</state>";
//		$response .= "<zip>".$row->zip."</zip>";
//		$response .= "<country_id >".$row->country_id."</country_id >";
//		$response .= "<organization_name>".$row->organization_name."</organization_name>";
//		$response .= "<vat_number>".$row->vat_number."</vat_number>";
		$response .= "<email>".$row->email."</email>";
		$response .= "<phone>".$row->phone."</phone>";
//		$response .= "<hear>".$row->hear."</hear>";
		$response .= "<payment>".$row->payment."</payment>";
		$response .= "<date>".$row->date."</date>";
		$response .= "<payment_status>".$row->payment_status."</payment_status>";
//		$response .= "<txn_type>".$row->txn_type."</txn_type>";
//		$response .= "<txn_id>".$row->txn_id."</txn_id>";
		$response .= "<amount_pd>".$row->amount_pd."</amount_pd>";
		$response .= "<price_option>".$row->price_option."</price_option>";
		$response .= "<coupon_code >".$row->coupon_code."</coupon_code>";
		$response .= "<quantity>".$row->quantity."</quantity>";
		$response .= "<payment_date>".$row->payment_date."</payment_date>";
		$response .= "<event_id>".$row->event_id."</event_id>";
		$response .= "<event_time>".$row->event_time."</event_time>";
		$response .= "<end_time>".$row->end_time."</end_time>";
		$response .= "<start_date>".$row->start_date."</start_date>";
		$response .= "<end_date>".$row->end_date."</end_date>";
		$response .= "<attendee_session>".$row->attendee_session."</attendee_session>";
		$response .= "<transaction_details>".$row->transaction_details."</transaction_details>";
		$response .= "<checked_in>".$row->checked_in."</checked_in>";
		$response .= "<checked_in_quantity>".$row->checked_in_quantity."</checked_in_quantity>";
		$response .= "</attendee>";
	}
	$response .= "</attendies>";
	echo $response;
}
?>