<?php
declare(strict_types=1);
namespace App\Domain\Service\Mail;

use App\Enum\MailEnum;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class QueueMailHandler
{
    /**
     * @param MailerFactory $mailerFactory
     */
    public function __construct(
        private MailerFactory $mailerFactory
    ) {
    }

    /**
     * @param QueueMailMessage $message
     * @return void
     */
    public function __invoke(QueueMailMessage $message): void
    {
        sleep(1);
        $mailer = $this->mailerFactory->make(MailEnum::DEFAULT->value);

            $mailer->send(
                $message->getFrom(),
                $message->getTo(),
                $message->getSubject(),
                $message->getTemplate(),
                $message->getContext(),
                $message->getEmbed()
            );
    }
}
