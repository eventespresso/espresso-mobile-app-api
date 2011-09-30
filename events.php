<?php
include_once('../wp-config.php');
include_once('../wp-load.php');
include_once('../wp-includes/wp-db.php');

//Uncomment the next line if using multiple event managers
//$multi_user = true;

if( !isset($_POST['authenticate']) || $_POST['authenticate']=="")
{
	die("<?xml version='1.0'?><events><error>1</error><desc>Service Not Accessible</desc></events>");
}
elseif($_POST['authenticate'] != "fdljgrirtgibmpkjkgffdndfj1123124")
{
	die("<?xml version='1.0'?><events><error>1</error><desc>Service Not Accessible</desc></events>");
}
if( !isset($_POST['username']) || $_POST['username']=="")
{
	die("<?xml version='1.0'?><events><error>1</error><desc>UserId is empty</desc></events>");
}
else
    $username = $_POST['username'];

	$query_user = "SELECT ID FROM {$wpdb->prefix}users WHERE user_login='".$username."'";
	$result_user = $wpdb->get_results($query_user);
	if(count($result_user)==0)
		{
			die("<?xml version='1.0'?><events><error>4</error><desc>Invalid Username</desc></events>");
		}
		else
		{
			$userid = $result_user[0]->ID;
		}
		
$query = "SELECT * FROM {$wpdb->prefix}events_detail WHERE event_status != 'D' ";
$multi_user == true ? $query .= " AND wp_user='". $userid ."' ":'';
$result = $wpdb->get_results($query);
if(count($result)==0)
		{
			die("<?xml version='1.0'?><events><error>4</error><desc>Invalid Username</desc></events>");
		}
else
{
	$response = "<?xml version='1.0'?><events><error>0</error><desc>Success</desc>";
	foreach ($result as $row) {
		$response .= "<event>";
		$response .= "<id>".$row->id."</id>";
		$response .= "<event_code>".$row->event_code."</event_code>";
		$response .= "<event_name><![CDATA[".$row->event_name."]]></event_name>";
		//$response .= "<event_desc>".$row->event_desc."</event_desc>";
		//$response .= "<display_desc>".$row->display_desc."</display_desc>";
		//$response .= "<display_reg_form>".$row->display_reg_form."</display_reg_form>";
		$response .= "<event_identifier>".$row->event_identifier."</event_identifier>";
		$response .= "<start_date>".$row->start_date."</start_date>";
		$response .= "<end_date>".$row->end_date."</end_date>";
		//$response .= "<registration_start>".$row->registration_start."</registration_start>";
		//$response .= "<registration_end>".$row->registration_end."</registration_end>";
		//$response .= "<registration_startT>".$row->registration_startT."</registration_startT>";
		//$response .= "<registration_endT>".$row->registration_endT."</registration_endT>";
		//$response .= "<visible_on>".$row->visible_on."</visible_on>";
		//$response .= "<address>".$row->address."</address>";
		//$response .= "<address2>".$row->address2."</address2>";
		//$response .= "<city>".$row->city."</city>";
		//$response .= "<state>".$row->state."</state>";
		//$response .= "<zip>".$row->zip."</zip>";
		//$response .= "<phone>".$row->phone."</phone>";
		$response .= "<venue_title><![CDATA[".$row->venue_title."]]></venue_title>";
		//$response .= "<venue_url>".$row->venue_url."</venue_url>";
		//$response .= "<venue_image>".$row->venue_image."</venue_image>";
		//$response .= "<venue_phone>".$row->venue_phone."</venue_phone>";
		//$response .= "<virtual_url>".$row->virtual_url."</virtual_url>";
		//$response .= "<virtual_phone>".$row->virtual_phone."</virtual_phone>";
		//$response .= "<reg_limit>".$row->reg_limit."</reg_limit>";
		//$response .= "<allow_multiple>".$row->allow_multiple."</allow_multiple>";
		//$response .= "<additional_limit>".$row->additional_limit."</additional_limit>";
		//$response .= "<send_mail>".$row->send_mail."</send_mail>";
		//$response .= "<send_mail>".$row->send_mail."</send_mail>";
		//$response .= "<is_active>".$row->is_active."</is_active>";
		//$response .= "<event_status>".$row->event_status."</event_status>";
		//$response .= "<conf_mail>".$row->conf_mail."</conf_mail>";
		//$response .= "<use_coupon_code>".$row->use_coupon_code."</use_coupon_code>";
		//$response .= "<use_groupon_code>".$row->use_groupon_code."</use_groupon_code>";
		//$response .= "<category_id>".$row->category_id."</category_id>";
		//$response .= "<coupon_id>".$row->coupon_id."</coupon_id>";
		//$response .= "<tax_percentage>".$row->tax_percentage."</tax_percentage>";
		//$response .= "<tax_mode>".$row->tax_mode."</tax_mode>";
		//$response .= "<member_only>".$row->member_only."</member_only>";
		//$response .= "<post_id>".$row->post_id."</post_id>";
		//$response .= "<post_type>".$row->post_type."</post_type>";
		//$response .= "<country>".$row->country."</country>";
		//$response .= "<externalURL>".$row->externalURL."</externalURL>";
		//$response .= "<early_disc>".$row->early_disc."</early_disc>";
		//$response .= "<early_disc_date>".$row->early_disc_date."</early_disc_date>";
		//$response .= "<early_disc_percentage>".$row->early_disc_percentage."</early_disc_percentage>";
		//$response .= "<question_groups>".$row->question_groups."</question_groups>";
		//$response .= "<item_groups>".$row->item_groups."</item_groups>";
		//$response .= "<event_type>".$row->event_type."</event_type>";
		//$response .= "<allow_overflow>".$row->allow_overflow."</allow_overflow>";
		//$response .= "<overflow_event_id>".$row->overflow_event_id."</overflow_event_id>";
		//$response .= "<recurrence_id>".$row->recurrence_id."</recurrence_id>";
		//$response .= "<email_id>".$row->email_id."</email_id>";
		//$response .= "<alt_email>".$row->alt_email."</alt_email>";
		//$response .= "<event_meta>".$row->event_meta."</event_meta>";
		//$response .= "<wp_user>".$row->wp_user."</wp_user>";
		$response .= "</event>";
	}
	$response .= "</events>";
	
	echo $response;
}
?>