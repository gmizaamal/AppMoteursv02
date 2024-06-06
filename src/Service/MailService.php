<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Psr\Log\LoggerInterface;

class MailService
{
    private MailerInterface $mailer;
    private LoggerInterface $logger;
    private string $defaultRecipient;

    public function __construct(MailerInterface $mailer, LoggerInterface $logger, string $defaultRecipient)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
        $this->defaultRecipient = $defaultRecipient;
    }

    public function sendEmail(
        string $from,
        string $subject,
        string $htmlTemplate,
        array $context,
        string $to = null
    ): void {
        $recipient = $to ?? $this->defaultRecipient;

        $email = (new TemplatedEmail())
            ->from($from)
            ->to($recipient)
            ->subject($subject)
            ->htmlTemplate($htmlTemplate)
            ->context($context);

        try {
            $this->mailer->send($email);
            $this->logger->info('Email sent successfully', [
                'from' => $from,
                'to' => $recipient,
                'subject' => $subject,
            ]);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('Failed to send email', [
                'from' => $from,
                'to' => $recipient,
                'subject' => $subject,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
