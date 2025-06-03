<?php

// app/Services/SendGridService.php

namespace App\Services;

use SendGrid\Mail\Mail;
use SendGrid;

class SendGridService
{
    protected $sendgrid;

    public function __construct()
    {
        $this->sendgrid = new SendGrid(env('MAIL_PASSWORD'));
    }

    public function sendEmail($to, $subject, $body)
    {
        $email = new Mail();
        $email->setFrom("bhavikg.gc@gmail.com", "Nanogen CRM");
        $email->setSubject($subject);
        $email->addTo($to);
        $email->addContent("text/plain", $body);

        try {
            return $this->sendgrid->send($email);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        // return $this->sendgrid->send($email);
    }

    //  public function sendEmail($to, $subject, $content)
    // {
    //     $email = new Mail();
    //     $email->setFrom(env('SENDGRID_FROM_EMAIL'), env('SENDGRID_FROM_NAME'));
    //     $email->setSubject($subject);
    //     $email->addTo($to);
    //     $email->addContent("text/plain", $content);
    //     $email->addContent("text/html", nl2br($content));

    //     $sendgrid = new SendGrid(env('SENDGRID_API_KEY'));

    //     try {
    //         $response = $sendgrid->send($email);
    //         dd( $response);
    //         return $response->statusCode() === 202;
    //     } catch (\Exception $e) {
    //           dd($e->getMessage());
    //         report($e);
    //         return false;
    //     }
    // }
}
