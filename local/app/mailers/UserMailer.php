<?php

namespace Acme\Mailers;

use Contact;

class UserMailer extends Mailer
{

    public function send_contact_email( Contact $contact, $data = [], $attachments=[])
    {

        $to      = 'gamal.anwar2020@gmail.com';
        $subject = $data['subject'];
        $message = $data['content'];

        $headers = "From: <gamal@think-ds.com> \n";
        $headers .= "X-Sender: <gamal@think-ds.com>\n";
        $headers .= "Reply-To: gamal@think-ds.com\r\n";
        $headers .= "X-Mailer: PHP\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        mail($to, $subject, $message, $headers, '-fnoreply@think-ds.com');

        //return $this->sendTo( $contact , $data['subject'] , 'contacts.email' , $data, $attachments);
    }

}