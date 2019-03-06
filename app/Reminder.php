<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    public static function setup_notification($anniv_id,$item_id,$data)
	{
			extact($data);

			$annivInfo = \App\Anniversary::info($anniv_id);

			$anniv_date = date('d F Y',strtotime($annivInfo->anniversary_date));

			$creator_name = \App\Profile::user_info($annivInfo->creator_id)->fullname;

			$reminder_dates = self::create_reminder_dates(date('d F Y'), $anniv_date, 5);

			$item_description = \App\Items::info($anniv_id,$id)->description;

			$anniv_name = $annivInfo->title;

			$permalink = url("anniversary/$public_id");


			foreach($reminder_dates as $main_date):


				if($alert_type == 'sms')
				{
					
					$subject = $message = 
					"
						Hi $activator_name , dont forget the \"$item_description\" you pledged to purchase for $creator_name on his $anniv_name. 
						Thank you
					";
				}
				else
				{
					$anniv_name = e($anniv_name);
					$fullname = e($activator_name);
					$creator_name = e($creator_name);

					$subject = "Reminder: $anniv_name - EBUN TEAM";
					$message =
					"
						 <h3>Hi $fullname ,  </h3>


						  <p>
						  		Here is to remind you of your pledge to purchase the gift item:&quot;<b> $item_description 
						  		</b>&quot;  for $creator_name on their upcoming anniversary <b> <i>$anniv_name</i></b>.
						  </p>

						  <p>	<i>The anniversary will take place on <b>$anniv_date</b> </i></p>

						  <p>	<a href=\"$permalink\"> Click here for more details </a></p>

						  <p>	Thank you </p>

						  <p>	<i> Warm regards from the EBUN team </i></p>

						";
					}

					$insertParams =

			      	[
				        'item_id' => $id,
				        'anniv_id'=>$annivInfo->id ,
				        'subject' => $subject,
				        'message' => $message ,
				        'reminder_date' => mysql_timestamp($main_date),
				        'activator_email' => $activator_email,
				        'activator_phone' => $activator_phone,
				        'country_code' => $country_code,
				        'alert_type' => $alert_type
			        ] ;
							
						\DB::table('eb_reminder')->insert($insertParams);

			        //print_r($data);

			endforeach;

	}

	public static function clear_notifications($anniv_id,$item_id)
	{
		return \DB::table('eb_reminder')->where('anniv_id',$anniv_id)->where('id',$item_id)->where('anniv_id',$anniv_id)->delete();

	}

	private static function create_reminder_dates($from_date, $to_date, $remind_count)
	{
			 

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
		extact($data);

		$annivInfo = \App\Anniversary::info($anniv_id);

		$anniv_date = date('d F Y',strtotime($annivInfo->anniversary_date));

		$creator_name = \App\Profile::user_info($annivInfo->creator_id)->fullname;

		$reminder_dates = self::create_reminder_dates(date('d F Y'), $anniv_date, 5);

		$item_description = \App\Items::info($anniv_id,$id)->description;

		$anniv_name = $annivInfo->title;

		$permalink = url("anniversary/$public_id");



				if($alert_type == 'sms')
				{
					
					$subject = $message = 
					"
						Hi $activator_name , dont forget the \"$item_description\" you pledged to purchase for $creator_name on his $anniv_name. 
						Thank you
					";

					return \App\Auth::send_sms($activator_phone,$country_code,$message,'EBUN');
				}
				else
				{

					$anniv_name = e($anniv_name);
					$fullname = e($activator_name);
					$creator_name = e($creator_name);

					$subject =  "Gift purchase confirmation: $anniv_name - ".env('APP_NAME')." TEAM";
					$message =
					"
						 
						 <h3>Hi $fullname ,  </h3>


						 <p>
								 Your pledge to purchase the &quot;<b> $item_description 
								 </b>&quot;  for $creator_name on their upcoming anniversary <b> <i>$anniv_name</i></b> has been registered by EBUN.
						 </p>

						 <p>	<i>Please don't forget that the anniversary will take place on <b>$anniv_date</b> </i> and also to redeem your plegde before the anniversary date</p>

						 <p>	<a href=\"$permalink\"> Click here for more details </a></p>

						 <p>	Thank you </p>

						 <p>	<i> Warm regards from the EBUN team </i></p>

						";


						return $auth->send_email($email,$subject,$message,'reminder@ebungift.com','EBUN');
					}

				

}

}
