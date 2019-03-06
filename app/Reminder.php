<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{

	public static function email_queue($limit = 1000)
	{
			return \DB::table('eb_reminder')->whereRaw('UNIX_TIMESTAMP(reminder_date) <= '.time())
																			->where('alert_type','email')
																			->where('sent','no')->limit($limit)->get();
	}

	public static function sms_queue($limit = 1000)
	{
			return \DB::table('eb_reminder')->whereRaw('UNIX_TIMESTAMP(reminder_date) <= '.time())
																			->where('alert_type','sms')
																			->where('sent','no')->limit($limit)->get();
	}

	public static function mark_as_sent($reminder_id)
	{
		 return  \DB::table('eb_reminder')->where('id',$reminder_id)->update(['sent' => 'yes']);
	}


    public static function setup_notification_interval($data)
	{
			extract($data);

			$annivInfo = \App\Anniversary::info($anniv_id);

			$anniv_date = date('d F Y',strtotime($annivInfo->anniversary_date));

			$creator_name = \App\Profile::user_info($annivInfo->creator_id)->fullname;

			$reminder_dates = self::create_reminder_dates(date('d F Y'), $anniv_date, 5);

			$item_description = \App\Items::info($anniv_id,$id)->description;

			$anniv_name = $annivInfo->title;

			$permalink = url("anniversary/{$annivInfo->public_id}");


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

					$subject = "Reminder: $anniv_name - " .env('APP_NAME')."TEAM";
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
							
					return \DB::table('eb_reminder')->insert($insertParams);


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
public static function setup_confirmation_message($data)
	{
		extract($data);

		$annivInfo = \App\Anniversary::info($anniv_id);

		$anniv_date = date('d F Y',strtotime($annivInfo->anniversary_date));

		$creator_name = \App\Profile::user_info($annivInfo->creator_id)->fullname;


		$item_description = \App\Items::info($anniv_id,$id)->description;

		$anniv_name = $annivInfo->title;

		$permalink = url("anniversary/{$annivInfo->public_id}");



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

						 

						";
						$insertParams =
													[
														'item_id' => $id,
														'anniv_id'=> $annivInfo->id ,
														'subject' => $subject,
														'message' => $message ,
														'reminder_date' => now(),
														'activator_email' => $activator_email,
														'activator_phone' => $activator_phone,
														'country_code' => $country_code,
														'alert_type' => $alert_type
													] ;
						
					return \DB::table('eb_reminder')->insert($insertParams);
					

					}

				

}

}
