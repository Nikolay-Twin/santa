<?php
declare(strict_types=1);
namespace App\Domain\Service\Mail;

final readonly class QueueMailMessage
{
    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string|null $template
     * @param array|null $context
     * @param array|null $embed
     */
    public function __construct(
        private string  $from,
        private string  $to,
        private string  $subject,
        private ?string $template,
        private ?array  $context = [],
        private ?array  $embed = []
    ) {
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @return array
     */
    public function getEmbed(): array
    {
        return $this->embed;
    }
}
