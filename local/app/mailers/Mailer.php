<?php namespace Acme\Mailers;

use Mail;

abstract class Mailer {

	public function sendTo($user, $subject, $view, $data = [],$attachments)
	{

		Mail::queue($view, $data, function($message) use($user, $subject, $data, $attachments)
		{

			$message->to($user->email)
					->subject($subject)
					->replyTo($data['reply_to'], 'CRM System')
					->from(\Auth::user()->email,'Think Digital Solutions');

			foreach($attachments as $attachment){
				$message->attach($attachment);
			}

		});



	}
}