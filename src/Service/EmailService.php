<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class EmailService extends AbstractController
{
  /**
   * @var MailerInterface
   */
  private MailerInterface $mailer;

  public function __construct(
    MailerInterface $mailer
  )
  {
      $this->mailer = $mailer;
  }

  public function sendEmail($file, $emailTo)
    {
      $email = (new Email())
        ->from($this->getParameter('email_sender'))
        ->to($emailTo)
        ->attachFromPath($file)
        ->subject('Order Summary' . date("Y-m-d-H_i"))
        ->html('<p>as attached Order Summary file!</p>');
      
      try {
        $this->mailer->send($email);
        return true;
      } catch (TransportExceptionInterface $error) {
        throw $error;
      }
    }
}