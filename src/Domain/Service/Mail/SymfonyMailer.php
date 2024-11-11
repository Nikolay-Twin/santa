<?php
declare(strict_types=1);
namespace App\Domain\Service\Mail;

use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use DomainException;

final class SymfonyMailer implements MailInterface
{
    private MailerInterface $mailer;

    /**
     * @param MailerInterface $mailer
     * @return void
     */
    public function setMailer(MailerInterface $mailer): void
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string|null $template
     * @param array|null $context
     * @param array|null $embed
     * @return bool
     */
    public function send(
        string $from,
        string $to,
        string $subject,
        ?string $template,
        ?array $context = [],
        ?array $embed = []
    ): bool {
        try {
            $email = (new NotificationEmail())
                ->from($from)
                ->to($to)
                ->subject($subject);

            if (!empty($template)) {
                $email->htmlTemplate($template)
                      ->context($context);
            }

            if (!empty($embed)) {
                foreach ($embed as $img) {
                    $email->embedFromPath($img['path'], $img['id'], $img['mime']);
                }
            }
            $this->mailer->send($email);
            return true;
        } catch (TransportExceptionInterface $t) {
            throw new DomainException($t->getMessage() .'Отправка почты не удалась');
        }
    }
}
