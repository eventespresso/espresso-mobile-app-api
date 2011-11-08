<?php
include_once('../wp-load.php');

global $org_options;

//Uncomment the next line if using multiple event managers
//$multi_user = true;

if( !isset($_POST['authenticate']) || $_POST['authenticate']==""){
	die("<?xml version='1.0'?><events><error>1</error><desc>Service Not Accessible</desc></events>");
}elseif($_POST['authenticate'] != "fdljgrirtgibmpkjkgffdndfj1123124"){
	die("<?xml version='1.0'?><events><error>1</error><desc>Service Not Accessible</desc></events>");
}

if( !isset($_POST['username']) || $_POST['username']==""){
	die("<?xml version='1.0'?><events><error>1</error><desc>UserId is empty</desc></events>");
}else{
    $username = $_POST['username'];

	$query_user = "SELECT ID FROM {$wpdb->prefix}users WHERE user_login='".$username."'";
	$result_user = $wpdb->get_results($query_user);
	if(count($result_user)==0){
		die("<?xml version='1.0'?><events><error>4</error><desc>Invalid Username</desc></events>");
	}else{
		$userid = $result_user[0]->ID;
	}
		
	$query = "SELECT e.* ";
	isset($org_options['use_venue_manager']) && $org_options['use_venue_manager'] == 'Y' ? $query .= ", v.name venue_name " : '';
	$query .= " FROM {$wpdb->prefix}events_detail e ";
	isset($org_options['use_venue_manager']) && $org_options['use_venue_manager'] == 'Y' ? $query .= " LEFT JOIN {$wpdb->prefix}events_venue_rel r ON r.event_id = e.id LEFT JOIN {$wpdb->prefix}events_venue v ON v.id = r.venue_id " : '';
	$query .= " WHERE e.event_status != 'D' ";
	$multi_user == true ? $query .= " AND wp_user='". $userid ."' ":'';
	$result = $wpdb->get_results($query);
	if(count($result)==0){
		die("<?xml version='1.0'?><events><error>4</error><desc>Invalid Username</desc></events>");
	}else{
		$response = "<?xml version='1.0'?><events><error>0</error><desc>Success</desc>";
		foreach ($result as $row) {
			$row->venue_title = isset($org_options['use_venue_manager']) && $org_options['use_venue_manager'] == 'Y' ? $row->venue_name : $row->venue_title;
			$response .= "<event>";
			$response .= "<id>".$row->id."</id>";
			$response .= "<event_code>".$row->event_code."</event_code>";
			$response .= "<event_name><![CDATA[".$row->event_name."]]></event_name>";
			$response .= "<event_identifier>".$row->event_identifier."</event_identifier>";
			$response .= "<start_date>".$row->start_date."</start_date>";
			$response .= "<end_date>".$row->end_date."</end_date>";
			$response .= "<venue_title><![CDATA[".$row->venue_title."]]></venue_title>";
			$response .= "</event>";
		}
		$response .= "</events>";
	
		echo $response;
	}
}