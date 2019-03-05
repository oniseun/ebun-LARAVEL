<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    private function setup_notification($anniv_id,$item_id,$data)
	{
			extract($this->clean_post($data));

			$anniv_info = $this->anniversary_info($anniv_id);

			$anniv_date = date('d F Y',strtotime($anniv_info['anniversary_date']));

			$creator_name = $this->get_user_info($anniv_info['creator_id'])['fullname'];

			$reminder_dates = $this->create_reminder_dates(date('d F Y'), $anniv_date, 5);

			$item_description = $this->item_info($anniv_info['id'],$item_id)['description'];

			$anniv_name = $anniv_info['title'];

			$public_url = main_url("anniversary.php?anniv_id=$public_id");


			foreach($reminder_dates as $main_date):


				if($alert_type == 'sms')
				{
					
					$subject = $message = 
					"
						Hi $fullname , dont forget the \"$item_description\" you pledged to purchase for $creator_name on his $anniv_name. 
						Thank you
					";
				}
				else
				{
					$anniv_name = htmlentities($anniv_name);
					$fullname = htmlentities($fullname);
					$creator_name = htmlentities($creator_name);

					$subject = "Reminder: $anniv_name - EBUN TEAM";
					$message =
					"
						<html><head></head><body>

						  <h3>Hi $fullname ,  </h3>


						  <p>
						  		Here is to remind you of your pledge to purchase the gift item:&quot;<b> $item_description 
						  		</b>&quot;  for $creator_name on their upcoming anniversary <b> <i>$anniv_name</i></b>.
						  </p>

						  <p>	<i>The anniversary will take place on <b>$anniv_date</b> </i></p>

						  <p>	<a href=\"$public_url\"> Click here for more details </a></p>

						  <p>	Thank you </p>

						  <p>	<i> Warm regards from the EBUN team </i></p>

						  </body></html>
						";
					}

					$insert = $this->insert(

			      	[
				        'item_id' => $item_id,
				        'anniv_id'=>$anniv_info['id'],
				        'subject' => $this->escape_string($subject),
				        'message' =>$this->escape_string($message),
				        'reminder_date' => $this->now($main_date),
				        'activator_email' => $email,
				        'activator_phone' => $phone,
				        'country_code' => $country_code,
				        'alert_type' => $alert_type
			        ],

			        'eb_reminder' );

			        //print_r($data);

			endforeach;

	}

	public function clear_notifications($anniv_id,$item_id)
	{
		return $this->query("DELETE FROM eb_reminder WHERE id=$item_id AND anniv_id = $anniv_id");
	}

	private function create_reminder_dates($from_date, $to_date, $remind_count)
	{
			 
			// $from_date = '21 august 2017';
			// $to_date = '26 august 2017';

			$ts_1st = strtotime($from_date);
			$ts_2nd = strtotime($to_date);



			$difference = (($ts_2nd - $ts_1st) - 86400);

			if($difference < (86400 * 6))
			{
				$remind_count = ceil(.4 * $remind_count);
			}
			if($difference < (86400 * 3))
			{
			$remind_count = 1;
			}

			$interval = ceil($difference / $remind_count);

			$first_date =$ts_1st;
			$remind_intervals = [];

			for($i=1; $i <= $remind_count; $i++):

			$first_date+=$interval;
			$remind_intervals[] = date("d F Y",$first_date);


			endfor;

			return $remind_intervals;
	}


	// send_reset_link
public function send_confirmation_message($anniv_id,$item_id,$data)
	{
			$auth = new Auth;

			extract($this->clean_post($data));

			$anniv_info = $this->anniversary_info($anniv_id);

			$anniv_date = date('d F Y',strtotime($anniv_info['anniversary_date']));

			$creator_name = $this->get_user_info($anniv_info['creator_id'])['fullname'];


			$item_description = $this->item_info($anniv_info['id'],$item_id)['description'];

			$anniv_name = $anniv_info['title'];

			$public_url = main_url("anniversary.php?anniv_id=$public_id");



				if($alert_type == 'sms')
				{
					
					$subject = $message = 
					"
						Hi $fullname , your pledge to purchase  \"$item_description\" for $creator_name on his $anniv_name has been registered on EBUN. 
						Thank you
					";

					return $auth->send_sms($phone,$country_code,$message,'EBUN');
				}
				else
				{
					$anniv_name = htmlentities($anniv_name);
					$fullname = htmlentities($fullname);
					$creator_name = htmlentities($creator_name);

					$subject = "Gift purchase confirmation: $anniv_name - EBUN TEAM";
					$message =
					"
						<html><head></head><body>

						  <h3>Hi $fullname ,  </h3>


						  <p>
						  		Your pledge to purchase the &quot;<b> $item_description 
						  		</b>&quot;  for $creator_name on their upcoming anniversary <b> <i>$anniv_name</i></b> has been registered by EBUN.
						  </p>

						  <p>	<i>Please don't forget that the anniversary will take place on <b>$anniv_date</b> </i> and also to redeem your plegde before the anniversary date</p>

						  <p>	<a href=\"$public_url\"> Click here for more details </a></p>

						  <p>	Thank you </p>

						  <p>	<i> Warm regards from the EBUN team </i></p>

						  </body></html>
						";

						return $auth->send_email($email,$subject,$message,'reminder@ebungift.com','EBUN');
					}

				

}

}
